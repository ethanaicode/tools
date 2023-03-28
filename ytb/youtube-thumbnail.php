<?php
function get_video_id($url)
{
    $video_id = '';
    $url = trim($url);
    if (preg_match('/^([a-zA-Z0-9_-]{11})$/', $url)) {  // standard video ID
        $video_id = $url;
    } else if (preg_match('/^https?:\/\/(?:www\.)?youtube.com\/watch\?v=([a-zA-Z0-9_-]{11})/', $url, $matches)) {  // full URL
        $video_id = $matches[1];
    } else if (preg_match('/^https?:\/\/youtu.be\/([a-zA-Z0-9_-]{11})/', $url, $matches)) {  // short URL
        $video_id = $matches[1];
    }
    return $video_id;
}

function log_data($data)
{
    if (!empty($data)) {
        $filename = "log.txt";
        $data = "[" . date('Y-m-d H:i:s') . "] " . $data . "\n";
        file_put_contents($filename, $data, FILE_APPEND);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $yurl = get_video_id($_POST["yurl"]);
} else {
    $yurl = '';
}

if (!empty($yurl)) {
    $html1 = '<p class="thumbnail-title">超清图：</p>' . "\n" . '<div class="thumbnail-image-container"><img src="https://i3.ytimg.com/vi/' . $yurl . '/maxresdefault.jpg"  class="thumbnail-image"></div>' . "\n";
    $html2 = '<p class="thumbnail-title">高清图：</p>' . "\n" . '<div class="thumbnail-image-container"><img src="https://i3.ytimg.com/vi/' . $yurl . '/hqdefault.jpg"  class="thumbnail-image"></div>';
    $html = $html1 . $html2;
} else {
    $html = '<p>传入的链接不正确</p>';
}

log_data($yurl);

echo $html;
