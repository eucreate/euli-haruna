<?php
require_once(dirname(__FILE__) . "/../config.php");
require_once(dirname(__FILE__) . "/../include_app/mysql.php");
$mysql = new MySQL;
$page_title = "更新履歴";
$customHead = "<link rel=\"stylesheet\" href=\"/css/layout.css\" type=\"text/css\" media=\"screen,print\">\n";
include_once(dirname(__FILE__) . "/../include_files/header.php");
?>
			<div id="main">
			<?php
			print <<<EOT
			<div id="whatsnew">
			<h2>{$page_title}</h2>
			<div class="update">
EOT;
// 取り出す最大レコード数
$lim = 20;

if (! isset($_GET["start"])) {
	// はじめて呼び出されたとき
	// 総レコード数を取得
	// データ数の取得
	$sql_rows = "SELECT COUNT(*) AS cnt FROM whatsnew;";
	$res = $mysql->query($sql_rows);
	$row = $mysql->fetch($res);
	$dtcnt = $row["cnt"];
	//mysql_free_result($res);
	// 総ページ数を計算
	$pgmax = ceil($dtcnt / $lim);
	// 初期表示時の開始レコードを設定
	$start = 0;
} else {
	// ページ移動用リンクから呼び出されたとき
	$pgmax = $_GET[pgmax];
	$start = $_GET[start];
}

// 現在のページ番号を計算
$curpage = ($start / $lim) + 1;

// $startレコード目から$lim件のレコードを読み込むSQL
$sql = "SELECT * FROM whatsnew ORDER BY wn_id DESC LIMIT $start, $lim";
echo $dtcnt . " 件見つかりました。現在 " . $curpage . " ページ目を表示。";
// 結果セットを取得
$rst = $mysql->query($sql);

/*
// 表示するページ位置を取得する
$p = intval(@$_GET["p"]);
if ($p < 1) {
	$p = 1;
}

// 表示するデータの位置を取得する
$st = ($p - 1) * $lim;

// 前のページ・次のページのページ番号を取得する
$prev = $p - 1;
if ($prev < 1) {
	$prev = 1;
}
$next = $p + 1;

// テーブル読み込み
$my_Row = mysql_query("SELECT * FROM whatsnew ORDER BY wn_id DESC LIMIT $st, $lim",$my_Con) or die("データ抽出エラー");
*/
echo "<dl>\n";
while($row = $mysql->fetch($rst)) {
	if ($row["wn_text"] == "" && $row["wn_url"] != "") {
		$wn_link_url = $row["wn_url"];
	} else {
		$wn_link_url = "detail.php?wn_id=".$row["wn_id"];
	}
	echo "<dt>".$row["wn_disp_date"]."</dt>\n";
	echo '<dd><a href="'.$wn_link_url.'" target="'.$row["wn_target"].'">'.$row["wn_title"].'</a></dd>'."\n";
}
echo "</dl>\n";

/*
// 前のページ・次のページへのリンク
if ($p > 1) {
	echo "<a href=\"".$_SERVER["PHP_SELF"]."?p=$prev\">前のページ</a> ";
}
if (($next - 1) * $lim < $dtcnt) {
	echo "<a href=\"".$_SERVER["PHP_SELF"]."?p=$next\">次のページ</a>";
}

*/
// 接続を解除
$dbc = mysqli_connect(db_server,db_user,db_pass);
mysqli_close($dbc);
// ページ移動用リンクの組み立て
// 先頭ページへの移動用
$startprm = 0;
echo "<p>";
echo "<a href=\"".$_SERVER['PHP_SELF']."?pgmax=$pgmax&start=$startprm\">先頭</a>&nbsp;";

// 一つ前のページへの移動用
if ($curpage > 1) {
	$startprm = ($curpage - 2) * $lim;
} else {
	$startprm = ($curpage - 1) * $lim;
}
echo "<a href=\"".$_SERVER['PHP_SELF']."?pgmax=$pgmax&start=$startprm\">前のページ</a>&nbsp;";

// 各ページ番号への直リンク
for ($cnt = 1; $cnt <= $pgmax; $cnt++) {
	$startprm = ($cnt - 1) * $lim;
	echo "<a href=\"".$_SERVER['PHP_SELF']."?pgmax=$pgmax&start=$startprm\">$cnt</a>&nbsp;";
}

// 1つ次のページへの移動用
if ($curpage < $pgmax) {
	$startprm = $curpage * $lim;
} else {
	$startprm = ($curpage - 1) * $lim;
}
echo "<a href=\"".$_SERVER['PHP_SELF']."?pgmax=$pgmax&start=$startprm\">次のページ</a>&nbsp;";

// 最終ページへのリンク
$startprm = ($pgmax - 1) * $lim;
echo "<a href=\"{$_SERVER['PHP_SELF']}?pgmax=$pgmax&start=$startprm\">最後</a>";
echo "</p>";
mysql_disconnect($mysql);
?>
</div><!-- /update -->
			<!-- /#whatsnew --></div>
			<!-- /main --></div>
		<!-- /contents --></div>
		<?php include_once(dirname(__FILE__) . "/../include_files/page_footer.php");
		include_once(dirname(__FILE__) . "/../include_files/footer.php");
?>