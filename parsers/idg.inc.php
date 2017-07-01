<?
  $xml['title']       = "IDG Now! Br";
  $xml['link']        = "http://idgnow.terra.com.br/idgnow/todas.html";
  $xml['description'] = "IDG Now! Brasil";
  $xml['publisher']   = "IDGNow";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $data = read_file($xml['link']);
  $data = str_replace("<!--/TABELA LOCALIZACAO + DATA--->", "###", $data);
  $data = str_replace("<!--/COLUNA DO MEIO--->", "###", $data);
  list($cabecalho, $data, $rodape) = split("###", $data);

  $data = strip_tags($data, "<A><BR><NOBR>");
  
  $items = split("</nobr>", $data);
  if(count($items) < 20) { $count = count($items); } else { $count = 20; }
  for($i = 0; $i <= $count; $i++) {
    $item = singleline(strip_tags( $items[$i], "<A>"));
    $item = str_replace('<a href="', '',   $item);
    $item = str_replace('">',        '##', $item);
    $item = str_replace('</a>',      '##', $item);
    $item = str_replace('[',         '##', $item);
    list($link, $title, $description) = split('##', $item);
    if(!empty($title)) {
      $xml['item'] .= item_xml($title, $link, $description);
    }  
  }
?>
