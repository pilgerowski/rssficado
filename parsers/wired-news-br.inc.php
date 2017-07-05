<?php
  $xml['title']       = "Wired News Br";
  $xml['link']        = "http://br.wired.com";
  $xml['description'] = "Wired News Brasil";
  $xml['publisher']   = "Wired";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $source = read_file($xml['link']);
  $source = str_replace("<!-- BEGIN Main Stories -->", "###", $source);
  $source = str_replace("<!-- END Story List -->", "###", $source);
  list($cabecalho, $texto, $rodape) = split("###", $source);
 
  $texto = str_replace('<p class="large">', '<p>', $texto);
  $texto = str_replace('<p> ', '<p>', $texto);
  $texto = str_replace(' class="hd"', '', $texto);
  $texto = strip_tags($texto, "<A><P>");
  
  $posts = split('<p>', $texto);
  $num_posts = count($posts);
  if($num_posts > 10) $num_posts = 10;
  for($i = 1; $i < $num_posts; $i++) {
    list($title_aux, $description_aux1, $description_aux2) = split('</a>', $posts[$i]);
    $title_aux = str_replace("<a href='", "", $title_aux);
    list($link, $title) = split("'>", $title_aux);
    $link = "http://br.wired.com".$link;
    $description = trim(strip_tags($description_aux1.$description_aux2));
    $url = '<a href="'.$link.'">'.$title.'</a>';
    $description = "         $url <br>
         $description"; 
    $xml['item'] .= item_xml($title, $link, $description);
  }


