<?php
  $xml['link']        = "http://www.valoreconomico.com.br/valornoticias/";
  $xml['title']       = "Valor Notícias";
  $xml['description'] = "Valor Notícias";
  $xml['publisher']   = "Valor Econômico";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $itemregexp = "%rss:item *\" *>(.+?)</span>%is";
  $allowable_tags = "<A><B><BR><BLOCKQUOTE><CENTER><DD><DL><DT><HR><I><IMG><LI><OL><P><PRE><U><UL>";

  $data = read_file($xml['link']);

  $data = str_replace("<BODY ", "###", $data);
  $data = str_replace("</BODY>", "###", $data);
  list($cabecalho, $data, $rodape) = split("###", $data);

  $data = str_replace("<p class='hora'>",'<span class="rss:item">', $data);
  $data = str_replace("<a href='detalhesdanoticia", "<a href='http://www.valoreconomico.com.br/valornoticias/detalhesdanoticia", $data);
  $data = str_replace("<a href='valornoticia", "<a href='http://www.valoreconomico.com.br/valornoticias/valornoticia", $data);
  $data = str_replace("<span class='titulo'>", "", $data);
  $data = str_replace(" target='' class='titulo'", "", $data);
  $data = str_replace("href='", 'href="', $data);
  $data = str_replace("'>", '">', $data);

  $match_count = preg_match_all($itemregexp, $data, $items);
  if($match_count > 15) $match_count = 15;
  
  for ($i=0; $i< $match_count; $i++) {

    $desc = $items[1][$i];
    $title = strip_tags($desc);
    if (stristr($desc, "href")) {
      $linkurl = stristr($desc, "href");
      $linkurl = substr($linkurl, strpos($linkurl, "\"")+1);
      $linkurl = substr($linkurl, 0, strpos($linkurl, "\""));
      $linkurl = trim($linkurl);
      $item_url = $linkurl;
    } else {
      $item_url = $xml['link'];
    }
    $xml['item'] .= item_xml($title,$item_url,$desc);
  }


