<?
  $xml['title']       = "Bloomberg";
  $xml['link']        = "http://www.bloomberg.com/br/bus_news.html";
  $xml['description'] = "Bloomberg NewsBR";
  $xml['publisher']   = "Bloomberg";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $html = read_file($xml['link']);
  $html = trim(strip_tags($html, '<a><span>'));
  $html = str_replace('<SPAN CLASS="headln">', '##', $html);
  $html = str_replace('<SPAN CLASS="story">', '%%', $html);
  $html = str_replace('<SPAN CLASS="link2">', '%%', $html);
  $html = str_replace('</SPAN>', '', $html);
  $news = split("##", $html);
  $contador = count($news);
  if($contador > 15) $contador = 15; 
  for($i = 1; $i < $contador; $i++) {
    list($title, $description, $link) = split('%%', $news[$i]);
    $description = "$description <br>\n$link";
    $link = str_replace('<A HREF="', '', $link);
    $link = trim(str_replace('">Mais...</A>', '', $link));
    $xml['item'] .= item_xml($title, $link, $description); 
  }
?>
