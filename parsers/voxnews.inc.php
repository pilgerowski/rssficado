<?php
  $xml['title']       = "Vox News";
  $xml['link']        = "http://www.voxnews.com.br/";
  $xml['description'] = "Vox News";
  $xml['publisher']   = "AdVertica.com";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $itemregexp = "%rss:item *\" *>(.+?)</span>%is";
  $allowable_tags = "<A><B><BR><BLOCKQUOTE><CENTER><DD><DL><DT><HR><I><LI><OL><P><PRE><U><UL>";
  $html = read_file($xml['link']);
  $html = str_replace('<!-- Ini de uma notícia -->', '<span class="rss:item">', $html);
  $html = str_replace('<!-- Fim de uma notícia -->', '</span>', $html);
  $match_count = preg_match_all($itemregexp, $html, $items);
  if($match_count > 15) $match_count = 15;
  for ($i=0; $i< $match_count; $i++) {
    $item = strip_tags($items[1][$i], $allowable_tags);
    $item = str_replace('<a href="', '%%', $item);
    $item = str_replace('</a>', '%%', $item);
    $item = str_replace('">', '%%', $item);
    list($aux1, $link, $title) = split('%%', $item);
    $link = $xml['link'].$link;
    $description = "<a href='$link'>$title</a>";
    $xml['item'] .= item_xml($title, $link, $description); 
  }


