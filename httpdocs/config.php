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
$site_name = 'Enter the site name';

if ($_SERVER['SERVER_NAME'] === "URL for test environment") {
	define('SERVER_PATH','Full path of server');
} else if ($_SERVER['SERVER_NAME'] === "URL for local environment") {
	define('SERVER_PATH','Full path of server');
} else {
	define('SERVER_PATH','Full path of server');
}
