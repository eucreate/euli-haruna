<?php
require_once(dirname(__FILE__) . "/../config.php");
require_once(dirname(__FILE__) . "/../include_app/database.php");
$dbc = new dbc;
$sql = "SELECT * FROM whatsnew WHERE wn_id = ?";
$param = array($_GET["wn_id"]);
// テーブル読み込み
$rst = $dbc->getRow($sql, $param);
$page_title = "更新履歴";
$customHead = "<link rel=\"stylesheet\" href=\"/css/layout.css\" type=\"text/css\" media=\"screen,print\">\n";
include_once(dirname(__FILE__) . "/../include_files/header.php");
?>
			<div id="main">
			<div id="whatsnew">
<?php
			echo "<h2>{$page_title}</h2>\n";
if (count($rst) > 0) {
	foreach($rst as $row) {
		echo "<h3>{$row["wn_disp_date"]}</h3>\n";
		echo "<h4>{$row["wn_title"]}</h4>\n";
		echo "<p>".htmlspecialchars_decode($row["wn_text"],ENT_QUOTES)."</p>\n";
	}
}
$dbc->Disconnect();
?>
<p align="center"><a href="digest.php">一覧へ戻る</a></p>
			<!-- /#whatsnew --></div>
			<!-- /main --></div>
		<!-- /contents --></div>
		<?php include_once(dirname(__FILE__) . "/../include_files/page_footer.php");
		include_once(dirname(__FILE__) . "/../include_files/footer.php");
?>