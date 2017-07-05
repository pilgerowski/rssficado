<?php
  $xml['title']       = "Blue Bus";
  $xml['link']        = "http://www.bluebus.com.br/capa.shtml";
  $xml['description'] = "Blue Bus";
  $xml['publisher']   = "Blue Bus";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $itemregexp = "%rss:item *\" *>(.+?)</span>%is";
  $allowable_tags = "<A><B><BR><BLOCKQUOTE><CENTER><DD><DL><DT><HR><I><IMG><LI><OL><P><PRE><U><UL>";
  $data = read_file($xml['link']);
              
  $data = str_replace('<a href="/cgi-bin/show.pl?p=', 
    '<span class="rss:item"><a href="http://www.bluebus.com.br/cgi-bin/show.pl?p=',
    $data);
  $data = str_replace('</a><br>', '</a></span>', $data);
  $data = str_replace(' class=menu', '', $data);

  $match_count = preg_match_all($itemregexp, $data, $items);
  if($match_count > 15) $match_count = 15;

  for ($i=0; $i < $match_count; $i++) {
    $item = $items[1][$i];
    $title = substr(strip_tags($item),0,50) . "...";
    if (stristr($item, "href")) {
      $linkurl = stristr($item, "href");
      $linkurl = substr($linkurl, strpos($linkurl, "\"")+1);
      $linkurl = substr($linkurl, 0, strpos($linkurl, "\""));
      $linkurl = trim($linkurl);
      $link = $linkurl;
    } else {
      $link = $xml['link'];
    }
    $description = "<a href='$link'>$title</a>";
    $xml['item'] .= item_xml($title, $link, $description);
  }

