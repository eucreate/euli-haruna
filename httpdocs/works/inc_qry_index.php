<?php
if (! isset($_GET['works_id'])) {
	$sql = "SELECT * FROM works WHERE works_open_flag = ? ORDER BY works_id DESC";
	$param = array(1);
	$worksDigest = $dbc->getRow($sql, $param);
	$countRows = count($worksDigest);
} else {
	$sql = "SELECT * FROM works WHERE works_id = ? AND works_open_flag = ?";
	$param = array($_GET["works_id"], 1);
	$works = $dbc->getRow($sql, $param);
	// update
	$sql_update = "SELECT * FROM works_update WHERE works_id = ? ORDER BY works_update_id DESC";
	$param = array($_GET["works_id"]);
	$works_update = $dbc->getRow($sql_update, $param);
	// variation
	$sql_variation = "SELECT * FROM works_variation LEFT JOIN regist_site ON works_variation.regist_site_id = regist_site.regist_site_id WHERE works_id = ? AND works_variation_open_flag = ?";
	$param = array($_GET["works_id"], 1);
	$works_variation = $dbc->getRow($sql_variation, $param);
	// player
	if (isset($_GET['works_variation_id']) && $_GET['works_variation_id'] > 0) {
		$sql_player = "SELECT * FROM works_variation WHERE works_variation_id = ?";
		$param = array($_GET["works_variation_id"]);
		$works_player = $dbc->getRow($sql_player, $param);
	}
}
