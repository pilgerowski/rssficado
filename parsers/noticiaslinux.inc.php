<?

  $xml['link']        = "http://www.noticiaslinux.com.br/";
  $xml['title']       = "Noticias Linux";
  $xml['description'] = "Noticias Linux";
  $xml['publisher']   = "Noticias Linux";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $itemregexp = "%rss:item *\" *>(.+?)</span>%is";

  $data = read_file($xml['link']);
  $data = str_replace("</FORM>", "###", $data);
  $data = str_replace("Mais notícias...", "###", $data);
  list($cabecalho, $data, $rodape) = split("###", $data);

  $data = str_replace("<BR><BR>",'</span><BR><BR><span class="rss:item">', $data);
  $data = str_replace("</b><br><br>",'</b><br><br><span class="rss:item">', $data);

  $match_count = preg_match_all($itemregexp, $data, $items);
  if($match_count > 15) $match_count = 15;
  for ($i=0; $i< $match_count; $i++) {
    $description = trim($items[1][$i]);
    $title = strip_tags(substr($description, 0, strpos($description, "<br>")));
    if (stristr($description, "href")) {
      $linkurl = stristr($description, "href");
      $linkurl = substr($linkurl, strpos($linkurl, "\"")+1);
      $linkurl = substr($linkurl, 0, strpos($linkurl, "\""));
      $linkurl = trim($linkurl);
      $url = $linkurl;
    } else {
      $url = $xml['link'];
    }
    $xml['item'] .= item_xml($title, $url, $description);
  }

?>
