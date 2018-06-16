<?php
if (! isset($_GET['works_id'])) {
	$sql = "SELECT * FROM works WHERE works_open_flag = '1' ORDER BY works_id DESC";
	$worksDigest = $mysql->query($sql);
	if ($mysql->errorno()>0){//エラーチェック
		$strErrMsg=STR_MYSQL_QUERY_ERR .$mysql->errors();
	}
	$recordCountSql = "SELECT COUNT(*) AS cnt FROM works;";
	$recordCount = $mysql->query($recordCountSql);
	if ($mysql->errorno()>0){//エラーチェック
		$strErrMsg=STR_MYSQL_QUERY_ERR .$mysql->errors();
	}
	$recordCountRows = $mysql->fetch($recordCount);
	$countRows = $recordCountRows["cnt"];
} else {
	$sql = "SELECT * FROM works WHERE works_id = '{$_GET["works_id"]}' AND works_open_flag = '1'";
	$works = $mysql->query($sql);
	if ($mysql->errorno()>0){//エラーチェック
		$strErrMsg=STR_MYSQL_QUERY_ERR .$mysql->errors();
	}
	// update
	$sql_update = "SELECT * FROM works_update WHERE works_id = '{$_GET["works_id"]}' ORDER BY works_update_id DESC";
	$works_update = $mysql->query($sql_update);
	if ($mysql->errorno()>0){//エラーチェック
		$strErrMsg=STR_MYSQL_QUERY_ERR .$mysql->errors();
	}
	$rows = $mysql->rows($sql_update);
	// variation
	$sql_variation = "SELECT * FROM works_variation
LEFT JOIN regist_site ON works_variation.regist_site_id = regist_site.regist_site_id
WHERE works_id = '{$_GET["works_id"]}' AND works_variation_open_flag = '1'";
	$works_variation = $mysql->query($sql_variation);
	if ($mysql->errorno()>0){//エラーチェック
		$strErrMsg=STR_MYSQL_QUERY_ERR .$mysql->errors();
	}
	$rows_variation = $mysql->rows($sql_variation);
	// player
	if (isset($_GET['works_variation_id']) && $_GET['works_variation_id'] > 0) {
		$sql_player = "SELECT * FROM works_variation
WHERE works_variation_id = '{$_GET["works_variation_id"]}'";
		$works_player = $mysql->query($sql_player);
		if ($mysql->errorno()>0){//エラーチェック
			$strErrMsg=STR_MYSQL_QUERY_ERR .$mysql->errors();
		}
		$rows_player = $mysql->rows($sql_player);
	}
}
