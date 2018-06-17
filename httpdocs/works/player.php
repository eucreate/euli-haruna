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
$customHead = "<link rel=\"stylesheet\" href=\"/css/layout.css\" type=\"text/css\" media=\"screen,print\">\n";
if ($filePathInfo["extension"] == "mp3") {
$customHead .= "<link rel=\"stylesheet\" href=\"/js/jplayer/skin/blue.monday/jplayer.blue.monday.css\" type=\"text/css\">
<script type=\"text/javascript\" src=\"/js/jplayer/jquery.jplayer.min.js\"></script>\n";
}
$customHead = $customHead . "<meta property=\"og:title\" content=\"" . $page_title. " - " . $site_name . "\">\n";
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
<script>
jQuery(function($){
   $("#jquery_jplayer_1").jPlayer({
        ready: function () {
          $(this).jPlayer("setMedia", {
            mp3: "<?php echo $filePath; ?>"
          });
        },
        swfPath: "/js/jplayer",
        supplied: "<?php echo $filePathInfo["extension"]; ?>"
      });
});
</script>
  <div id="jquery_jplayer_1" class="jp-jplayer"></div>
  <div id="jp_container_1" class="jp-audio">
    <div class="jp-type-single">
      <div class="jp-gui jp-interface">
        <ul class="jp-controls"><!--コントロール部分-->
          <li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
          <li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
          <li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
          <li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
          <li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
          <li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
        </ul>
        <div class="jp-progress"><!--プログレスバー部分-->
          <div class="jp-seek-bar">
            <div class="jp-play-bar"></div>
          </div>
        </div>
        <div class="jp-volume-bar"><!--ボリュームバー部分-->
          <div class="jp-volume-bar-value"></div>
        </div>
        <div class="jp-time-holder"><!--時間表示部分-->
          <div class="jp-current-time"></div>
          <div class="jp-duration"></div>
          <ul class="jp-toggles"><!--リピートボタン部分-->
            <li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
            <li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
          </ul>
        </div>
      </div>
      <div class="jp-title"><!--タイトル表示部分-->
        <ul>
          <li><?php echo $worksVariationTitle; ?></li>
        </ul>
      </div>
      <div class="jp-no-solution"><!--アップデートを促す表示部分-->
        <span>Update Required</span>
        To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
      </div>
    </div>
  </div>
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