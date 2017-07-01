<?
  $xml['title']       = "Aprendiz";
  $xml['link']        = "http://www.uol.com.br/aprendiz/guiadeempregos/terceiro/noticias/";
  $xml['description'] = "Aprendiz - Notícias do Terceiro Setor";
  $xml['publisher']   = "Aprendiz";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $data = read_file($xml['link']);
  $data = str_replace('bullet_va3.gif">&nbsp;', '">######', $data);
  $data = strip_tags($data, '<a>');
  $news = split('######', $data);
  for ($i=1; $i < 8; $i++) {
    $new = clearspaces(singleline($news[$i]));
    $title = trim(strip_tags($new));
    $link = $xml['link'].ereg_replace("\".*", '', str_replace('<a href="', '', $new));
    $description = "<a href=$link>$title</a>";
    $xml['item'] .= item_xml($title, $link, $description);
  }
?>
