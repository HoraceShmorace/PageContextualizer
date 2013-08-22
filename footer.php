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
			body{
				background-color:#ccc;
				margin:10px 20px;
			}
		</style>
	</head>
	<body>
		This proof of concept will load a web page, and discern the context of its content. 
		The page is scraped for the title, meta tags, and body text (sanitized to remove
		&lt;script&gt;, &lt;noscript&gt;, &lt;style&gt;, and &lt;link&gt; tags). This data is then searched against a database of known keywords
		(in the finished product, videos would be tagged with these keywords). The matches would need to be weighted according to a match's location (title tag vs. body tag vs. etc.) and frequency. The matches and weights would be cached for each scraped URL.
	</body>
</html>
