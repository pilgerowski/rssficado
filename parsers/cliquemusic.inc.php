<?
  $xml['title']       = "CliqueMusic";
  $xml['link']        = "http://cliquemusic.uol.com.br/br/Cybernotas/Cybernotas.asp";
  $xml['description'] = "CliqueMusic";
  $xml['publisher']   = "CliqueMusic";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $itemregexp = "%div *\" *>(.+?)</div>%is";
  $itemregexp = "%div class=\"tit\">(.+?)</div>%is";
  $html = read_file($xml['link']);
  $match_count = preg_match_all($itemregexp, $html, $items);
  if($match_count > 15) $match_count = 15;
  for ($i=0; $i < $match_count; $i++) {
    $item = str_replace('&nbsp;', ' ', clearspaces($items[1][$i]));
    $link = "http://cliquemusic.uol.com.br/br/Cybernotas/Cybernotas.asp?Nu_Materia=";
    $link.= ereg_replace(".*Materia=|\"\>.*", "", $item);
    $title = trim(clearspaces(strip_tags($item)));
    $description = "<a href='$link'>$title</a>";
    $xml['item'] .= item_xml($title, $link, $description);
  }
?>
