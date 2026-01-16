# UP图片转换工具

一个简单易用的图片格式转换工具，支持HEIC、PNG、JPG等多种格式自动转换为JPG格式。

## 功能特点

- ✨ 支持多张图片同时上传
- 📸 支持HEIC/HEIF格式（需要ImageMagick）
- 🔄 自动转换为JPG格式
- 📥 一键下载转换后的图片
- 🎨 美观的拖拽上传界面

## 技术栈

- 前端：纯HTML + CSS + JavaScript
- 后端：PHP
- 图片处理：ImageMagick (magick命令) 或 GD库

## 安装步骤

### 1. 环境要求

- PHP 7.4 或更高版本
- ImageMagick（推荐，用于HEIC格式支持）

### 2. 安装ImageMagick

**macOS:**
```bash
brew install imagemagick
```

**Ubuntu/Debian:**
```bash
sudo apt-get update
sudo apt-get install imagemagick
```

**CentOS/RHEL:**
```bash
sudo yum install ImageMagick
```

### 3. 配置

编辑 `config.php` 文件，设置您的网站域名：

```php
'site_host' => 'http://your-domain.com',
```

### 4. 目录权限

确保上传目录有写入权限：

```bash
chmod -R 755 public/uploads/
```

## 使用方法

### 本地开发

使用PHP内置服务器：

```bash
cd image-converter
php -S localhost:8080
```

然后在浏览器中访问：`http://localhost:8080`

### 生产环境

将项目部署到支持PHP的Web服务器（如Apache或Nginx）。

确保配置正确的 `site_host` 和目录权限。

## 目录结构

```
image-converter/
├── index.html              # 前端页面
├── upload.php              # 上传和转换API
├── config.php              # 配置文件
├── README.md              # 说明文档
└── public/
    └── uploads/
        ├── original/       # 原始上传文件
        └── converted/      # 转换后的文件
```

## API接口

### POST /upload.php

上传并转换图片

**请求参数：**
- `image`: 图片文件（multipart/form-data）

**响应示例：**
```json
{
  "success": true,
  "data": {
    "originalFile": "1234567890_abc123.heic",
    "convertedFile": "1234567890_abc123.jpg",
    "downloadUrl": "http://localhost:8080/public/uploads/converted/1234567890_abc123.jpg",
    "fileSize": 245678
  }
}
```

## 支持的格式

- JPG/JPEG
- PNG
- GIF
- BMP
- WebP
- HEIC/HEIF（需要ImageMagick）

## 配置选项

在 `config.php` 中可以配置：

- `site_host`: 网站域名
- `max_file_size`: 最大文件大小（默认10MB）
- `output_format`: 输出格式（默认jpg）
- `output_quality`: 输出质量（1-100，默认85）

## 故障排除

### HEIC文件无法转换

确保已安装ImageMagick：
```bash
which magick
```

如果没有安装，请按照上面的安装步骤安装。

### 上传失败

检查目录权限：
```bash
ls -la public/uploads/
```

确保Web服务器用户有写入权限。

### 文件大小限制

编辑PHP配置（php.ini）：
```ini
upload_max_filesize = 10M
post_max_size = 10M
```

## License

MIT

## 作者

Created with ❤️
