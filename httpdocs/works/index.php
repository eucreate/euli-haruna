<?php
require_once(dirname(__FILE__) . "/../config.php");
require_once(dirname(__FILE__) . "/../include_app/database.php");
$dbc = new dbc();
require_once(dirname(__FILE__) . "/inc_qry_index.php");
$worksPageTitle = "Works";
if (!isset($_GET['works_id'])) {
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
}
$customHead = $customHead . "<meta property=\"og:title\" content=\"" . $page_title. " - " . $site_name . "\">\n";
include_once(dirname(__FILE__) . "/../include_files/header.php");
?>
<div id="main">
  <div id="works">
    <?php
    echo "<h2>{$worksPageTitle}</h2>\n";
    if (!isset($_GET['works_id'])) {
      if ($lang === "ja") {
        echo "<p>Select language: <a href=\"/works/?lang=en-us\">English (US)</a></p>\n";
      } else {
        echo "<p>表示切替: <a href=\"/works/\">日本語</a></p>\n";
      }
      if ($lang === "en-us") {
        echo "<p>{$countRows} founds results.</p>";
      } else {
        echo "<p>{$countRows} 件見つかりました。</p>";
      }
    ?>
    <div id="searchForm">
      <form method="POST" action="/works/<?php echo $menuLang; ?>">
        <select name="date">
          <?php if ($lang === "en-us") { ?>
          <option value="DESC"<?php if (isset($_POST['date']) && $_POST['date'] === "DESC") echo " selected"; ?>>New order of registration date</option>
          <option value="ASC"<?php if (isset($_POST['date']) && $_POST['date'] === "ASC") echo " selected"; ?>>Oldest order of registration date</option>
          <?php } else { ?>
          <option value="DESC"<?php if (isset($_POST['date']) && $_POST['date'] === "DESC") echo " selected"; ?>>登録日新しい順</option>
          <option value="ASC"<?php if (isset($_POST['date']) && $_POST['date'] === "ASC") echo " selected"; ?>>登録日古い順</option>
          <?php } ?>
        </select>
        <select name="year">
          <?php if (isset($_POST['year'])) { $selYear = $_POST['year']; } else { $selYear = "all"; }
          if ($lang === "en-us") { ?>
          <option value="all"<?php if (isset($_POST['year']) && $_POST['year'] === "all" || $selYear === "all") echo " selected"; ?>>All years</option>
          <?php } else { ?>
          <option value="all"<?php if (isset($_POST['year']) && $_POST['year'] === "all" || $selYear === "all") echo " selected"; ?>>全て</option>
          <?php }
      foreach ($getYear as $year) {
        echo "<option value=\"{$year["year"]}\"";
        if ($selYear === $year['year']) {
          echo " selected";
        }
        if ($lang === "en-us") {
          echo ">{$year["year"]}</option>\n";
        } else {
          echo ">{$year["year"]}年</option>\n";
        }
      }
      ?>
        </select>
        <select name="genreName">
          <?php if (isset($_POST['genreName'])) { $selGenreName = $_POST['genreName']; } else { $selGenreName = "all"; }
          if ($lang === "en-us") { ?>
          <option value="all"<?php if (isset($_POST['genreName']) && $_POST['genreName'] === "all" || $selGenreName === "all") echo " selected"; ?>>All genres</option>
          <?php } else { ?>
          <option value="all"<?php if (isset($_POST['genreName']) && $_POST['genreName'] === "all" || $selGenreName === "all") echo " selected"; ?>>全てのジャンル</option>
          <?php }
      foreach ($getGenreName as $genreName) {
        echo "<option value=\"{$genreName["genreName"]}\"";
		  if ($selGenreName === $genreName['genreName']) {
          echo " selected";
        }
        echo ">{$genreName["genreName"]}</option>\n";
      }
          ?>
        </select>
        <input type="submit" value="<?php echo $dspLang = $lang === "en-us" ? "Search" : "検索"; ?>">
      </form>
    </div>
    <?php
    if ($lang === "en-us") {
      echo "<p>* The registration date isn&#039;t a variation registration date.</p>";
    }
      foreach($worksDigest as $row) {
        echo '<article>'."\n".'<h3><a href="'.$row["works_id"].'.html'.$menuLang.'">'.$row["works_variation_title"]."</a></h3>\n";
        if ($row["works_comment"] != "" || $row["works_comment_en_us"] != "") {
          if ($lang === "en-us") {
            if ($row["works_comment_en_us"] != "") { echo "<p>".$row["works_comment_en_us"]."</p>\n"; }
          } else {
            if ($row["works_comment"] != "") { echo "<p>".$row["works_comment"]."</p>\n"; }
          }
        }
        echo "</article>\n";
      }
    } else {
      if ($lang === "en-us") {
        echo "<p>表示切替: <a href=\"/works/{$row['works_id']}.html\">日本語</a></p>\n";
      } else {
        echo "<p>Select language: <a href=\"{$_SERVER['REQUEST_URI']}?lang=en-us\">English (US)</a></p>\n";
      }
      foreach($works as $row) {
        if ($lang === "en-us") {
          echo "<h3>" . $row["works_title"] . " (Registered on ". date("n/j/Y", strtotime($row["works_regist_date"])) . ")</h3>\n";
        } else {
          echo "<h3>".$row["works_title"]." (".$row["works_regist_date"]."登録)</h3>\n";
        }
        if ($row["works_comment"] != "" || $row["works_comment_en_us"] != "") {
          if ($lang === "en-us") {
            echo "<p>" . nl2br($row["works_comment_en_us"]) . "</p>\n";
          } else {
            echo "<p>" . nl2br($row["works_comment"]) . "</p>\n";
          }
        }
        // update
        if (count($works_update) > 0) {
          if ($lang === "en-us") {
            echo "<h4>Change log</h4>\n";
          } else {
            echo "<h4>更新履歴</h4>\n";
          }
          echo "<ul id=\"update\">\n";
          foreach($works_update as $row2) {
            if ($lang === "en-us") {
              echo "<li>" . date("n/j/Y", strtotime($row2["works_update_up_date"])) . " " . $row2["works_update_comment_en_us"] . "</li>\n";
            } else {
              echo "<li>".$row2["works_update_up_date"]." ".$row2["works_update_comment"]."</li>\n";
            }
          }
          echo "</ul>\n";
        }
        // variation
        if (count($works_variation) > 0) {
          if ($lang === "en-us") {
            echo "<h4>Variations etc</h4>\n";
            $linkLang = "&lang={$lang}";
          } else {
            echo "<h4>バリエーション等</h4>\n";
            $linkLang = "";
          }
          echo "<ul id=\"variation\">\n";
          foreach($works_variation as $row3) {
            if (substr($row3["works_variation_url"], 0, 4) === "http") {
              $target = "blank";
            } else {
              $target = "self";
            }
            echo "<li><a href=\"link.php?works_variation_id={$row3["works_variation_id"]}{$linkLang}\" target=\"_" . $target . "\">{$row3["works_variation_title"]}</a>";
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
<?php include_once(dirname(__FILE__) . "/../include_files/page_footer.php");
include_once(dirname(__FILE__) . "/../include_files/footer.php");
?>