<?php

//Start PHP Session
session_start();

//Start PHP output buffering
ob_start();
header('P3P: CP="CAO PSA OUR"');
setlocale(LC_ALL, 'en_US.UTF8');
set_time_limit(60);

ini_set("post_max_size","31M");
ini_set("upload_max_filesize","10M");

iconv_set_encoding("internal_encoding", "UTF-8");
iconv_set_encoding("input_encoding", "UTF-8");
iconv_set_encoding("output_encoding", "UTF-8");
iconv_set_encoding("default_charset", "UTF-8");
mb_internal_encoding("UTF-8");
mb_http_output ("UTF-8");
?>
<html>
	<head>
		<title>
			Page Contextualizer
		</title>
		<link rel='stylesheet' type='text/css' href='./inc/bootstrap/css/bootstrap.min.css?1375635029'/>
		<style type="text/css">
			body{
				margin:0;
				padding:0;
			}
		</style>
	</head>
	<frameset rows="50,100,*" border="0" frameborder="0">
		<frame name="form" id="form" src="form.php" scrolling="no">
		<frame name="footer" id="footer" src="footer.php" scrolling="auto">
		<frame name="content" id="content" src="content.php">
	</frameset><noframes></noframes>
</html>
