<?php
require_once(dirname(__FILE__) . "/../config.php");
require_once(dirname(__FILE__) . "/../include_app/database.php");
$dbc = new dbc();
$page_title = $lang === "en-us" ? "Updating information" : "更新履歴";
$customHead = "<link rel=\"stylesheet\" href=\"/css/layout.css\" type=\"text/css\" media=\"screen,print\">\n";
include_once(dirname(__FILE__) . "/../include_files/header.php");
?>
			<div id="main">
			<?php
			if (isset($_GET['lang']) && $_GET['lang'] === "en-us") {
                if (strpos($_SERVER['REQUEST_URI'], "?lang=") !== FALSE) {
                    echo "<p>言語切替：<a href=\"" . str_replace("?lang=en-us", "", $_SERVER['REQUEST_URI']) . "\">日本語</a></p>\n";
                } else {
                    echo "<p>言語切替：<a href=\"" . str_replace("&lang=en-us", "", $_SERVER['REQUEST_URI']) . "\">日本語</a></p>\n";
                }
			    $changeLang = "";
			    $linkLang = "&lang=en-us";
			} else {
                if (strpos($_SERVER['REQUEST_URI'], "?") !== FALSE) {
                    echo "<p>言語切替：<a href=\"{$_SERVER['REQUEST_URI']}&lang=en-us\">English (US)</a></p>\n";
                } else {
                    echo "<p>言語切替：<a href=\"{$_SERVER['REQUEST_URI']}?lang=en-us\">English (US)</a></p>\n";
                }
			    $changeLang = "&lang=en-us";
			    $linkLang = "";
			}
			print <<<EOT
			<div id="whatsnew">
			<h2>{$page_title}</h2>
			<div class="update">
EOT;
// 取り出す最大レコード数
$lim = 20;

// 総レコード数を取得
// データ数の取得
$sql_rows = "SELECT COUNT(*) FROM whatsnew;";
$dtcnt = $dbc->getRowSelectOnce($sql_rows);

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
$sql = "SELECT * FROM whatsnew ORDER BY wn_id DESC LIMIT ?, ?";
$getPagesParam = array($offset, $lim);
if ($lang === "en-us") {
    echo $dtcnt . " results found. Currently, page " . $page . " (" . $from . "-" . $to . ") is displayed.";
} else {
    echo $dtcnt . " 件見つかりました。現在 " . $page . " ページ目（" . $from . "～" . $to . "件）を表示。";
}
// 結果セットを取得
$rst = $dbc->getRow($sql, $getPagesParam);

echo "<dl>\n";
foreach ($rst as $row) {
	if ($row["wn_text"] == "" && $row["wn_url"] != "") {
		$wn_link_url = $row["wn_url"];
	} else {
		$wn_link_url = "detail.php?wn_id=".$row["wn_id"].$linkLang;
	}
	if ($lang === "en-us") {
	    echo "<dt>" . date("n/j/Y", strtotime($row["wn_disp_date"])) . "</dt>\n";
	} else {
	    echo "<dt>".$row["wn_disp_date"]."</dt>\n";
	}
	if (isset($_GET['lang']) && $_GET['lang'] === "en-us" && $row["wn_title_en_us"] != "") {
        $wnTitleEnUs = "{$row["wn_title_en_us"]}";
        echo '<dd><a href="'.$wn_link_url.'" target="'.$row["wn_target"].'">'.$wnTitleEnUs.'</a></dd>'."\n";
    } else {
        $wnTitleEnUs = "";
        echo '<dd><a href="'.$wn_link_url.'" target="'.$row["wn_target"].'">'.$row["wn_title"].'</a></dd>'."\n";
    }
}
echo "</dl>\n";

// ページ移動用リンクの組み立て
// 先頭ページへの移動用
$dispFirst = $lang === "en-us" ? "First" : "先頭";
echo "<p>";
if ($page === 1) {
	echo '<span>'.$dispFirst.'</span>&nbsp';
} else {
	echo "<a href=\"".$_SERVER['PHP_SELF']."?page=1{$linkLang}\">{$dispFirst}</a>&nbsp;";
}

// 一つ前のページへの移動用
$dispPrevious = $lang === "en-us" ? "Previous" : "前のページ";
if ($page === 1) {
	echo "<span>{$dispPrevious}</span>&nbsp;";
} else {
	$prev = $page - 1;
	echo "<a href=\"".$_SERVER['PHP_SELF']."?page=$prev{$linkLang}\">{$dispPrevious}</a>&nbsp;";
}

// 各ページ番号への直リンク
for ($i = 1; $i <= $pgmax; $i++) {
	if ($page == $i) {
		echo "<span>$i</span>&nbsp;";
	} else {
		echo "<a href=\"".$_SERVER['PHP_SELF']."?page=$i{$linkLang}\">$i</a>&nbsp;";
	}
}

// 1つ次のページへの移動用
$dispNext = $lang === "en-us" ? "Next" : "次のページ";
if ($page == $pgmax) {
	echo "<span>{$dispNext}</span>&nbsp;";
} else {
	$next = $page + 1;
	echo "<a href=\"".$_SERVER['PHP_SELF']."?page=$next{$linkLang}\">{$dispNext}</a>&nbsp;";
}

// 最終ページへのリンク
$dispLast = $lang === "en-us" ? "Last" : "最後";
if ($page == $pgmax) {
	echo "<span>{$dispLast}</span>";
} else {
	echo "<a href=\"{$_SERVER['PHP_SELF']}?page=$pgmax{$linkLang}\">{$dispLast}</a>";
}
echo "</p>";
//接続を解除
$dbc->Disconnect();
?>
</div><!-- /update -->
			<!-- /#whatsnew --></div>
			<!-- /main --></div>
		<?php include_once(dirname(__FILE__) . "/../include_files/page_footer.php");
		include_once(dirname(__FILE__) . "/../include_files/footer.php");
?>