<?php
// データベース (Database setting)
define('dbType', "MySQL"); // MySQL(MariaDB) or sqlite
define('dbServer', "localhost");
define('dbUser', "Database user name");
define('dbPass', "Database password");
define('dbName', "Database name");
define('dbCharset', "utf8");
define('sqlitePath', ""); // Please enter the full path on the server when using sqlite.

// サイト設定 (Site setting)
$qst = explode("&", $_SERVER["QUERY_STRING"]);
$lang = in_array("lang=en-us", $qst) ? "en-us" : "ja";
$site_name = $lang === "en-us" ? "Please enter an English site name" : 'Please enter Japanese site name';

if ($_SERVER['SERVER_NAME'] === "URL for test environment") {
	define('SERVER_PATH','Full path of server');
} else if ($_SERVER['SERVER_NAME'] === "URL for local environment") {
	define('SERVER_PATH','Full path of server');
} else {
	define('SERVER_PATH','Full path of server');
}

// 関数ファイルの読み込み (Load function file)
require_once(dirname(__FILE__) . "/include_app/inc_fnc_common.php");