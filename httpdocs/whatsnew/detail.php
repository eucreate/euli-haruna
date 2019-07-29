<?php
require_once(dirname(__FILE__) . "/../config.php");
require_once(dirname(__FILE__) . "/../include_app/database.php");
$dbc = new dbc;
$sql = "SELECT * FROM whatsnew WHERE wn_id = ?";
$param = array($_GET["wn_id"]);
// テーブル読み込み
$rst = $dbc->getRow($sql, $param);
$page_title = $lang === "en-us" ? "Updating information" : "更新履歴";
$customHead = "<link rel=\"stylesheet\" href=\"/css/layout.css\" type=\"text/css\" media=\"screen,print\">\n";
include_once(dirname(__FILE__) . "/../include_files/header.php");
?>
			<div id="main">
			<div id="whatsnew">
<?php
            if ($lang === "en-us") {
                echo "<p>言語切替：<a href=\"" . str_replace("&lang=en-us", "", $_SERVER['REQUEST_URI']) . "\">日本語</a></p>\n";
            } else {
                echo "<p>言語切替：<a href=\"{$_SERVER['REQUEST_URI']}&lang=en-us\">English (US)</a></p>\n";
            }
			echo "<h2>{$page_title}</h2>\n";
if (count($rst) > 0) {
	foreach($rst as $row) {
	    if ($lang === "en-us") {
	        echo "<h3>" . date('n/j/Y', strtotime($row['wn_disp_date'])) . "</h3>\n";
	        if ($row["wn_title_en_us"] != "") {
	            echo "<h4>{$row["wn_title_en_us"]}</h4>\n";
	        } else {
	            echo "<h4>{$row["wn_title"]}</h4>\n";
	        }
	        if ($row["wn_text_en_us"] != "") {
	            echo "<p>".htmlspecialchars_decode($row["wn_text_en_us"],ENT_QUOTES)."</p>\n";
	        } else {
	            echo "<p>".htmlspecialchars_decode($row["wn_text"],ENT_QUOTES)."</p>\n";
	        }
	    } else {
	        echo "<h3>{$row["wn_disp_date"]}</h3>\n";
	        echo "<h4>{$row["wn_title"]}</h4>\n";
	        echo "<p>".htmlspecialchars_decode($row["wn_text"],ENT_QUOTES)."</p>\n";
	    }
	}
}
$dbc->Disconnect();
$dispLang = $lang === "en-us" ? "?lang=en-us" : "";
$dispList = $lang === "en-us" ? "Back to the list" : "一覧へ戻る";
?>
<p align="center"><a href="digest.php<?php echo $dispLang; ?>"><?php echo $dispList; ?></a></p>
			<!-- /#whatsnew --></div>
			<!-- /main --></div>
		<?php include_once(dirname(__FILE__) . "/../include_files/page_footer.php");
		include_once(dirname(__FILE__) . "/../include_files/footer.php");
?>