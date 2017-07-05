<?php
  $xml['title']       = "PC World";
  $xml['link']        = "http://pcworld.terra.com.br/pcw/pcworld.html";
  $xml['description'] = "PC World";
  $xml['publisher']   = "IDGNow";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $data = read_file($xml['link']);
  $data = str_replace("<!--/DUAS MATERIAS--->", "###", $data);
  $data = str_replace("<!---TABELA COLUNISTAS--->", "###", $data);
  list($cabecalho, $data, $rodape) = split("###", $data);
  $itemregexp = "%rss:item *\" *>(.+?)</span>%is";
  $data = str_replace('<a href=http://', '<span class="rss:item"><a href=http://', $data);
  $data = str_replace('</div>', '</span>', $data);
  $match_count = preg_match_all($itemregexp, $data, $items);
  if($match_count > 15) $match_count = 15;
  for ($i=0; $i < $match_count - 1; $i++) {
    $description = $items[1][$i];
    $link = str_replace('<a href=', "", $description);
		$link = ereg_replace(">.*", "", $link);
    list($title, $aux) = split("\n", strip_tags($description));
    $xml['item'] .= item_xml($title, $link, $description);
  }


