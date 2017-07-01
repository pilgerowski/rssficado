<?
  $xml['title']       = "Agencia Estado";
  $xml['link']        = "http://www11.estadao.com.br/agestado/";
  $xml['description'] = "Ultimas Noticias - Estadao.com.br";
  $xml['publisher']   = "Jornal O Estado de São Paulo";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $data = read_file($xml['link']);
  $data = str_replace("<td bgcolor=\"#6699CC\"><font face=\"arial,verdana\" size=2 color=\"#FFFFFF\">", "######", $data);
  $data = str_replace("<!-- INICIO TABELA NOTICIAS -->", "######", $data);
  $data = str_replace("<!-- FINAL  TABELA NOTICIAS -->", "######", $data);

  list($lixo1, $lixo2, $destaques, $trash, $rodape) = split("######", $data);

  $data = $destaques;
   
  $data = strip_tags($data, '<a>');
  $itemregexp = "%rss:item *\' *>(.+?)</span>%is";
  $separator = "</span><span class='rss:item'><a href='http://www.estadao.com.br";
  $data = str_replace("<a href='", $separator, $data);
  $data = str_replace("</a></td></tr>", "</a></span><span class='rss:item'>", $data);
  $data = $data . "</span>";

  $match_count = preg_match_all($itemregexp, $data, $items);
  if($match_count > 15) $match_count = 15;

  for ($i=0; $i< $match_count; $i++) {

    if (!eregi("(Leia mais)", $items[1][$i])) {

      $noticia = $items[1][$i];

      $link = substr($noticia, strpos($noticia, "'")+1, strpos($noticia, '>')-10);
      $title = substr($noticia, strpos($noticia, '>')+1, strrpos($noticia, '<')-strpos($noticia, '>')-1);

      $description = substr($noticia, strrpos($noticia, '>')+1);
      if ( strlen($description) < 10 ) $description=$title;

      $xml['item'] .= item_xml($title, $link, $description);

    }

  }

?>
