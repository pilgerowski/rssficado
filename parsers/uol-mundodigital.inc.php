<?php
  $xml['title']       = "UOL Mundo Digital";
  $xml['link']        = "http://noticias.uol.com.br/mundodigital/ultimas/";
  $xml['description'] = "UOL Mundo Digital";
  $xml['publisher']   = "UOL";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $html = read_file($xml['link']);

  $html = ereg_replace("\<font class\=preto10\>", "<span class='rss:item'>", $html);
  $html = str_replace('<br><img src=http://img.uol.com.br/x.gif width=1 height=8><br>', "</span>", $html);
  $itemregexp = "%rss:item *\' *>(.+?)</span>%is";
  $allowable_tags = "<A><SPAN>";
  $html = strip_tags($html, $allowable_tags);
  $match_count = preg_match_all($itemregexp, $html, $items);
  if($match_count > 25) $match_count = 25;
  for ($i=0; $i< $match_count; $i++) {
    $noticia = $items[1][$i];
    $noticia = str_replace('<a href=', '%%', $noticia);
    $noticia = str_replace(' class=no>', '%%', $noticia);
    $noticia = str_replace('</a>', '%%', $noticia);
    list($fonte, $link, $title, $aux) = split('%%', $noticia);
    $fonte = trim(ereg_replace("[0-9][0-9]h[0-9][0-9] - ", "", $fonte));
    $description = "[$fonte] <a href='$link'>$title</a>";    
    $xml['item'] .= item_xml($title, $link, $description);
  }  
  

