<?php
if (! isset($_GET['works_id'])) {
	$dateGet = "SELECT DISTINCT DATE_FORMAT(works_regist_date,'%Y') as year FROM works WHERE works_open_flag = 1";
	$getYear = $dbc->getRowOnce($dateGet);
	if (isset($_POST['year']) && $_POST['year'] != "all") {
		$searchYear = " AND DATE_FORMAT(works_regist_date, '%Y') = {$_POST['year']}";
	} else {
		$searchYear = "";
	}
	if (isset($_POST['date']) && $_POST['date'] === "DESC") {
		$option = "works_regist_date DESC";
	} else if (isset($_POST['date']) && $_POST['date'] === "ASC") {
		$option = "works_regist_date ASC";
	} else {
		$option = "works_regist_date DESC";
	}
	$sql = "SELECT * FROM works WHERE works_open_flag = ?" . $searchYear . " ORDER BY " . $option;
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
