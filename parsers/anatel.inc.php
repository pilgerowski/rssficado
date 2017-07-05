<?php
  $xml['title']       = "Anatel";
  $xml['link']        = "http://www.anatel.gov.br/home/noticias.asp";
  $xml['description'] = "Anatel - Agência Nacional de Telecomunicações";
  $xml['publisher']   = "Anatel";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $html = read_file($xml['link']);
  $html = str_replace('MANCHETES', '##########', $html);
  $html = str_replace('var nav = (document.layers);', '##########', $html);
  $html = str_replace('<td class="manchete">', '%%', $html);
  $html = str_replace('<a href="#"', '<p', $html);
  $html = str_replace('Documentos Anexos</a>', '', $html);

  $allowable_tags = "<A>";
  list($header, $source, $footer) = split('##########', strip_tags($html, $allowable_tags));
  $source = str_replace('<a href="/index.asp?link=/ajuda/PDF/Release_PDF.htm"></a>','', $source);
  $source = str_replace('href="/index.asp', 'href="http://www.anatel.gov.br/index.asp', $source);
  $source = str_replace('</a>', 'link</a>', $source);
  $source = clearspaces($source);

  $noticias = split('%%', $source);
  $contador = count($noticias);
  if($contador > 15) $contador = 15;
  for($i = 1; $i <  $contador; $i++) {
    $description = $noticias[$i];
    $lines = split("\n", $description);
    $title = trim($lines[0]);
    $link  = str_replace('<a href="','', trim($lines[2]));
    $link  = str_replace('">link</a>', '', $link);
    $link  = str_replace('index.asp?link=/', '', $link); 
    $xml['item'] .= item_xml($title, $link, $description); 
  } 

