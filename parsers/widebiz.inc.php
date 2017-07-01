<?
  $xml['title']       = "WideBIZ";
  $xml['link']        = "http://www.widebiz.com.br";
  $xml['description'] = "widebiz - relacionamentos e neg�cios";
  $xml['publisher']   = "Widesoft";
  $xml['item']        = ""; // Esta variavel ser� preenchida durante o parsing da p�gina

  $html = read_file($xml['link']);
  $html = str_replace('<!-- Marca para o Gerador de HTML -->', '##########', $html);
  $html = str_replace('<!--- local para banner -->', '##########', $html);
  list($header, $source, $footer) = split('##########', $html);
  $source = str_replace('&nbsp;', ' ', $source);
  $source = str_replace('</A>', '</a>', $source);
  $allowable_tags = "<A>";
  $source = strip_tags($source, $allowable_tags);
  $source = ereg_replace('Cases|Comportamento|Conte�do|Cybercultura|Design|e-Books|e-Business|e-Commerce|Educa��o|Estrat�gia|Fic��o|Finan�as|Gest�o|Humor|Jornalismo|Legisla��o|Log�stica|Marketing|Pol�tica|Propaganda|Resenhas|Telemedicina|Teletrabalho|Vida Digital|WideBiz Radio|WideBiz Talk', '', $source);
  $lines = split("\n", $source);
  $total = count($lines);
  if($total > 15) $total = 15;
  $title = $link = $description = '';
  for($i = 0; $i <= $total; $i++) {
    $line = trim($lines[$i]);
    if(strip_tags($line) != "") {
      if(ereg('<a href="', $line)) {
        if(!ereg('Leia mais', $line)) {
          $title = strip_tags($line);
        } else {
          $description = "$title<br>\n$description<br>\n$line";
          list($link, $aux) = split('">', $line);
          $link = str_replace('<a href="', '', $link);
          $xml['item'] .= item_xml($title, $link, $description); 
          $title = $link = $description = '';
        }
      } else {
        $description .= "$line<br>\n";
      }    
    }  
  } 
?>
