<!DOCTYPE HTML> 
<html>
<head>
<title>youtube封面提取 - 好用的油管视频封面在线提取工具</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="keywords" content="油管封面提取,油管封面在线提取,油管视频封面提取,视频封面,提取,youtube视频封面,youtube封面提取,油管专栏封面,油管文章封面">
<meta data-hid="description" name="description" content="youtube视频封面在线提取器，可以根据油管视频链接，提取视频封面并进行下载，看到好看的封面不知道怎么提取怎么办？油管视频封面提取器帮你解决！">
<meta name="author" content="www.shejibiji.com">
<link rel="icon" type="image/x-icon" href="/favicon.png">
<style>
</style>
</head>
<body>
<?php
	$yurl = isset($_POST['yurl'])? test_input($_POST["yurl"]) : '';
	function test_input($data)
	{	
		$replace = '';
		$ytb = 'https://www.youtube.com/watch?v=';
		$data = str_ireplace($ytb, $replace, $data);
		$data = trim($data); //删除两端空白字符
		return $data;
	}
	?>
	<h2>油管视频封面提取工具<a href="https://www.shejibiji.com">@设计笔记</a></h2>
	<form action="" method="post">
		<input placeholder="请输入油管视频播放地址" type="text" name="yurl" value="<?php echo $yurl;?>">
		<input type="submit" value="提交">
	</form>
	<?php
	if($yurl) {
		echo '<p>超清图：</p>';
		echo '<p><img src="https://i3.ytimg.com/vi/' . $yurl . '/maxresdefault.jpg"></p>';
		echo '<p>高清图：</p>';
		echo '<p><img src="https://i3.ytimg.com/vi/' . $yurl . '/hqdefault.jpg"></p>';
	} else {
	?>
		<p>图片将在这里显示</p>
	<?php
	}
?>
</body>
</html>