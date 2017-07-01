<?
  $xml['title']       = "Gildot";
  $xml['link']        = "http://gildot.org/";
  $xml['description'] = "O Gildot � uma iniciativa do Grupo de Investiga��o de Linux da Universidade do Minho. O seu objectivo principal � constituir um ponto de encontro onde a comunidade Linux possa trocar ideias e opini�es, para al�m de ficar a par das �ltimas novidades relacionadas com este Sistema Operativo.";
  $xml['publisher']   = "Grupo de Investiga��o de Linux da Universidade do Minho";
  $xml['item']        = ""; // Esta variavel ser� preenchida durante o parsing da p�gina

  $itemregexp = "%rss:item *\" *>(.+?)</span>%is";
  $allowable_tags = "<A><B><BR><BLOCKQUOTE><CENTER><DD><DL><DT><HR><LI><OL><P><PRE><U><UL>";
  $html = read_file($xml['link']);
  $html = str_replace('<!--', "\n<!--", $html);
  $html = str_replace('<!-- begin title bar block -->', '<span class="rss:item">', $html);
  $html = str_replace('<!-- end story_trailer block -->', '</span>', $html);
  $match_count = preg_match_all($itemregexp, $html, $items);
  if($match_count > 15) $match_count = 15;
  for ($i=0; $i< $match_count; $i++) {
    $description = $item = clearspaces(strip_tags($items[1][$i], $allowable_tags));
    list($title) = split("\n", $item);
    $item = str_replace('http://www.gildot.org/', '%%', $item);
    $item = str_replace('><B>Desenvolvimento', '%%><B>Desenvolvimento', $item);
    list($aux1, $aux2, $link) = split('%%', $item);
    $link = $xml['link'].$link;
    $xml['item'] .= item_xml(strip_tags($title), $link, $description); 
  }
?>
