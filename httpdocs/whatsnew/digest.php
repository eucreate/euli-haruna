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

// 総レコード数を取得
// データ数の取得
$sql_rows = "SELECT COUNT(*) AS cnt FROM whatsnew;";
$res = $mysql->query($sql_rows);
$row = $mysql->fetch($res);
$dtcnt = $row["cnt"];

// 総ページ数を計算
$pgmax = ceil($dtcnt / $lim);

if (isset($_GET['page']) && preg_match('/^[1-9][0-9]*$/', $_GET['page'])) {
	$page = (int)$_GET['page'];
} else {
	$page = 1;
}

//オフセットを計算
$offset = $lim * ($page - 1);

// 現在表示している何件中の何件からを取得
$from = $offset + 1;
$to = ($offset + $lim) < $dtcnt ? ($offset + $lim) : $dtcnt;

// $startレコード目から$lim件のレコードを読み込むSQL
$sql = "SELECT * FROM whatsnew ORDER BY wn_id DESC LIMIT $offset, $lim";
echo $dtcnt . " 件見つかりました。現在 " . $page . " ページ目（" . $from . "～" . $to . "件）を表示。";
// 結果セットを取得
$rst = $mysql->query($sql);

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

// 接続を解除
$dbc = mysqli_connect(db_server,db_user,db_pass);
mysqli_close($dbc);
// ページ移動用リンクの組み立て
// 先頭ページへの移動用
echo "<p>";
if ($page === 1) {
	echo '<span>先頭</span>&nbsp';
} else {
	echo "<a href=\"".$_SERVER['PHP_SELF']."?page=1\">先頭</a>&nbsp;";
}

// 一つ前のページへの移動用
if ($page === 1) {
	echo "<span>前のページ</span>&nbsp;";
} else {
	$prev = $page - 1;
	echo "<a href=\"".$_SERVER['PHP_SELF']."?page=$prev\">前のページ</a>&nbsp;";
}

// 各ページ番号への直リンク
for ($i = 1; $i <= $pgmax; $i++) {
	if ($page == $i) {
		echo "<span>$i</span>&nbsp;";
	} else {
		echo "<a href=\"".$_SERVER['PHP_SELF']."?page=$i\">$i</a>&nbsp;";
	}
}

// 1つ次のページへの移動用
if ($page == $pgmax) {
	echo "<span>次のページ</span>&nbsp;";
} else {
	$next = $page + 1;
	echo "<a href=\"".$_SERVER['PHP_SELF']."?page=$next\">次のページ</a>&nbsp;";
}

// 最終ページへのリンク
if ($page == $pgmax) {
	echo "<span>最後</span>";
} else {
	echo "<a href=\"{$_SERVER['PHP_SELF']}?page=$pgmax\">最後</a>";
}
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