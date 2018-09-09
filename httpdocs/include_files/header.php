<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $page_title." - ".$site_name; ?></title>
<link rel="stylesheet" href="/css/common.css" type="text/css" media="screen,print">
<link rel="stylesheet" href="/css/common_mq.css" type="text/css">
<link rel="stylesheet" href="/css/meanmenu.css" media="all">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="/js/jquery.meanmenu.min.js"></script>
<script>
jQuery(document).ready(function () {
	jQuery('#menu nav').meanmenu();
});
</script>
<?php
echo $customHead;
?>
<meta property="og:url" content="<?php echo (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]; ?>">
<meta property="og:type" content="website">
<meta property="og:description" content="Please enter ogp description.">
<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="Twitter account">
</head>
<body>
<div id="container">
	<div id="wrapper">
		<div id="header">
			<p id="logo"><img src="/images/logo03.gif" srcset="/images/logo03.gif 1x, /images/logo03@2x.gif 2x" alt="Logo alt text"></p>
		</div>
		<div id="contents">
			<div id="side">
				<?php include_once(dirname(__FILE__) . "/../include_files/page_menu.php"); ?>
			<!-- /side --></div>
