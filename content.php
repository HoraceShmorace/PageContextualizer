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

require_once(realpath('./inc/contextualizer.php'));
?>
<html>
	<head>
		<title>
			
		</title>
		<link rel='stylesheet' type='text/css' href='./inc/bootstrap/css/bootstrap.min.css'/>
		<style type="text/css">
			body{
				background-color:#eee;
				margin:20px;
			}
			h5{
				color:#888;
				font-weight:normal;
			}
			h6{
				color:#777;
				font-variant:small-caps;
				font-weight:bold;
				text-transform:uppercase;
			}
			.panel > .list-group{
				padding:0;
			}
			.list-group-item:first-child{
				border-top:0px none transparent;
			}
			.list-group-item:last-child{
				border-top:0px none transparent;
			}
			.list-group-item{
				border-left:0px none transparent;
				border-right:0px none transparent;
			}
			.list-group-item .badge{
				cursor:hand;
			}
		</style>
	</head>
	<body>
		<?php 
		if(isset($_REQUEST["url"]) && trim($_REQUEST["url"])!=""){
			$context = new Contextualizer($_REQUEST["url"]);
		?>
		<div class="container">
			<h6>Page Scanned</h6>
			<h2><?php echo $context->title;?></h2>
			<h5><?php echo $context->url;?></h5>
			<div class="row">
				<div class="col-lg-6"> 
					<h3>Page Data</h3>
					<div class="panel"> 
						<h4>
							Meta Description
						</h4>
						<ul class="list-group">
							 <?php echo $context->meta_description;?>
						</ul>

						<h4>
							Meta Keywords
						</h4>
						<ul class="list-group">
							 <?php echo $context->meta_keywords;?>
						</ul>

						<h4>
							Body Text (sanitized)
						</h4>
						<ul class="list-group">
							<textarea style="width:100%;height:300px"> <?php echo $context->body;?></textarea>
						</ul>
					</div>
				</div>
							
				<div class="col-lg-6"> 
					<h3>Context</h3>
					<div class="panel"> 
						<div class="panel-heading">
							Keywords found in Title tag.
						</div>
						<ul class="list-group">
							<?php if(is_array($context->matches->title) && count($context->matches->title)>0){foreach($context->matches->title as $k=>$v){?>
								<li class="list-group-item"><strong><?php echo $k;?></strong><span class="badge pull-right" title="This keyword was found <?php echo $v;?> times."><?php echo $v;?></span></li>
							<?php }}else echo "NONE"?>
						</ul>
					</div>

					<div class="panel"> 
						<div class="panel-heading">
							Keywords found in Meta "keywords."
						</div>
						<ul class="list-group">
							<?php if(is_array($context->matches->meta_keywords) && count($context->matches->meta_keywords)>0){foreach($context->matches->meta_keywords as $k=>$v){?>
								<li class="list-group-item"><strong><?php echo $k;?></strong><span class="badge pull-right" title="This keyword was found <?php echo $v;?> times."><?php echo $v;?></span></li>
							<?php }}else echo "NONE"?>
						</ul>
					</div>

					<div class="panel"> 
						<div class="panel-heading">
							Keywords found in Meta "description."
						</div>
						<ul class="list-group">
							<?php if(is_array($context->matches->meta_description) && count($context->matches->meta_description)>0){foreach($context->matches->meta_description as $k=>$v){?>
								<li class="list-group-item"><strong><?php echo $k;?></strong><span class="badge pull-right" title="This keyword was found <?php echo $v;?> times."><?php echo $v;?></span></li>
							<?php }}else echo "NONE"?>
						</ul>
					</div>

					<div class="panel"> 
						<div class="panel-heading">
							Keywords found in Body text.
						</div>
						<ul class="list-group">
							<?php if(is_array($context->matches->body) && count($context->matches->body)>0){foreach($context->matches->body as $k=>$v){?>
								<li class="list-group-item"><strong><?php echo $k;?></strong><span class="badge pull-right" title="This keyword was found <?php echo $v;?> times."><?php echo $v;?></span></li>
							<?php }}else echo "NONE"?>
						</ul>
					</div>

					<div class="well hide">
						<h4>Video Database Keywords</h4>
						<p>Videos in our DB would be tagged with these keywords.</p>
						<?php
						$tags = split(",",$context->tags);
						foreach($tags as $t){?>
							<span class="label label-info" style="margin-bottom:5px;"><?php echo $t;?></span>
						<?php }?>
					</div>
				</div>
			</div>
		</div>
		<?php }?>
	</body>
</html>
