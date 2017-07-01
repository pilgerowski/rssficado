<?
  $xml['title']       = "Agencia Brasil";
  $xml['link']        = "http://www.agenciabrasil.gov.br/brasilagora.phtml";
  $xml['description'] = "Agencia Brasil";
  $xml['publisher']   = "Radiobras";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $data = read_file($xml['link']);
  $data = str_replace('<!-- R2 -->', '%%', $data);
  $data = str_replace('</center>', '%%', $data);
  list($lixo1, $lixo2, $noticias) = split('%%', $data);
  $noticias = strip_tags($noticias, '<a>');
  $noticias = str_replace('<a href="', '##', $noticias); 
  $noticias = str_replace('">', '##', $noticias); 
  $noticias = str_replace('</a>', '##', $noticias);
  $items = split('##&nbsp;', $noticias);
  
  $numitems = count($items);
  if($numitems > 20) $numitems = 20;
  for($i = 0; $i < $numitems; $i++) {
    list($data, $link, $title) = split('##', singleline($items[$i]));
    $title = trim($title);
    $description = $data.$title;
    $link = 'http://www.agenciabrasil.gov.br/'.trim($link);
    $xml['item'] .= item_xml($title, $link, $description);
  }
?>
