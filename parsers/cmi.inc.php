<?
  $xml['title']       = "Centro de M�dia Independente";
  $xml['link']        = "http://www.midiaindependente.org";
  $xml['description'] = "O CMI-Brasil � um centro de m�dia independente que busca oferecer informa��o para a constru��o de uma sociedade livre, igualit�ria e que respeite o meio ambiente. ";
  $xml['publisher']   = "CMI-Brasil";
  $xml['item']        = ""; // Esta variavel ser� preenchida durante o parsing da p�gina
  
  $host = 'http://www.midiaindependente.org/';

  $source = read_file($xml['link']);
  $source = strip_tags($source, '<a>');
  
//  $source = str_replace('class="separator"', '##########<a', $source);

  $source = str_replace('<a class="featuretitle" href="', '%%', $source);
  $source = str_replace('">', '##', $source);
  $source = str_replace('</a>', '##', $source);

  $noticias = split('%%', $source);
  $contador = count($noticias);
  if($contador > 15) $contador = 15;
  for($i = 1; $i < ($contador - 1); $i++) {
    $noticia = $noticias[$i];
    list($link, $title, $description_aux1) = split('##', $noticia);
    $link = str_replace('//pt', '/pt', $host.$link);
    $descriptionaux2 = split("\[", $description_aux1);
    $description = clearspaces($descriptionaux2[0]);
    $xml['item'] .= item_xml($title, $link, $description); 
  }  

?>
