<?php
/**
 * 图片上传和转换API
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// 加载配置
$config = require_once 'config.php';

// 响应函数
function sendResponse($success, $data = null, $error = null) {
    echo json_encode([
        'success' => $success,
        'data' => $data,
        'error' => $error
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// 检查是否为POST请求
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, null, '仅支持POST请求');
}

// 检查是否有文件上传
if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    $errorMsg = '没有文件上传';
    if (isset($_FILES['image']['error'])) {
        switch ($_FILES['image']['error']) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $errorMsg = '文件太大';
                break;
            case UPLOAD_ERR_PARTIAL:
                $errorMsg = '文件上传不完整';
                break;
            case UPLOAD_ERR_NO_FILE:
                $errorMsg = '没有文件上传';
                break;
            default:
                $errorMsg = '文件上传失败';
        }
    }
    sendResponse(false, null, $errorMsg);
}

$uploadedFile = $_FILES['image'];

// 获取文件信息
$originalName = $uploadedFile['name'];
$tmpPath = $uploadedFile['tmp_name'];
$fileSize = $uploadedFile['size'];

// 检查文件大小
if ($fileSize > $config['max_file_size']) {
    sendResponse(false, null, '文件大小超过限制（最大10MB）');
}

// 获取文件扩展名
$pathInfo = pathinfo($originalName);
$extension = strtolower($pathInfo['extension'] ?? '');

// 检查文件类型
if (!in_array($extension, $config['allowed_types'])) {
    sendResponse(false, null, '不支持的文件类型');
}

// 生成唯一文件名
$timestamp = time();
$randomStr = bin2hex(random_bytes(8));
$originalFileName = $timestamp . '_' . $randomStr . '.' . $extension;
$convertedFileName = $timestamp . '_' . $randomStr . '.' . $config['output_format'];

// 确保目录存在
if (!is_dir($config['upload_dir'])) {
    mkdir($config['upload_dir'], 0755, true);
}
if (!is_dir($config['converted_dir'])) {
    mkdir($config['converted_dir'], 0755, true);
}

// 保存原始文件
$originalFilePath = $config['upload_dir'] . $originalFileName;
if (!move_uploaded_file($tmpPath, $originalFilePath)) {
    sendResponse(false, null, '文件保存失败');
}

// 转换图片
$convertedFilePath = $config['converted_dir'] . $convertedFileName;

try {
    // 检查ImageMagick是否可用
    $checkCommand = 'which magick 2>&1';
    exec($checkCommand, $checkOutput, $checkReturn);
    
    $useMagick = ($checkReturn === 0);
    
    if ($useMagick) {
        // 使用ImageMagick转换
        $quality = $config['output_quality'];
        $command = sprintf(
            'magick convert %s -quality %d %s 2>&1',
            escapeshellarg($originalFilePath),
            $quality,
            escapeshellarg($convertedFilePath)
        );
        
        exec($command, $output, $returnCode);
        
        if ($returnCode !== 0) {
            // 如果magick命令失败，尝试使用convert命令
            $command = sprintf(
                'convert %s -quality %d %s 2>&1',
                escapeshellarg($originalFilePath),
                $quality,
                escapeshellarg($convertedFilePath)
            );
            
            exec($command, $output, $returnCode);
            
            if ($returnCode !== 0) {
                throw new Exception('图片转换失败: ' . implode("\n", $output));
            }
        }
    } else {
        // 如果ImageMagick不可用，尝试使用GD库
        $convertSuccess = false;
        
        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                $image = @imagecreatefromjpeg($originalFilePath);
                break;
            case 'png':
                $image = @imagecreatefrompng($originalFilePath);
                break;
            case 'gif':
                $image = @imagecreatefromgif($originalFilePath);
                break;
            case 'bmp':
                $image = @imagecreatefrombmp($originalFilePath);
                break;
            case 'webp':
                $image = @imagecreatefromwebp($originalFilePath);
                break;
            default:
                throw new Exception('不支持的图片格式，需要安装ImageMagick来处理HEIC文件');
        }
        
        if ($image === false) {
            throw new Exception('无法读取图片文件');
        }
        
        // 保存为JPG
        $convertSuccess = imagejpeg($image, $convertedFilePath, $config['output_quality']);
        imagedestroy($image);
        
        if (!$convertSuccess) {
            throw new Exception('图片转换失败');
        }
    }
    
    // 检查转换后的文件是否存在
    if (!file_exists($convertedFilePath)) {
        throw new Exception('转换后的文件不存在');
    }
    
    // 生成下载URL
    $basePath = $config['base_path'] ?? '';
    $downloadUrl = $config['site_host'] . $basePath . $config['converted_url_path'] . $convertedFileName;
    
    // 返回成功响应
    sendResponse(true, [
        'originalFile' => $originalFileName,
        'convertedFile' => $convertedFileName,
        'downloadUrl' => $downloadUrl,
        'fileSize' => filesize($convertedFilePath)
    ]);
    
} catch (Exception $e) {
    // 删除已上传的原始文件
    if (file_exists($originalFilePath)) {
        @unlink($originalFilePath);
    }
    
    // 删除可能存在的转换文件
    if (file_exists($convertedFilePath)) {
        @unlink($convertedFilePath);
    }
    
    sendResponse(false, null, $e->getMessage());
}
