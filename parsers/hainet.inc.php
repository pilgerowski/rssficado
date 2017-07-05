<?php
if (!$url) 
{
	$url='jpop';
	$xml['link']      = "http://www.hainet.com.br/".$url."/listar.php";
}
else
{
	$xml['link']      = "http://www.hainet.com.br/".$url."/listar.php";
}

$xml['title']       = "Hai-Net- ".$url;
$xml['description'] = "http://www.hainet.com.br - ".$url;
$xml['publisher']   = "Hai-Net http://www.hainet.com.br";
$xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

$itemregexp = "%rss:item *\" *>(.+?)</span>%is";
$allowable_tags = "<A><B><BR><BLOCKQUOTE><CENTER><DD><DL><DT><HR><I><IMG><LI><OL><P><PRE><U><UL>";

$data = read_file($xml['link']);
$data = str_replace("<a href=\"ver.php?id=", "<span class=\"rss:item\"><a href=\"http://www.hainet.com.br/$url/ver.php?id=", $data);
$data = str_replace("&nbsp;<b class=\"f1\">", " - ", $data);
$data = str_replace("<span class=\"f1\">", "", $data);
$data = str_replace(" class=\"f1\"", "", $data);
$data = str_replace("</a><br>", "</a></span>", $data);
$data = str_replace("</b>", "", $data);
	
$match_count = preg_match_all($itemregexp, $data, $items);
if($match_count > 15) $match_count = 15;

for ($i=0; $i< $match_count; $i++)
{

	$desc = $items[1][$i];
	$title = strip_tags($desc);
	if (stristr($desc, "href")) 
	{
		$linkurl = stristr($desc, "href");
		$linkurl = substr($linkurl, strpos($linkurl, "\"")+1);
		$linkurl = substr($linkurl, 0, strpos($linkurl, "\""));
		$linkurl = trim($linkurl);
		$item_url = $linkurl;
	} 
	else 
	{
		$item_url = $xml['link'];
	}
	$xml['item'] .= item_xml($title, $item_url,$desc);
}


