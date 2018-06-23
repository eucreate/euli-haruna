<?php
require_once(dirname(__FILE__) . "/../config.php");
require_once(dirname(__FILE__) . "/../include_app/database.php");
$dbc = new dbc();
require_once(dirname(__FILE__) . "/inc_qry_index.php");
foreach($works_player as $row) {
	$filePath = $row["works_variation_url"];
	$filePathInfo = pathinfo($filePath);
	$worksVariationRegistDate = $row["works_variation_regist_date"];
	$worksVariationTitle = $row["works_variation_title"];
	$worksVariationUrl = $row["works_variation_url"];
}
$worksPageTitle = "Works";
$page_title = $worksVariationTitle . " - " . "Works";
$customHead = "<link rel=\"stylesheet\" href=\"/css/layout.css\" type=\"text/css\" media=\"screen,print\">
<meta property=\"og:title\" content=\"" . $page_title. " - " . $site_name . "\">\n";
include_once(dirname(__FILE__) . "/../include_files/header.php");
?>
			<div id="main">
			<div id="works">
			<?php
			echo "<h2>{$worksPageTitle}</h2>\n";
			foreach($works as $row) {
				echo "<h3>".$worksVariationTitle;
				if ($worksVariationRegistDate != "") {
					echo " (".$worksVariationRegistDate."登録)</h3>\n";
				}
				if ($row["works_comment"] != "") {
					echo "<p>" . nl2br($row["works_comment"]) . "</p>\n";
				}
				// Player
				if ($filePathInfo["extension"] == "mp3") {
					$playerTitle = "Player &amp; Download";
				} else {
					$playerTitle = "Downroad";
				}
				echo "<h4>" . $playerTitle . "</h4>\n";
					if ($filePathInfo["extension"] == "mp3") {
?>
				<audio src="<?php echo $filePath; ?>" controls>
					<p>音声を再生するには、audioタグをサポートしたブラウザが必要です。</p>
				</audio>
				<?php
					$size = filesize(SERVER_PATH.$filePath);
					echo "<p><a href=\"" . $worksVariationUrl . "\" target=\"_blank\" class=\"download\">Download</a>&nbsp;(" . round($size / 1048576, 2) . "MB)</p>\n";
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