<?php
if (! isset($_GET['works_id'])) {
	$dateGet = "SELECT DISTINCT DATE_FORMAT(works_regist_date,'%Y') as year FROM works WHERE works_open_flag = 1";
	$getYear = $dbc->getRowOnce($dateGet);
	if (isset($_POST['year']) && $_POST['year'] != "all") {
		$searchYear = " AND DATE_FORMAT(works_regist_date, '%Y') = {$_POST['year']}";
	} else {
		$searchYear = "";
	}
	$searchGenreName = (isset($_POST['genreName']) && $_POST['genreName'] !== "all") ? " AND genreName = '{$_POST['genreName']}'" : "";
	if (isset($_POST['date']) && $_POST['date'] === "DESC") {
		$option = "works_regist_date DESC";
	} else if (isset($_POST['date']) && $_POST['date'] === "ASC") {
		$option = "works_regist_date ASC";
	} else {
		$option = "works_regist_date DESC";
	}
	$genreNameGetSql = "SELECT DISTINCT genreName FROM works_variation WHERE genreName IS NOT NULL";
	$getGenreName = $dbc->getRowOnce($genreNameGetSql);
	$sql = "SELECT * FROM works INNER JOIN works_variation ON works.works_id = works_variation.works_id WHERE works_open_flag = ? AND works_variation_open_flag = ?" . $searchYear . $searchGenreName . " ORDER BY " . $option;
	$param = array(1, 1);
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
		$sql_player = "SELECT * FROM works_variation WHERE works_variation_id = ? AND works_variation_open_flag = ?";
		$param = array($_GET["works_variation_id"], 1);
		$works_player = $dbc->getRow($sql_player, $param);
	}
}
