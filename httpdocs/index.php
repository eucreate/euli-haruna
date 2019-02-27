<?php
$user_agent = $_SERVER['HTTP_USER_AGENT'];
if (preg_match("/DoCoMo/",$user_agent) || preg_match("/J-PHONE/",$user_agent) || preg_match("/Vodafone/",$user_agent) || preg_match("/SoftBank/",$user_agent) || preg_match("/UP\.Browser/",$user_agent)) {
  header("Location: /m");
  exit;
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
  <p>ようこそ、デジタルミュージシャンEuli Haruna公式サイトへ。</p>
  <!-- Acsecce Counter -->
  <p>あなたは<img src="/ecount3/ecount.cgi?5" alt=""><img src="/ecount3/ecount.cgi?4" alt=""><img src="/ecount3/ecount.cgi?3" alt=""><img src="/ecount3/ecount.cgi?2" alt=""><img src="/ecount3/ecount.cgi?1" alt="">人目の訪問者です。</p>
  <p lang="en">Sorry, this website is written in Japanese.</p>
  <p class="fs10">当ホームページの外部リンクは基本的に新規ウィンドを開きます。</p>
  <section id="updates">
    <article>
      <div id="whatsnew">
        <h2>更新情報</h2>
        <?php
        // テーブル読み込み
        echo "<dl>\n";
        foreach ($result as $row) {
          if ($row["wn_text"] == "" && $row["wn_url"] != "") {
            $wn_link_url = $row["wn_url"];
          } else {
            $wn_link_url = "/whatsnew/detail.php?wn_id=".$row["wn_id"];
          }
          echo "<dt>".$row["wn_disp_date"]."</dt>\n";
          echo "<dd><a href=\"".$wn_link_url."\" target=\"".$row["wn_target"]."\">".$row["wn_title"]."</a></dd>\n";
        }
        echo "</dl>\n";
        $dbc->Disconnect();
        ?>
        <p><a href="/whatsnew/digest.php">更新一覧</a></p>
        <!-- /#whatsnew --></div>
    </article>
    <article>
      <div id="blog">
        <h2><a href="/blog/">Euli Haruna BLOG</a></h2>
        <dl>
        <?php
          foreach ($resultBlog as $row) {
            echo "        <dt>" . date("Y年m月d日 H:i", strtotime($row["post_date"])) . "</a></dd>\n";
            echo "        <dd><a href=\"" . $row["guid"] . "\">" . $row["post_title"] . "</a></dd>\n";
          }
          $blogDbc->Disconnect();
        ?>
        </dl>
      <!-- /#blog --></div>
    </article>
  </section>
  <hr>
  <div id="information">
    <h3>ご案内</h3>
    <h4>対応ブラウザについて</h4>
    <p id="info">このホームページは、<a href="https://support.microsoft.com/ja-jp/help/17621/internet-explorer-downloads" target="_blank">Microsoft Internet Explorer 9.0</a>以降、<a href="http://mozilla.jp/" target="_blank">Firefox 20</a>以降，<a href="http://jp.opera.com/" target="_blank">Opera 12.10</a>以降，<a href="http://www.google.co.jp/intl/ja/chrome/browser/" target="_blank">Google Chrome 22</a>以降、iOS 9以降、Android 4.1以降を推薦いたします。</p>
    <noscript>このホームページを正しく見るにはJavaScript対応ブラウザで同機能を有効にしてご覧ください。</noscript>
    <!-- /#information --></div>
  <!-- /main --></div>
<?php include_once(dirname(__FILE__) . "/include_files/page_footer.php");
include_once(dirname(__FILE__) . "/include_files/footer.php");
?>