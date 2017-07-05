<?php
  $xml['title']       = "Blue Bus";
  $xml['link']        = "http://www.bluebus.com.br/capa.shtml";
  $xml['description'] = "Blue Bus";
  $xml['publisher']   = "BlueBus";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $fonte = read_file($xml['link']);
  $linhas = split("\n", $fonte);
  $total = count($linhas);
  for($i = 40; $i < $total; $i++) {
    $linha = $linhas[$i];
    if(ereg('/cgi-bin/show.pl', $linha)) {
      $linha = str_replace('"', '', $linha);
      $linha = ereg_replace('<a href=|</a><br>' , '', $linha);
      $linha = trim($linha);
      list($link, $title) = split(' class=menu>', $linha);
      $link = 'http://www.bluebus.com.br'.$link;
      $description = "<a href='$link'>$title</a>";
      $xml['item'] .= item_xml($title, $link, $description); 
    }  
  }  

