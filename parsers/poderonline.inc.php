<?php
  $xml['title']       = "PoderOnline";
  $xml['link']        = "http://www.poderonline.com.br/punto/por/default.htm";
  $xml['description'] = "Revista Poder Online";
  $xml['publisher']   = "Poder";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $html = read_file($xml['link']);
  $html = str_replace('Proceso topbuttons ...-->', '%%', $html);
  $html = str_replace('<!--- Begin Atualidade Table --->', '%%', $html);
  $html = str_replace('<!--- End Atualidade Table --->', '%%', $html);
  list($header, $destaque, $source, $footer) = split('%%', $html);
  
  $destaque = strip_tags($destaque, '<a><p><span>');
  $destaque = str_replace('<a href="', '##', $destaque);
  $destaque = str_replace('" class="normallink">', '##', $destaque);
  $destaque = str_replace('</a>', '##', $destaque);
  list($aux1, $aux2, $aux3, $link, $title, $description) = split('##', $destaque);
  $link = "http://www.poderonline.com.br".$link;
  $title = trim($title);
  $description = trim(str_replace('							', '', $description));
  $description = "<a href='$link'>$title</a><br>\n$description";
  $xml['item'] .= item_xml($title, $link, $description);
  
  $source = strip_tags($source, '<a><p><span>');
  $source = str_replace('<p>', '####', $source);
  $source = str_replace('</span><a href="', '##', $source);
  $source = str_replace('<a href="', 'http://www.poderonline.com.br', $source);
  $source = str_replace('" class="titlelink">', '##', $source);
  $source = str_replace('<span class="Author">', '##', $source);
  $source = str_replace('<span class="ChapeauDate">', '##', $source);
  $source = str_replace('<span class="chapeau">', '##', $source);
  $source = str_replace('</span>', '', $source);
  $source = str_replace('</a>', '', $source);
  $news = split('####', $source);
  $contador = count($news);
  if($contador > 15) $contador = 15;
  for($i = 1; $i <= $contador - 4; $i++) {
    list($link, $title, $newssource, $date, $text, $more) = split('##',  $news[$i]);
    $title = trim($title); $newssource = trim($newssource); $date = trim($date);
    $description = "<a href='$link'>$title</a><br>\n$newssource - $date<br>\n$text";
    $xml['item'] .= item_xml($title, $link, $description);
  }  
  

