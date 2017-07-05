<?php
  $xml['title']       = "Ethos";
  $xml['link']        = "http://www.ethos.org.br/notas/applet.txt";
  $xml['description'] = "Intituto Ethos de Responsabilidade Social";
  $xml['publisher']   = "Instituto Ethos";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $data = read_file($xml['link']);
  $lines = split("\n", $data);
  for($i=0; $i < count($lines); $i++) {
    $line = $lines[$i];
    if(eregi("^\|", $line)) {
      $line = ereg_replace("^\|", "", $line);
      $line = str_replace(", | |", "%", $line);
      $line = str_replace(", |", "", $line);
      $aux = split("%", $line);
      $title = '';
      for($j = 0; $j < count($aux); $j++) {
        list($word, $link) = split(", ", $aux[$j]);
        $title.= $word." ";
      }  
      $description = '<a href="'.trim($link).'">'.$title.'</a>';
      $xml['item'] .= item_xml($title, $link, $description);
    }
  } 

