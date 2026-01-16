# 子目录部署配置说明

## 项目路径配置

本项目已支持部署在子目录下（如 `example.com/image-converter/`）。

### 1. 配置步骤

#### 修改 config.php

编辑 `config.php` 文件，修改以下配置：

```php
return [
    // 网站域名（用于生成下载链接）
    'site_host' => 'https://example.com',  // 改为你的域名
    
    // 基础路径（如果部署在子目录下）
    'base_path' => '/image-converter',  // 改为你的子目录路径，根目录则设为 ''
    
    // ... 其他配置保持不变
];
```

#### 配置示例

**部署在根目录** (`example.com/`)：
```php
'site_host' => 'https://example.com',
'base_path' => '',
```

**部署在子目录** (`example.com/image-converter/`)：
```php
'site_host' => 'https://example.com',
'base_path' => '/image-converter',
```

**部署在多级子目录** (`example.com/tools/image-converter/`)：
```php
'site_host' => 'https://example.com',
'base_path' => '/tools/image-converter',
```

### 2. 前端自动路径检测

前端 `index.html` 已实现自动路径检测：
- 会自动检测当前页面的路径
- 所有 API 请求会自动加上正确的路径前缀
- 二维码图片路径也会自动调整

### 3. Web 服务器配置

#### Apache (.htaccess)

如果使用 Apache，在项目根目录创建 `.htaccess`：

```apache
# 如果 image-converter 是子目录
RewriteEngine On
RewriteBase /image-converter/

# 如果文件不存在，重定向到 index.html
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.html [L]
```

#### Nginx

如果使用 Nginx，配置示例：

```nginx
location /image-converter/ {
    alias /path/to/your/project/tools/image-converter/;
    index index.html;
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $request_filename;
    }
}
```

### 4. 测试

部署后，访问：
- 主页：`https://example.com/image-converter/`
- 上传接口：`https://example.com/image-converter/upload.php`
- 下载链接：`https://example.com/image-converter/public/uploads/converted/xxx.jpg`

### 5. 本地测试

本地测试时，可以使用 PHP 内置服务器：

```bash
cd /path/to/image-converter
php -S localhost:8080
```

访问 `http://localhost:8080` 即可（此时 `base_path` 应设为 `''`）

### 6. 常见问题

**Q: 下载链接404？**
A: 检查 `config.php` 中的 `site_host` 和 `base_path` 是否配置正确。

**Q: 上传失败？**
A: 检查 `public/uploads/` 目录权限（应该是 755）。

**Q: API 请求 404？**
A: 确保 Web 服务器正确配置了 PHP 处理，且路径重写规则正确。
