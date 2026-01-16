<?php
/**
 * 图片转换工具配置文件
 */

return [
    // 网站域名（用于生成下载链接）
    'site_host' => 'https://tool.yzitc.com',
    
    // 基础路径（如果部署在子目录下，例如：/image-converter/）
    'base_path' => '/image-converter',
    
    // 上传目录配置
    'upload_dir' => __DIR__ . '/public/uploads/original/',
    'converted_dir' => __DIR__ . '/public/uploads/converted/',
    
    // URL路径配置（会自动加上 base_path）
    'upload_url_path' => '/public/uploads/original/',
    'converted_url_path' => '/public/uploads/converted/',
    
    // 允许上传的文件类型
    'allowed_types' => ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'heic', 'heif'],
    
    // 文件大小限制（单位：字节，默认10MB）
    'max_file_size' => 10 * 1024 * 1024,
    
    // 转换后的图片格式
    'output_format' => 'jpg',
    
    // 转换后的图片质量（1-100）
    'output_quality' => 85,
];
