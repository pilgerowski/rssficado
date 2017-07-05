<?php
  $xml['title']       = "MacMania";
  $xml['link']        = "http://www.terra.com.br/macmania/index2.htm";
  $xml['description'] = "MacMania";
  $xml['publisher']   = "MacMania";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $itemregexp = "%<span class=\"titulo2\">(.+?)</span>%is";
  $html = read_file($xml['link']);
  $html = ereg_replace("\<\!--M_...--\>", '##', $html); 
  $match_count = preg_match_all($itemregexp, $html, $items);
  if($match_count > 15) $match_count = 15;
  for ($i=1; $i < $match_count; $i++) {
    $item = $items[1][$i];
    list($auxlink1, $title, $lixo, $description) = split("##", $item);
    list($aux1, $auxlink2, $aux2) = split('"', $auxlink1);
    $link = "http://www.terra.com.br".$auxlink2;
    $xml['item'] .= item_xml($title, $link, $description);
  }

