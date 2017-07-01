<?
  $xml['title']       = "Google News";
  $xml['link']        = "http://news.google.com/";
  $xml['description'] = "Google News Search";
  $xml['publisher']   = "Google";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $html = read_file($xml['link']);
  $html = str_replace('<a class=s href=#SPORTS>Sports</a>', '##########', $html);
  $html = str_replace('&copy;2002 Google', '##########', $html);
  $html = ereg_replace('<a class=.', '%%<a', $html);
  $html = str_replace('<a name=WORLD>', '##########', $html);

  $allowable_tags = "<A>";
  list($header, $source, $footer) = split('##########', strip_tags($html, $allowable_tags));
  $noticias = split('%%', $source);
  $contador = count($noticias);
  if($contador > 15) $contador = 15;
  for($i = 1; $i < $contador; $i++) {
    $noticia = str_replace('<a href=', '#', $noticias[$i]);
    $noticia = str_replace('</a>', '#', $noticia);
    $noticia = str_replace('>', '#', $noticia);
    list($aux1, $link, $title, $aux2) = split('#', $noticia); 
    $description = $noticias[$i];
    $xml['item'] .= item_xml($title, $link, $description); 
  } 
?>
