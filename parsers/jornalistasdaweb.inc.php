<?php
  $xml['title']       = "Jornalistas da Web";
  $xml['link']        = "http://www.jornalistasdaweb.com.br/jw_miolo.asp";
  $xml['description'] = "Jornalistas da Web";
  $xml['publisher']   = "Jornal O Estado de São Paulo";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $data = read_file($xml['link']);
  $data = str_replace('&nbsp;', ' ', $data);
  $data = singleline($data);
  $items = split('idn=', $data);
  
   
  $imagem = '<img src="http://www.jornalistasdaweb.com.br/imagens/jw_rssficado.gif"
 width=516 height=60 border=0>';
 
  $contador = count($items);
  if($contador > 15) $contador = 15;
  for ($i=1; $i < $contador - 1; $i++) {
   
    $item = strip_tags(str_replace('">', '#', $items[$i]).'>');
    list($id, $title) = split('#', $item);
    $link = 'http://www.jornalistasdaweb.com.br/index_noticias.asp?idn='.$id;
    $newstext = read_file($link);
    $newstext = str_replace("<title>Notícias</title>", '%%', $newstext);
    $newstext = str_replace("</html>", '%%', $newstext);
    $newstext = strip_tags($newstext, "<A><B><BR><STRONG>");
    list($aux1, $aux2, $aux3, $aux4, $aux5, $description, $aux99) = split('%%', clearspaces($newstext));
    $description = "<a href='$link'>$imagem</a>\n<br><br>\n$description";
    $xml['item'] .= item_xml($title, $link, $description);
  }  


