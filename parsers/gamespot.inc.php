<?
  $xml['title']       = "Gamespot PC News";
  $xml['link']        = "http://gamespot.com/gamespot/filters/news/0,10849,6011011,00.html";
  $xml['description'] = "Gamespot PC News";
  $xml['publisher']   = "Gamespot";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $itemregexp = "%rss:item *\" *>(.+?)</span>%is";

  $data = read_file($xml['link']);
  $data = str_replace("<!--*******AUTOMATED STORIES******-->", "###", $data);
  $data = str_replace("<!---***** END NEWS HOTLIST *****--->", "###", $data);
  list($cabecalho, $data, $rodape) = split("###", $data);
                
  $data = str_replace("<br clear=all><SPAN CLASS=spacer2>&nbsp;</SPAN><br><img src=/gamespot/shared3/dot_grey.gif width=100% height=1 vspace=5 border=0 alt=''><br>", '<span class="rss:item">', $data);
  $data = str_replace('</nobr></span>', '</nobr></span></span>', $data);

  $match_count = preg_match_all($itemregexp, $data, $items);
  if($match_count > 15) $match_count = 15;
  
  for ($i=0; $i< $match_count; $i++) {

    $desc = $items[1][$i];
	eregi("class=gsheader>(.*)</a><br>", $desc, $temptitle);
    $title = $temptitle[1];
	
	// eregi("<span class=gstext14>(.*)</span>", $desc, $tempbody);
    // $body = trim($tempbody[1]);
	
    if (stristr($desc, "href")) {
      $linkurl = stristr($desc, "href");
      $linkurl = substr($linkurl, strpos($linkurl, "=")+1);
      $linkurl = substr($linkurl, 0, strpos($linkurl, " class="));
      $linkurl = trim($linkurl);
      $item_url = "http://gamespot.com$linkurl";
    } else {
      $item_url = $xml['link'];
    }
    $xml['item'] .= item_xml($title, $item_url, $desc);
  }

?> 