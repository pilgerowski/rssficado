
<?
  $xml['title']       = "Digito";
  $xml['link']        = "http://www.digito.pt/";
  $xml['description'] = "A DIGITO é o maior site informativo em Portugal dedicado à tecnologia e informática em geral. Conta com aproximadamente 30.000 assinantes da sua newsletter semanal e uma média de 900.000 visualizações de páginas por mês. ";
  $xml['publisher']   = "Digito";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página
  
  $html = read_file($xml['link']);
  $html = str_replace('<p id="separadorcentral">&nbsp;</p>', '##########', $html);
  $html = str_replace('<!-- end coluna central -->', '##########', $html);
  $html = str_replace('<br clear="left">', '%%', $html);
  $html = str_replace('href="/', 'href="http://www.digito.pt/', $html);
  $allowable_tags = "<A>";
  list($header, $source, $footer) = split('##########', strip_tags($html, $allowable_tags));
  $source = clearspaces($source);
  $noticias = split('%%', $source);
  $contador = count($noticias);
  if($contador > 15) $contador = 15;
  for($i = 0; $i < $contador - 1; $i++) {
    $description = $noticias[$i];
    $description = str_replace("\n", "<br>", $description);
    list($titlelink, $aux) = split("</a>", $description);
    list($url, $title) = split('" id="titulo">', strip_tags($titlelink, $allowable_tags));
    $link = str_replace('<a href="','', $url);
    $xml['item'] .= item_xml($title, $link, $description); 
  }
?>
