<?
  $xml['title']       = "OLinux Notícias";
  $xml['link']        = "http://www.olinux.com.br/news/";
  $xml['description'] = "OLinux Notícias";
  $xml['publisher']   = "UOL";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $html = read_file($xml['link']);
  $html = str_replace('<!-- CONTEUDO -->', '##', $html);
  $html = str_replace('Próximo', '##', $html);

  list($header, $source, $footer) = split('##', $html);
  $source = trim(strip_tags($source, '<a>'));
  $source = str_replace('&nbsp;', "####", $source);
  $source = str_replace('<a href="', '', $source);
  $source = str_replace('" class=titart>', "##", $source);
  $source = str_replace('</a>', '##', $source);
  $news = split('####', $source);
  $contador = count($news);
  if($contador > 15) $contador = 15;
  for($i = 1; $i <= $contador - 2; $i++) {
    list($link, $title, $description) = split('##', $news[$i]);
    $link = 'http://olinux.uol.com.br'.$link;
    $title = trim($title);
    $description = trim("<a href=$link>$title</a><br>\n$description");
    $xml['item'] .= item_xml($title, $link, $description); 
  }
  
?>