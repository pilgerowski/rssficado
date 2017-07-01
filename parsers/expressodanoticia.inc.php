<?
  $xml['title']       = "Expresso da Not�cia";
  $xml['link']        = "http://www.expressodanoticia.com.br/main.asp";
  $xml['description'] = "Expresso da Not�cia";
  $xml['publisher']   = "Expresso da Not�cia";
  $xml['item']        = ""; // Esta variavel ser� preenchida durante o parsing da p�gina

  $html = read_file($xml['link']);
  $html = str_replace('<font face="Arial" size="5" color="#000080">', '#ITEM#', $html);
  $html = str_replace('<font face="Arial" size="3">', '#SUBITEM#', $html);
  $html = str_replace('&nbsp;', ' ', $html);
  $html = singleline(strip_tags($html, '<a>'));
  $items = split('#ITEM#', $html);
  $contador = count($items);
  if($contador > 15) $contador = 15;
  for ($i=1; $i < $contador - 2; $i++) {
    list($title, $aux) = split('#SUBITEM#', $items[$i]);
    $aux = str_replace('<a href=conteudo.asp?Codigo=', '', $aux);
    list($link, $description) = split('>', $aux);
    $link = "http://www.expressodanoticia.com.br/conteudo.asp?Codigo=".trim($link);
    if(clearspaces($title) != '') {
      $xml['item'] .= item_xml($title, $link, $description);
    } 
  }
?>
