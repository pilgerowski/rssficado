<?
  $xml['title']       = "Campo Grande News";
  $xml['link']        = "http://www.campograndenews.com/index.htm";
  $xml['description'] = "Campo Grande News";
  $xml['publisher']   = "Campogrande.com";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $itemregexp = "%rss:item *\" *>(.+?)</span>%is";
  $allowable_tags = "<A><B><BR><BLOCKQUOTE><CENTER><DD><DL><DT><HR><I><IMG><LI><OL><P><PRE><U><UL>";
  $data = read_file($xml['link']);
  $data = str_replace('<a href="view.htm?id=', '<span class="rss:item"><a href="http://www.campograndenews.com/view.htm?id=', $data);
  $data = str_replace('</a><br>', '</a></span>', $data);
  $data = str_replace(' class="noticia"', '', $data);

  $match_count = preg_match_all($itemregexp, $data, $items);
  if($match_count > 15) $match_count = 15;

  for ($i=1; $i< $match_count; $i++) {
    $item = $items[1][$i];
    $title = "[cgr] ";
    $title .= strip_tags($item);
    if (stristr($item, "href")) {
    	$linkurl = stristr($item, "href");
      $linkurl = substr($linkurl, strpos($linkurl, "\"")+1);
	    $linkurl = substr($linkurl, 0, strpos($linkurl, "\""));
	    $linkurl = trim($linkurl);
	    $link = $linkurl;
    } else {
	    $link = $xml['link'];
    }

    $description = "<a href='$link'>$item</a>";
    $xml['item'] .= item_xml($title, $link, $description);
  }
?>