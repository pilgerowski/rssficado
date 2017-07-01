<?php
/**
 * Parser para o Plantão Info do site da Revista InfoExame
 *
 * Desenvolvido por Marcelo Subtil Marçal <jason@conectiva.com.br>
 *
 */

$xml['title']       = "Info Exame - Plantão Info";
$xml['link']        = "http://www2.uol.com.br/info/aberto/infonews/index.shl";
$xml['description'] = "Plantão Info";
$xml['publisher']   = "Info Exame";
$xml['item']        = "";

$html = read_file($xml['link']);
$html = str_replace('<!---News Start[1]#NUMBER#4#--->', '##', $html);
$html = str_replace('<!---News End[1]--->', '##', $html);
$contents = split('##', $html);

for ($i = 1; $i < (count($contents) - 1); $i++) {
	$contents[$i] = trim(strip_tags($contents[$i], '<a>'));
	$contents[$i] = ereg_replace("\n+", "", $contents[$i]);
	$contents[$i] = ereg_replace("\n", "", $contents[$i]);
	$contents[$i] = ereg_replace(".#--->", "", $contents[$i]);
	$contents[$i] = eregi_replace('Leia outras notícias de.*$', '', $contents[$i]);

	if ( !empty($contents[$i]) ) {
		list($head, $description) = split('</a>', $contents[$i]);

		if ( !empty($description) ) {
			list($link, $title) = split('">', $head);
			$link = str_replace('<a href="', '', $link);
			$link = "http://www.uol.com.br" . $link;
			$xml['item'] .= item_xml($title, $link, $description); 
		}
	}
}
?>