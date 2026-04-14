<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

// 获取访问者IP地址
function getClientIP() {
    $ip = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    } elseif (isset($_SERVER['HTTP_X_REAL_IP']) && !empty($_SERVER['HTTP_X_REAL_IP'])) {
        $ip = $_SERVER['HTTP_X_REAL_IP'];
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return trim($ip);
}

// 获取访问者信息
$visitorInfo = [
    'ip' => getClientIP(),
    'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '',
    'referer' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '直接访问',
    'accept_language' => isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : '',
    'accept_encoding' => isset($_SERVER['HTTP_ACCEPT_ENCODING']) ? $_SERVER['HTTP_ACCEPT_ENCODING'] : '',
    'host' => isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '',
    'protocol' => isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : '',
    'request_method' => isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : '',
    'request_time' => date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']),
    'server_name' => isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '',
    'server_port' => isset($_SERVER['SERVER_PORT']) ? $_SERVER['SERVER_PORT'] : '',
    'connection' => isset($_SERVER['HTTP_CONNECTION']) ? $_SERVER['HTTP_CONNECTION'] : '',
    'accept' => isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : '',
    'dnt' => isset($_SERVER['HTTP_DNT']) ? $_SERVER['HTTP_DNT'] : '未设置',
    'upgrade_insecure_requests' => isset($_SERVER['HTTP_UPGRADE_INSECURE_REQUESTS']) ? $_SERVER['HTTP_UPGRADE_INSECURE_REQUESTS'] : '未设置',
];

// 获取所有请求头
$headers = [];
foreach ($_SERVER as $key => $value) {
    if (strpos($key, 'HTTP_') === 0) {
        $headerName = str_replace('HTTP_', '', $key);
        $headerName = str_replace('_', '-', $headerName);
        $headerName = ucwords(strtolower($headerName), '-');
        $headers[$headerName] = $value;
    }
}
$visitorInfo['all_headers'] = $headers;

echo json_encode($visitorInfo, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
