<?php
require_once(dirname(__FILE__) . "/../config.php");
require_once(dirname(__FILE__) . "/../include_app/database.php");
$dbc = new dbc();
require_once(dirname(__FILE__) . "/inc_qry_index.php");
if (count($works_player) > 0) {
  foreach($works_player as $row) {
    $filePath = $row["works_variation_url"];
    $filePathInfo = pathinfo($filePath);
    $worksID = $row["works_id"];
    $worksVariationId = $row["works_variation_id"];
    $worksVariationRegistDate = $row["works_variation_regist_date"];
    $worksVariationTitle = $row["works_variation_title"];
    $worksVariationUrl = $row["works_variation_url"];
    $worksVariationFree1 = $row["works_variation_free1"];
    $worksVariationOgpImage = $row["works_variation_ogp_image"];
  }
} else {
  $filePath = "";
  $filePathInfo = "";
  $worksVariationRegistDate = "";
  $worksVariationTitle = "Not Found";
  $worksVariationUrl = "";
}
$worksPageTitle = "Works";
$page_title = $worksVariationTitle . " - " . "Works";
$customHead = "<link rel=\"stylesheet\" href=\"/css/layout.css\" type=\"text/css\" media=\"screen,print\">
<meta property=\"og:title\" content=\"" . $page_title. " - " . $site_name . "\">\n";
if ($worksVariationOgpImage !== NULL) {
  $customHead = $customHead . "<meta property=\"og:image\" content=\"" . $worksVariationOgpImage . "\">\n";
} else {
  $customHead = $customHead . "<meta property=\"og:image\" content=\"https://www.euli-haruna.com/images/ogp.png\">\n";
}
include_once(dirname(__FILE__) . "/../include_files/header.php");
?>
<div id="main">
  <div id="works">
    <?php
    if ($worksVariationTitle === "Not Found") {
      echo "<h3>{$worksVariationTitle}</h3>\n";
      echo "<p>ページが見つからない、削除されている、または非公開のため、ページを表示できません。</p>\n";
      echo "<p>The page can't be displayed because the page is missing, deleted, or private.<p>\n";
    } else {
      if ($lang === "ja") {
        echo "<p>Select language: <a href=\"{$_SERVER['REQUEST_URI']}?lang=en-us\">English (US)</a></p>\n";
      } else {
        echo "<p>表示切替: <a href=\"/works/{$worksID}-{$worksVariationId}.html\">日本語</a></p>\n";
      }
      echo "<h2>{$worksPageTitle}</h2>\n";
      foreach($works as $row) {
        echo "<h3>".$worksVariationTitle;
        if ($worksVariationRegistDate != "") {
          if ($lang === "en-us") {
            echo " (Registered on " . date("n/j/Y", strtotime($worksVariationRegistDate)) . ")";
          } else {
            echo " (".$worksVariationRegistDate."登録)";
          }
        }
        echo "</h3>\n";
        if ($row["works_comment"] !== "" || $row["works_comment_en_us"] != "") {
          if ($lang === "en-us") {
            echo "<p>" . nl2br($row["works_comment_en_us"]) . "</p>\n";
          } else {
            echo "<p>" . nl2br($row["works_comment"]) . "</p>\n";
          }
        }
        // Player
        if ($filePathInfo["extension"] === "mp3") {
          $playerTitle = "Player &amp; Download";
        } else {
          $playerTitle = "Downroad";
        }
        echo "<h4>" . $playerTitle . "</h4>\n";
        if ($filePathInfo["extension"] == "mp3") {
    ?>
    <audio src="<?php echo $filePath; ?>" controls>
      <p>音声を再生するには、audioタグをサポートしたブラウザが必要です。</p>
      <p>Your browser does not support the audio tag.</p>
    </audio>
    <?php
          // Copy remote file locally to scan with getID3()
          require_once('../getid3/getid3.php');
          $getID3 = new getID3;
          $filename = $_SERVER['DOCUMENT_ROOT'] . $filePath;
          $ThisFileInfo = $getID3->analyze($filename);
          getid3_lib::CopyTagsToComments($ThisFileInfo);
          $bitrate = $ThisFileInfo['audio']['bitrate'] / 1000;
          $size = filesize(SERVER_PATH.$filePath);
          if (isset($ThisFileInfo['comments']['picture'][0]['data'])) {
            echo "<p><img src=\"data:{$ThisFileInfo['comments']['picture'][0]['image_mime']};base64," . base64_encode($ThisFileInfo['comments']['picture'][0]['data']) . "\" width=\"250\" alt=\"{$ThisFileInfo['id3v1']['title']}\"></p>\n";
          }
          echo "<p>({$bitrate}kbps (" . strtoupper($ThisFileInfo['audio']['bitrate_mode']) . "), " . strtoupper($ThisFileInfo['audio']['dataformat']) .", {$ThisFileInfo['id3v1']['genre']}, {$ThisFileInfo['id3v1']['year']})</p>\n";
          echo "<p><a href=\"" . $worksVariationUrl . "\" target=\"_blank\" class=\"download\">Download</a>&nbsp;(" . round($size / 1048576, 2) . "MB)</p>\n";
          if ($lang === "en-us") {
            echo "<p>*You may not be able to download depending on the usage environment.</p>\n";
          } else {
            echo "<p>※ご利用の環境によってはダウンロードできない場合がございます。</p>\n";
          }
        } else {
          echo "<p><a href=\"{$filePath}\" target=\"_blank\" class=\"download\">Download</a></p>\n";
        }
        if (isset($worksVariationFree1) && $worksVariationFree1 !== "") {
          echo $worksVariationFree1;
        }
      }
    }
    $dbc->Disconnect();
    ?>
  <!-- /works --></div>
<!-- /main --></div>
<?php include_once(dirname(__FILE__) . "/../include_files/page_footer.php");
include_once(dirname(__FILE__) . "/../include_files/footer.php");
?>