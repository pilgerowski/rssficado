<?
  $xml['title']       = "Terra - Notícias";
  $xml['link']        = "http://www.terra.com.br/noticias/ultimas.htm";
  $xml['description'] = "Terra - Notícias";
  $xml['publisher']   = "Terra";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $itemregexp = "%rss:item *\" *>(.+?)</span>%is";
  $allowable_tags = "<A><BR><FONT>";

  $data = read_file($xml['link']);
  $data = str_replace('content="0;URL=', '##', $data);
  $data = str_replace('">',              '##', $data);
  list($lixo1, $link) = split('##', $data);
 
  $data = read_file($link);
  $data = strip_tags($data, $allowable_tags);
  $data = str_replace('<font class="textomiolo">', "###", $data);
  $items = split("###", $data);
  $numitems = count($items);
  if($numitems > 15) $numitems = 15;
  for($i = 1; $i <= $numitems; $i++) {
    $item = str_replace(' class="textomiolo" > ', '', singleline($items[$i]));
    $item = str_replace('</a><br> ', '', $item);
    list($hour, $url, $title) = split('"', $item);
    $description = strip_tags($hour).' '.$title;
    $xml['item'] .= item_xml($title, $url, $description);
  }  
?>