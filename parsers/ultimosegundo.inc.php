<?php
  $xml['title']       = "Ultimo Segundo";
  $xml['link']        = "http://www.ig.com.br/useg/usflash/0,,,00.html";
  $xml['description'] = "iG - Último Segundo";
  $xml['publisher']   = "ig";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $html = read_file($xml['link']);
  $html = str_replace(' onMouseover=para() onMouseout=continua()', '', $html); 
  $html = str_replace("adiciona_noticia('", "##", $html);
  $html = str_replace(' target="_blank"', "", $html);
  $html = str_replace("init(noticias);", "", $html);
  $html = str_replace('</td><td>', '%%', $html);
  $html = str_replace("');", "", $html);
  $html = strip_tags($html,'<a>');
  $noticias = split('##', $html);
  $total = count($noticias) - 1;
  if($total > 15) $total = 15;
  for($i = 1; $i <= $total; $i++) {
    $noticia = trim($noticias[$i]);
    list($sessao, $aux) = split('%%', $noticia);
    $description = "$sessao - $aux";
    $aux = str_replace(' <a href="', '', $aux);
    $aux = str_replace('</a>', '', $aux);
    list($link, $title) = split('">', $aux);
    $xml['item'] .= item_xml($title, $link, $description); 
  }
  

