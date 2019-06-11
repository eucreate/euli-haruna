<?php
$mainMenu = array(array('main_menu_id' => 1, 'main_menu_name' => 'Front Page', 'main_menu_url' => '/index.php', 'main_menu_url_target' => NULL),
array('main_menu_id' => 2, 'main_menu_name' => 'Profile', 'main_menu_url' => '/prof.php', 'main_menu_url_target' => NULL),
array('main_menu_id' => 3, 'main_menu_name' => 'Works', 'main_menu_url' => '/works/index.php', 'main_menu_url_target' => NULL),
array('main_menu_id' => 4, 'main_menu_name' => 'Link', 'main_menu_url' => '/link.php', 'main_menu_url_target' => NULL),
array('main_menu_id' => 5, 'main_menu_name' => '掲示板', 'main_menu_url' => '/bbs.php', 'main_menu_url_target' => NULL),
array('main_menu_id' => 6, 'main_menu_name' => 'お問い合わせ', 'main_menu_url' => "https://{$_SERVER['HTTP_HOST']}/contact/sformmail.php", 'main_menu_url_target' => NULL),
array('main_menu_id' => 7, 'main_menu_name' => 'Blog', 'main_menu_url' => '/blog/', 'main_menu_url_target' => NULL));
?>
<!-- Menu -->
<div id="menu">
<!-- Menu Start -->
<nav>
<ul>
<?php
$menuCount = count($mainMenu);
$className = "";
for ($i = 0 ; $i < $menuCount ; $i++) {
  $url = substr($mainMenu[$i]['main_menu_url'], -9) == "index.php" ? trim($mainMenu[$i]['main_menu_url'], "index.php") : $mainMenu[$i]['main_menu_url'];
  $target = $mainMenu[$i]['main_menu_url_target'] != "" ? "\" target=\"_" . $mainMenu[$i]['main_menu_url_target'] : "";
  if ($i == $menuCount - 1) { $className = " class=\"last\""; }
  echo "\t<li". $className . "><a href=\"" . $url . $target . "\">" . $mainMenu[$i]['main_menu_name'] . "</a></li>\n";
}
?>
</ul>
</nav>
<!-- Menu End -->
<!-- /menu --></div>

<div class="sideSns">
<p>
<div class="twitter"><a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script></div>
</p>
</div>
