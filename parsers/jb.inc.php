<?
  $xml['title']       = "JB Online - Tempo Real";
  $xml['link']        = "http://jbonline.terra.com.br/extra/extra1.html";
  $xml['description'] = "JB Online - Tempo Real";
  $xml['publisher']   = "Jornal do Brasil S/A";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $html = read_file($xml['link']);
  $html = ereg_replace('<!--LISTA NOTICIAS-->', '####################', $html);
  $html = str_replace('</font>', "\n", $html);
  $allowable_tags = "<a><br>";
  list($header, $source, $footer) = split('####################', strip_tags($html, $allowable_tags));

  $noticias = split('<br><br>', $source);
  
  $total = count($noticias);
  if($total > 15) $total = 15;
  for($i = 1; $i <= $total; $i++) {
    $noticia = trim($noticias[$i]);
    $noticia = str_replace('<a href="', '', $noticia);
    $noticia = str_replace('">', '##', $noticia);
    $noticia = str_replace('</a><br>', '##', $noticia);
    list($link, $title, $categ) = split('##', $noticia); 
    $title = singleline($title);
    $description = singleline($categ.": ".$title);
    $link = 'http://jbonline.terra.com.br'.$link;  
    $xml['item'] .= item_xml($title, $link, $description);
  }
 
?>