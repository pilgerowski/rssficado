<?php
  $xml['title']       = "Usina do Som";
  $xml['link']        = "http://www.usinadosom.com.br/default.asp";
  $xml['description'] = "Usina do Som";
  $xml['publisher']   = "Usina do Som";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $html = read_file($xml['link']);
  $html = ereg_replace(".*<!--INICIO NOTICIAS-->", '', $html);
  $html = ereg_replace("Rádios<\/font><\/td>.*", '', $html);
  $html = clearspaces(strip_tags($html, "<A>"));
  $items = split('&nbsp;&#149;', $html);
  $contador = count($items);
  if($contador > 15) $contador = 15;
  for ($i=1; $i < $contador; $i++) {
    $item = str_replace('&nbsp;', ' ', clearspaces($items[$i]));
    $link = "http://www.usinadosom.com.br/".ereg_replace("<a href=|>.*|\"|\'", "", $item);
    $title = trim(clearspaces(strip_tags($item)));
    $description = "<a href='$link'>$title</a>";
    $xml['item'] .= item_xml($title, $link, $description);
  }

