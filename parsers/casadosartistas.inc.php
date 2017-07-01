<?
$xml['link']        = "http://casa.uol.com.br/noticias";
$xml['title']       = " UOL - Casa dos Artistas ";
$xml['description'] = "http://casa.uol.com.br/noticias";
$xml['publisher']   = " UOL ";
$xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

$itemregexp = "%rss:item *\" *>(.+?)</span>%is";
$allowable_tags = "<A><B><BR><BLOCKQUOTE><CENTER><DD><DL><DT><HR><I><IMG><LI><OL><P><PRE><U><UL>";

$data = read_file($xml['link']);

$data = str_replace("<font face=verdana size=2><b><i>", "#####", $data);
$data = str_replace("<font face=verdana size=2><b><i>", "#####", $data);
list($cabecalho, $data, $rodape) = split("#####", $data);
$data = substr($data, 10);

$data = str_replace("<font face=verdana size=1><b>", "<span class=\"rss:item\">", $data);
$data = str_replace("</font></a><br>", "</a></span>", $data);
$data = str_replace("</b></font> -", "", $data);
$data = str_replace("<font face=verdana size=2 color=black>", "", $data);
$data = str_replace("<!-- [dia] -->", "", $data);
	
$match_count = preg_match_all($itemregexp, $data, $items);
if($match_count > 15) $match_count = 15;

for ($i=0; $i< $match_count; $i++) {
	$desc = $items[1][$i];
	$title = strip_tags($desc);
  $aux = split('>', $desc);
  list($aux, $link, $aux2) = split('=', $aux[0]);
  $title = singleline($title);
	$description = singleline(ereg_replace("[0-2][0-9]h[0-9][0-9]", '', $desc));
	$xml['item'] .= item_xml($title, $link, $description);
}

?>