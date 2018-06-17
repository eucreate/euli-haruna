<?php
require_once(dirname(__FILE__) . "/../config.php");
require_once(dirname(__FILE__) . "/../include_app/database.php");
$dbc = new dbc();
require_once(dirname(__FILE__) . "/inc_qry_index.php");
$worksPageTitle = "Works";
if (! isset($_GET['works_id'])) {
$page_title = "Works";
} else {
	foreach ($works as $row) {
		$page_title = $row["works_title"] . " - " . "Works";
	}
}
$customHead = "<link rel=\"stylesheet\" href=\"/css/layout.css\" type=\"text/css\" media=\"screen,print\">\n";
if (! isset($_GET['works_id'])) {
$customHead = $customHead . "<script src=\"/js/jquery.biggerlink.min.js\" type=\"text/javascript\"></script>
<script type=\"text/javascript\">
	$(function(){
		$('article').biggerlink();
	});
</script>
";
} else {
	foreach ($works as $row) {
		$customHead = $customHead . "<meta property=\"og:title\" content=\"" . $row["works_title"] . " - " . $page_title. " - " . $site_name . "\">\n";
	}
}
$customHead = $customHead . "<meta property=\"og:title\" content=\"" . $page_title. " - " . $site_name . "\">\n";
include_once(dirname(__FILE__) . "/../include_files/header.php");
?>
			<div id="main">
			<div id="works">
			<?php
			echo "<h2>{$worksPageTitle}</h2>\n";
			if (! isset($_GET['works_id'])) {
				echo "<p>{$countRows} 件見つかりました。</p>";
				foreach($worksDigest as $row) {
					echo '<article>'."\n".'<h3><a href="?works_id='.$row["works_id"].'">'.$row["works_title"]."</a></h3>\n";
					if ($row["works_comment"] != "") {
						echo "<p>".$row["works_comment"]."</p>\n";
					}
					echo "</article>\n";
				}
			} else {
				foreach($works as $row) {
					echo "<h3>".$row["works_title"]." (".$row["works_regist_date"]."登録)</h3>\n";
					if ($row["works_comment"] != "") {
						echo "<p>" . nl2br($row["works_comment"]) . "</p>\n";
					}
					// update
					if (count($works_update) > 0) {
						echo "<h4>更新履歴</h4>\n";
						echo "<ul id=\"update\">\n";
						foreach($works_update as $row2) {
							echo "<li>".$row2["works_update_up_date"]." ".$row2["works_update_comment"]."</li>\n";
						}
						echo "</ul>\n";
					}
					// variation
					if (count($sql_variation) > 0) {
						echo "<h4>バリエーション等</h4>\n";
						echo "<ul id=\"variation\">\n";
						foreach($works_variation as $row3) {
							if (substr($row3["works_variation_url"], 0, 4) == "http") {
								$target = "blank";
							} else {
								$target = "self";
							}
							echo "<li><a href=\"link.php?works_variation_id={$row3["works_variation_id"]}\" target=\"_" . $target . "\">{$row3["works_variation_title"]}</a>";
							if ($row3["regist_site_name"] != "") {
								echo "&nbsp;({$row3["regist_site_name"]})";
							}
							echo "</li>\n";
						}
						echo "</ul>\n";
					}
					// free1
					if (strlen($row["works_free1"]) > 0) {
						echo "<div id=\"free1\">" . $row["works_free1"] . "</div>\n";
					}
				}
			}
			$dbc->Disconnect();
			?>
			<!-- /works --></div>
			<!-- /main --></div>
		<!-- /contents --></div>
		<?php include_once(dirname(__FILE__) . "/../include_files/page_footer.php");
		include_once(dirname(__FILE__) . "/../include_files/footer.php");
?>