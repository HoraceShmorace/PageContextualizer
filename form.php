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
		<link rel='stylesheet' type='text/css' href='./inc/bootstrap/css/bootstrap.min.css'/>
		<style type="text/css">
			body,.navbar{
				background-color:#333;
			}
		</style>
	</head>
	<body>
		<div class="navbar"> <a class="navbar-brand" href="#"> Page <span style="color:orange">Contextualizer</span> 
		  </a> 
		  <form class="navbar-form" action="content.php" target="content">
			<input class="form-control" type="text" name="url" id="url" style="width:500px;" placeholder="Enter URL of a page to scan..."/>
			<button type="submit" class="btn btn-primary">Load</button>
		  </form>
		</div>
	</body>
</html>
