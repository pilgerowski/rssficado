<?
  $xml['title']       = "Tecbol";
  $xml['link']        = "http://bol.com.br/noticias/tecbol/leia_mais.html";
  $xml['description'] = "Tecbol";
  $xml['publisher']   = "Tecbol";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $html = read_file($xml['link']);
  $html = str_replace('<!-------/ MIOLO-SUB ------->', '<!------- MIOLO-SUB ------->', $html);
  list($header, $source, $footer) = split('<!------- MIOLO-SUB ------->', $html);
  list($source, $aux) = split('ONTEM', $source);
  $source = str_replace('&nbsp;', ' ', $source);
  $source = str_replace('</A>', '</a>', $source);
  $allowable_tags = "<A>";
  $source = strip_tags($source, $allowable_tags);
  $lines = split("\n", $source);
  $total = count($lines);
  if($total > 15) $total = 15;
  for($i = 10; $i <= $total; $i++) {
    $line = trim($lines[$i]);
    if($line != '') {
      if(strlen($line) == 5) {
        $hour = $line;
      } else {
        list($title, $description) = split('</a>', $line);
        $title = str_replace('<a href="', '', $title);
        list($link, $title) = split('">', $title);
        $link = 'http://bol.com.br'. $link;
        $description = "<a href='$link'>$title</a><br>$description";
        $title = "[$hour] $title";
        $xml['item'] .= item_xml($title, $link, $description);
      }  
    }  
  }
?>
