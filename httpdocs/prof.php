<?php
require_once(dirname(__FILE__) . "/config.php");
$page_title = "Profile";
$customHead = "<link rel=\"stylesheet\" href=\"/css/layout.css\" type=\"text/css\" media=\"screen,print\">
<meta property=\"og:title\" content=\"" . $page_title. " - " . $site_name . "\">\n";
include_once(dirname(__FILE__) . "/include_files/header.php");
?>
<div id="main">
  <div id="profile">
    <?php echo "<h2>{$page_title}</h2>\n"; ?>
    <div class="profileContents">
      <?php if (isset($_GET["lang"]) && $_GET["lang"] === "en-us") { ?>
      <p>言語切替：<a href="/prof.php">日本語</a></p>
      <table>
        <tr>
          <th>Artist name</th>
          <td>Euli Haruna</td>
        </tr>
        <tr>
          <th>Gender</th>
          <td>Male</td>
        </tr>
        <tr>
          <th>Biography</th>
          <td>Born in Nagano Prefecture on April 13, 1982.<br>
            Began to music with computer music since 19 years old on my own.<br>
            (Back to the left-handed at this time.)</td>
        </tr>
        <tr>
          <th>Main activities</th>
          <td>Because I can&#39;t play music instruments, I&#39;m composing music, mainly on MIDI typing at programming.<br>
            Self-proclaimed &quot;digital musician&quot;.<br>
            I&#39;m not doing live because I&#39;m full digital production (I can not).
          </td>
        </tr>
        <tr>
          <th>Favorite genres</th>
          <td>Rock, Pops</td>
        </tr>
        <tr>
          <th>Favorite artists</th>
          <td>The Beatles, Deep Purple, Van Halen, KISS, Iron Maiden, Slayer, Megadeth, Hardcore Superstar, GLAY, Gackt, back number, ONE OK ROCK</td>
        </tr>
        <tr>
          <th>Equipment used</th>
          <td>
            <dl>
              <dt>Music instruments</dt>
              <dd>None</dd>
              <dt>Sequence software</dt>
              <dd><a href="http://www.ssw.co.jp/" target="_blank">ABILITY Pro</a></dd>
              <dt>MIDI sound source</dt>
              <dd><a href="https://www.roland.com/jp/" target="_blank">Roland</a> SC-D70, SD-90</dd>
              <dt>Other sound sources</dt>
              <dd><a href="https://www.roland.com/jp/products/sound_canvas_va/" target="_blank">Roland Sound Canvas VA</a>, Roland HyperCanvas(VST), Roland Virtual Sound Canvas(VST)<br>
                EZDrummer, Superior Drummer 2.0<br>
                NATIVE INSTRUMENTS KOMPLETE ELEMENTS<br>
                AmpliTube METAL
                <ul>
                  <li>Vocaloid5</li>
                  <li>Vocaloid4
                    <ul>
                      <li>Gackpoid COMPLETE</li>
                      <li>Kagamine Rin &amp; Len V4X bundle</li>
                      <li>Megurine Luka V4X</li>
                    </ul>
                  </li>
                </ul>
              </dd>
            </dl>
          </td> 
        </tr>
      </table>
      <?php } else { ?>
      <p>Select language: <a href="/prof.php?lang=en-us">English (US)</a></p>
      <table>
        <tr>
          <th>アーティスト名</th>
          <td>春奈　優里（はるな　ゆうり）<br>
          Euli Haruna</td>
        </tr>
        <tr>
          <th>性別</th>
          <td>男</td>
        </tr>
        <tr>
          <th>略歴</th>
          <td>1982年4月13日、長野県生まれ。おひつじ座。<br>中学2年生頃に、父がパソコン（懐かしのPC-98）を購入。<br>これがきっかけで、独学にてパソコンを始める。<br>最終学歴は長野県内の情報経理系専門学校卒。<br>19歳からDTMと音楽の勉強を独学し始める。<br>2005年5月～Webの仕事を始める。</td>
        </tr>
        <tr>
          <th>主な活動内容</th>
          <td>楽器が弾けないので、DTMでのMIDI打ち込みを中心に、作曲活動をしています。<br>
          自称「デジタルミュージシャン」。フルデジタル制作のため、ライブやりません（できません）。</td>
        </tr>
        <tr>
          <th>好きなジャンル</th>
          <td>Rock, Pops</td>
        </tr>
        <tr>
          <th>好きなアーティスト</th>
          <td>The Beatles, Deep Purple, Van Halen, KISS, Hardcore Superstar, GLAY, Gackt, back number, ONE OK ROCK</td>
        </tr>
        <tr>
          <th>使用機材</th>
          <td>
            <dl>
              <dt>楽器</dt>
              <dd>なし</dd>
              <dt>シーケンスソフト</dt>
              <dd><a href="http://www.ssw.co.jp/" target="_blank">ABILITY Pro</a></dd>
              <dt>MIDI音源</dt>
              <dd><a href="https://www.roland.com/jp/" target="_blank">Roland</a> SC-D70, SD-90</dd>
              <dt>その他音源</dt>
              <dd><a href="https://www.roland.com/jp/products/sound_canvas_va/" target="_blank">Roland Sound Canvas VA</a>, Roland HyperCanvas(VST), Roland Virtual Sound Canvas(VST)<br>
              EZDrummer, Superior Drummer 2.0<br>
              NATIVE INSTRUMENTS KOMPLETE ELEMENTS<br>
              AmpliTube METAL
              <ul>
                <li>Vocaloid5</li>
                <li>Vocaloid4
                  <ul>
                    <li>がくっぽいど COMPLETE</li>
                    <li>鏡音リン・レン V4X バンドル</li>
                    <li>巡音ルカ V4X</li>
                  </ul>
                </li>
              </ul>
            </dd>
          </dl>
        </td> 
      </tr>
    </table>
    <?php } ?>
    </div>
  <!-- /#profile --></div>
<!-- /main --></div>
<?php include_once(dirname(__FILE__) . "/include_files/page_footer.php");
include_once(dirname(__FILE__) . "/include_files/footer.php");
?>