<?
  $xml['title']       = "MTV Brasil";
  $xml['link']        = "http://www.mtv.com.br/clube/drops/";
  $xml['description'] = "MTV Brasil";
  $xml['publisher']   = "MTV Brasil";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $html = read_file($xml['link']);
  $cabecalho = '<table width="505" cellpadding="0" cellspacing="0"border="0">';
  $html = ereg_replace(".*$cabecalho", '', $html);
  $html = clearspaces(strip_tags($html, "<A>"));
  $html = ereg_replace("a\nhref", "a href", $html);
  $html = ereg_replace("../../..", "", $html);
  $items = split("\n", $html);
  $contador = count($items);
  if($contador > 15) $contador = 15;
  for ($i=0; $i < $contador; $i++) {
    $item = str_replace('&nbsp;', ' ', clearspaces($items[$i]));
    $link = ereg_replace(".*a href=\"", '', $item);
    $link = ereg_replace("\".*", '', $link);
    $link = "http://www.mtv.com.br/clube/drops/$link";
    $title = trim(clearspaces(strip_tags($item)));
    $description = "<a href='$link'>$title</a>";
    $xml['item'] .= item_xml($title, $link, $description);
  }
?>
