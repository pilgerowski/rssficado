<?
  $xml['title']       = "ClicNoticias SC";
  $xml['link']        = "http://www.clicrbs.com.br/clicnoticias"; 
  $xml['description'] = "ClicNoticias - Santa Catarina";
  $xml['publisher']   = "RBS";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $itemregexp = "% face='Verdana' class='title'>(.+?)</a>%is";
  $allowable_tags = "<A><B><BR><BLOCKQUOTE><CENTER><DD><DL><DT><HR><I><LI><OL><P><PRE><U><UL>";
  $html = GetFile("www.clicrbs.com.br","http://www.clicrbs.com.br/clicnoticias/jsp/default.jsp?template=14.dwt&source=DYNAMIC,oracle.br.dataservers.BreakingNewsDataServer,selectBreakingNews&order=datepublished&newsID=DYNAMIC,oracle.br.dataservers.BreakingNewsDataServer,selectBreakingNews","clicRBS.prefs=local=Florianopolis(18),uf=SC(2),usuario=;ESTADO=SC");

  $html = str_replace('"', "'", $html);
  $html = str_replace(" - </font><b><font color='#6C7C47' size='1'>", "#", $html);
  $html = str_replace("</font></b><br><font size='2' color='#000000' face='Verdana' class='title'><a href='javascript:doSubmit('','", "#", $html);
  $html = str_replace("','", '#', $html);
  $html = str_replace("')'>", '#', $html);
  $match_count = preg_match_all($itemregexp, $html, $items);
  if($match_count > 15) $match_count = 15;
  for ($i=0; $i< $match_count; $i++) {
    $item = strip_tags($items[1][$i], $allowable_tags);
    list($horario, $chapeu, $newsID, $subTab, $title) = split('#', $item);
    $link = "http://www.clicrbs.com.br/clicnoticias/jsp/default.jsp?tab=00002&newsID=$newsID&subTab=$subTab&uf=1&local=1&l=&template=";
    $description = "<b>$chapeu</b>:<br><a href='$link'>$title</a>";
    $title = "$chapeu: $title";
    $xml['item'] .= item_xml($title, $link, $description); 
  }

?>
