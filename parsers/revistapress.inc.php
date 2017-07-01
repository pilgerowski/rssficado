<?
  $xml['title']       = "Revista Press";
  $xml['link']        = "http://www.revistapress.com.br/rapidinhas/capa.asp";
  $xml['description'] = "Revista Press";
  $xml['publisher']   = "Revista Press";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $html = read_file($xml['link']);
  $cabecalho = 'r.press@terra.com.br';
  $html = ereg_replace(".*$cabecalho", '', $html);
  $html = ereg_replace("<font size=\"1\">..\...</font>", "", $html);
  $html = ereg_replace("[0-9][0-9].[0-1][0-9]", '', $html);
  $html = clearspaces(strip_tags($html, "<A><BR>"));
  $separador = '<a href="../contato/comentario.asp" class="comentario">Comente
esta nota</a>';
  $html = str_replace($separador, '%%', $html);  
  $items = split("%%", $html);
  $contador = count($items);
  if($contador > 15) $contador = 15;
  $link = $xml['link'];
  for ($i=0; $i < $contador - 1; $i++) {
    $description = str_replace('&nbsp;', ' ', clearspaces($items[$i]));
    $separador = '<br>';
    $aux = split($separador, $description);
    $j = 0; $title = ''; 
    while($title == '') { $title = singleline(strip_tags($aux[$j])); $j++; } 
    $description = singleline($description);
    $xml['item'] .= item_xml($title, $link, $description);
  }
?>
