<?php
$save_file = './cnr.m3u8';

$m3u8 = '#EXTM3U';
$url = 'https://china.cnr.cn';
$content = file_get_contents($url);
preg_match_all('/streams:\s*(\[[\s\S]+\])/',$content,$_match);
if(isset($_match[1][0])){
	$rel = $_match[1][0];
	$rel = preg_replace('/(title|url)\s*(?=:)/', '"\1"', $rel);
  $rel = iconv( "gb2312", "utf-8//IGNORE",$rel);
  $rel = json_decode($rel,true);
  foreach($rel as $item){
    $url = trim($item['url'],'/');
    $url  = "https://{$url}";
    $m3u8 .= "\n#EXTINF:-1 ,{$item['title']}\n{$url}";
  }
}
file_put_contents($save_file,$m3u8);
