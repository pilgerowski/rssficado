<?
  $xml['title']       = "Web Insider";
  $xml['link']        = "http://webinsider.uol.com.br/xml_out.php";
  $xml['description'] = "Web Insider";
  $xml['publisher']   = "Web Insider";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $data = read_file($xml['link']);

  preg_match_all("%<materia>(.+?)</materia%is", $data, $items);
  while(list($i,$k) = each($items)) {
    while(list($j,$l) = each($k)) {
      preg_match_all("%<titulo>(.+?)</titulo>%is", $l, $subitems);
      $title = strip_tags($subitems[0][0]);
      preg_match_all("%<url>(.+?)</url>%is", $l, $subitems);
      $link = strip_tags($subitems[0][0]);
      preg_match_all("%<texto>(.+?)</texto>%is", $l, $subitems);
      $description = trim(strip_tags($subitems[0][0]));
      $xml['item'] .= item_xml($title, $link, $description);
    }  
  }
 
?>