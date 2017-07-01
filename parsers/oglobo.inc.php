<?
  $xml['title']       = "O Globo - Plantão de Noticias";
  $xml['link']        = "http://oglobo.globo.com/plantao/";
  $xml['description'] = "O Globo - Plantão";
  $xml['publisher']   = "Jornal O Globo";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $itemregexp = "%rss:item *\" *>(.+?)</span>%is";
  $data = read_file($xml['link']);
              
  $data = str_replace('<p class="plantao">','<span class="rss:item">',$data);
  $data = str_replace('</p>', '</span>', $data);

  $match_count = preg_match_all($itemregexp, $data, $items);
  if($match_count > 15) $match_count = 15;

  for ($i=0; $i < $match_count; $i++) {
    $item = strip_tags($items[1][$i], '<a>');
    $item = str_replace('|  - ', '', $item);
    $item = str_replace('<a href="', '##', $item);
    $item = str_replace('" class="', '##', $item);
    $item = str_replace('">', '##', $item);
    $item = str_replace('</a><a href="', '##', $item);
    $item = str_replace('" name="', '##', $item);
    $item = str_replace('" class="plantao">', '##', $item);
    $item = str_replace('</a>', '', $item);

    list($hora, $linkEditoria, $idEditoria, $nomeEditoria, $linkNoticia, $idNoticia, $estiloNoticia, $title) = split("##", $item);
    $linkEditoria = 'http://oglobo.globo.com'.$linkEditoria;
    $linkNoticia  = 'http://oglobo.globo.com'.$linkNoticia;
    $description = "$hora [ <a href='$linkEditoria'>$nomeEditoria</a> ] : <a href='$linkNoticia'>$title</a>";
    $xml['item'] .= item_xml($title, $linkNoticia, $description);
  }

?>