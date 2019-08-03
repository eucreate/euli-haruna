<?php
// クローラーかどうかを判定する関数 (Function to determine if it is a crawler)
// http://www.happyquality.com/2012/02/04/1959.htm
function is_clawler($ua = null) {
  if (empty($ua)) {
    $ua = $_SERVER['HTTP_USER_AGENT'];
  }
  $crawlers = array(
    "Googlebot",        // google
    "Baiduspider",      // Baidu
    "Hatena",       // Hatena
    "Yahoo",        // Yahoo
    "FreeNutch",        // FreeNutch
    "AhrefsBot", // AhrefsBot
    "naver.com", // NaverBot
    "Ezooms", // ezooms.bot
  );
  foreach ($crawlers as $keyword) {
    if (stripos($ua, $keyword) !== false) {
      return true;
    }
  }
  return false;
}

// Newテキストの表示 (Display of new text)
function iconNew($dispDate) {
  $nowDate = new DateTime();
  $diffDate = $dispDate->modify('+7 day');
  if ($nowDate < $diffDate) {
    return "<span class=\"iconNew\">New!</span>";
  }
}
