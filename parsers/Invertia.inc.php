<?

  $xml['link']        = "http://br.invertia.com/noticias/";
  $xml['title']       = "Invertia";
  $xml['description'] = "Invertia";
  $xml['publisher']   = "Invertia";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $data = read_file($xml['link']);
  $data = str_replace("<body ", "###", $data);
  $data = str_replace("</body>", "###", $data);
  list($cabecalho, $data, $rodape) = split("###", $data);

  $data = str_replace("<span class=f>",'<span class="rss:item">', $data);
  $data = str_replace("</span>",'', $data);
  $data = str_replace("<td nowrap class=t>",'</span>', $data);
  $data = str_replace("a href='",'a href="http://br.invertia.com/noticias/', $data);
  $data = str_replace("' class=ma>",'">', $data);

  $itemregexp = "%rss:item *\" *>(.+?)</span>%is";
  $match_count = preg_match_all($itemregexp, $data, $items);
  if($match_count > 15) $match_count = 15;
  
  for ($i=0; $i< $match_count; $i++) {
    $description = $items[1][$i];
//    $title = substr($description, 0, strpos($description, "<br>"));;
    list($aux, $title) = split("<br>", $description);
    list($title, $aux) = split('&nbsp', $title);
    $title = strip_tags($title);
    $description = str_replace('&nbsp;', '<br>', $description);
    if (stristr($description, "href")) {
      $link = stristr($description, "href");
      $link = substr($link, strpos($link, "\"")+1);
      $link = substr($link, 0, strpos($link, "\""));
      $link = trim($link);
    } else {
      $link = $xml['link'];
    }
    $xml['item'] .= item_xml($title, $link, $description);
  }

?>
