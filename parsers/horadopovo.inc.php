<?
  $xml['title']       = "Hora do Povo";
  $xml['link']        = "http://www.horadopovo.com.br/indice.htm";
  $xml['description'] = "Jornal Hora do Povo";
  $xml['publisher']   = "Jornal Hora do Povo";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $data = read_file($xml['link']);
  $data = strip_tags($data, '<a><li>');
  $match_count = preg_match_all("%li\>(.+?)\<\/li%is", $data, $items);
  if($match_count > 15) $match_count = 15;

  for ($i=0; $i< $match_count; $i++) {
    $noticia = $items[1][$i];
    $temp = preg_match_all("%href\=\"(.+?)\"%is", $noticia, $aux);
    $link = "http://www.horadopovo.com.br/".$aux[1][0];    
    $temp = preg_match_all("%\>(.+?)\<%is", $noticia, $aux);
    $title = singleline($aux[1][0]);
    $description = "<a href=$link>$title</a>";    
    $xml['item'] .= item_xml($title, $link, $description);
  }

?>
