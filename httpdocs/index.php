<?php
$user_agent = $_SERVER['HTTP_USER_AGENT'];
if (preg_match("/DoCoMo/",$user_agent) || preg_match("/J-PHONE/",$user_agent) || preg_match("/Vodafone/",$user_agent) || preg_match("/SoftBank/",$user_agent) || preg_match("/UP\.Browser/",$user_agent)) {
  header("Location: /m");
  exit;
} else {
  if (empty($_SERVER['HTTPS'])) {
    header("Location: https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}");
    exit;
  }
}
mb_internal_encoding("utf-8");
require_once(dirname(__FILE__) . "/config.php");
require_once(dirname(__FILE__) . "/include_app/database.php");
$dbc = new dbc();
$sql = "SELECT * FROM whatsnew ORDER BY wn_id DESC LIMIT 4";
$result = $dbc->getRowOnce($sql);
$blogDbc = new dbc("utf8mb4");
$blogSql = "SELECT * FROM wp_posts WHERE post_status = 'publish' AND post_type = 'post' ORDER BY post_date DESC LIMIT 5";
$resultBlog = $blogDbc->getRowOnce($blogSql);
$page_title = "Front Page";
$customHead = "<link rel=\"stylesheet\" href=\"/css/top.css\" type=\"text/css\" media=\"screen,print\">
<link rel=\"stylesheet\" href=\"/css/top_mq.css\" type=\"text/css\">
<meta property=\"og:title\" content=\"" . $page_title. " - " . $site_name . "\">\n";
include_once(dirname(__FILE__) . "/include_files/header.php");
?>
<div id="main">
  <?php if ($lang === "en-us") { ?>
  <p>Welcome to "Digital Musician" Euli Haruna official site.<br>
  Sorry, this website is mainly written in Japanese.</p>
  <p><a href="/">日本語はこちら</a></p>
  <p class="fs10">External links on this website basically open a new window.
  <?php } else { ?>
  <p>ようこそ、デジタルミュージシャンEuli Haruna公式サイトへ</p>
  <p><a href="/?lang=en-us">English(U.S.) is here</a></p>
  <p class="fs10">当ホームページの外部リンクは基本的に新規ウィンドを開きます。</p>
  <?php } ?>
  <section id="updates">
    <article>
      <div id="whatsnew">
        <?php if ($lang === "en-us") { ?>
        <h2>Updating information</h2>
        <?php } else { ?>
        <h2>更新情報</h2>
        <?php }
        // テーブル読み込み
        echo "<dl>\n";
        foreach ($result as $row) {
          if ($row["wn_text"] == "" && $row["wn_url"] != "") {
            $wn_link_url = $row["wn_url"];
          } else {
            $wn_link_url = "/whatsnew/detail.php?wn_id=".$row["wn_id"];
          }
          $dispDate = new DateTime($row["wn_disp_date"]);
          if ($lang === "en-us") {
            echo "<dt>" . $dispDate->format('n/j/Y') . iconNew($dispDate) . "</dt>\n";
            if ($row["wn_title_en_us"] != "") {
              echo "<dd><a href=\"".$wn_link_url."&lang=en-us\" target=\"".$row["wn_target"]."\">".$row["wn_title_en_us"]."</a></dd>\n";
            } else {
              echo "<dd><a href=\"".$wn_link_url."\" target=\"".$row["wn_target"]."\">".$row["wn_title"]."</a></dd>\n";
            }
          } else {
            echo "<dt>" . $row["wn_disp_date"] . iconNew($dispDate) . "</dt>\n";
            echo "<dd><a href=\"".$wn_link_url."\" target=\"".$row["wn_target"]."\">".$row["wn_title"]."</a></dd>\n";
          }
        }
        echo "</dl>\n";
        $dbc->Disconnect();
        ?>
        <?php if ($lang === "en-us") { ?>
        <p><a href="/whatsnew/digest.php?lang=en-us">Update list</a></p>
        <?php } else { ?>
        <p><a href="/whatsnew/digest.php">更新一覧</a></p>
        <?php } ?>
        <!-- /#whatsnew --></div>
    </article>
    <article>
      <div id="blog">
        <h2><a href="/blog/">Euli Haruna BLOG</a></h2>
        <dl>
        <?php
          foreach ($resultBlog as $row) {
            $dispDate = new DateTime($row["post_date"]);
            if ($lang === "en-us") {
              echo "<dt>" . $dispDate->format("n/j/Y H:i") . " (JST)" . iconNew($dispDate) . "</a></dt>\n";
            } else {
              echo "<dt>" . $dispDate->format("Y年m月d日 H:i") . iconNew($dispDate) .  "</a></dt>\n";
            }
            echo "<dd><a href=\"" . $row["guid"] . "\">" . $row["post_title"] . "</a></dd>\n";
          }
          $blogDbc->Disconnect();
        ?>
        </dl>
      <!-- /#blog --></div>
    </article>
  </section>
  <hr>
  <div id="information">
    <?php if ($lang === "en-us") { ?>
    <h3>Guidance</h3>
    <h4>About compatible browser</h4>
    <p id="info">This website recommends Microsoft Internet Explorer 11, Firefox 32 or later, Google Chrome 44 or later, Safari 6 (mac) or later, iOS 9 or later, Android 4.4.2 or later.</p>
    <?php } else { ?>
    <h3>ご案内</h3>
    <h4>対応ブラウザについて</h4>
    <p id="info">このホームページは、<a href="https://support.microsoft.com/ja-jp/help/17621/internet-explorer-downloads" target="_blank">Microsoft Internet Explorer 11</a>、<a href="http://mozilla.jp/" target="_blank">Firefox 32</a>以降，<a href="http://www.google.co.jp/intl/ja/chrome/browser/" target="_blank">Google Chrome 44</a>以降、Safari 6(mac)以降、iOS 9以降、Android 4.4.2以降を推薦いたします。</p>
    <noscript>このホームページを正しく見るにはJavaScript対応ブラウザで同機能を有効にしてご覧ください。</noscript>
    <?php } ?>
    <!-- /#information --></div>
  <!-- /main --></div>
<?php include_once(dirname(__FILE__) . "/include_files/page_footer.php");
include_once(dirname(__FILE__) . "/include_files/footer.php");
?>