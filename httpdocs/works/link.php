<?php
require_once(dirname(__FILE__) . "/../config.php");
require_once(dirname(__FILE__) . "/../include_app/database.php");
$dbc = new dbc();
require_once(dirname(__FILE__) . "/../include_app/inc_fnc_common.php");
if (isset($_GET['works_variation_id']) && is_numeric($_GET['works_variation_id']) || isset($_GET['lang'])) {
	if (isset($_GET['lang']) && $_GET['lang'] === $lang) {
		$linkLang = "?lang={$lang}";
	} else {
		$linkLang = "";
	}
	// variation
	$sql_variation = "SELECT * FROM works_variation WHERE works_variation_id = ? AND works_variation_open_flag = ?";
	$param = array((int)$_GET["works_variation_id"], 1);
	$works_variation = $dbc->getRow($sql_variation, $param);
	$rows_variation = count($sql_variation);
	if (!is_clawler()) {
		// sql insert
		$sql_insert = "INSERT INTO works_download(date, ip, works_variation_id, user_agent) VALUES(now(), INET_ATON('{$_SERVER["REMOTE_ADDR"]}'), '{$_GET["works_variation_id"]}', '{$_SERVER["HTTP_USER_AGENT"]}')";
		$works_download = $dbc->insertRowOnce($sql_insert);
		$rows_download = array($sql_insert);
	}
	// mogura
	if ($_SERVER['SERVER_NAME'] === "euli-haruna.test") {
		define('MOGURA_PATH','/var/www/vhosts/euli-haruna.test/httpdocs/mogura/');
	} else if ($_SERVER['SERVER_NAME'] === "euli-haruna.example") {
		define('MOGURA_PATH','D:/vhosts/euli-haruna.example/public_html/euli-haruna.com/mogura/');
	} else {
		define('MOGURA_PATH','/home/zkfcycdb/public_html/euli-haruna.com/mogura/');
	}
	include_once(constant("MOGURA_PATH").'w.php');
	// location
	foreach($works_variation as $row3) {
		$url = $row3["works_variation_url"];
		$works_id = $row3["works_id"];
		$works_variation_id = $row3["works_variation_id"];
	}
	$dbc->Disconnect();
	if (substr($url, 0, 4) === "http") {
		header("Location: ".$url);
		exit;
	} else {
		header("Location: /works/" . (int)$works_id . "-" . (int)$works_variation_id . ".html" . $linkLang);
		exit;
	}
} else {
	header("Location: /works/");
	exit;
}