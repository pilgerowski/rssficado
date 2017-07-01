<?
  $xml['title']       = "Centro de Mídia Independente";
  $xml['link']        = "http://www.midiaindependente.org";
  $xml['description'] = "O CMI-Brasil é um centro de mídia independente que busca oferecer informação para a construção de uma sociedade livre, igualitária e que respeite o meio ambiente. ";
  $xml['publisher']   = "CMI-Brasil";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página
  
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
