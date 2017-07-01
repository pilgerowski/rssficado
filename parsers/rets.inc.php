<?
  $xml['title']       = "Rets";
  $xml['link']        = 'http://tamarindo.rits.org.br/notitia/servlet/newstorm.notitia.apresentacao.ServletDeSecao?codigoDaSecao=1';
  $xml['description'] = "Rets - Revista do Terceiro Setor";
  $xml['publisher']   = "RITS";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $data = read_file($xml['link']);
  $data = str_replace('<font size="-1" face="verdana" color="teal">', '<inicio>', $data);   
  $data = str_replace('<BR CLEAR=ALL>', '<fim>', $data);   
  
  $itemregexp = "%<inicio>(.+?)<fim>%is";

  $allowable_tags = "<A><B><BR><BLOCKQUOTE><CENTER><DD><DL><DT><HR><I><IMG><LI><OL><P><PRE><U><UL>";
              
  $match_count = preg_match_all($itemregexp, $data, $items);
  if($match_count > 15) $match_count = 15;

  for ($i=0; $i < $match_count; $i++) {
    $item = strip_tags($items[1][$i], $allowable_tags);
    $item = ereg_replace("\<img src=.* align=\"left\"\>", "", $item);
    $item = singleline(str_replace('--->', '', $item));
    $item = str_replace('href="', 'href="http://tamarindo.rits.org.br/notitia/servlet/', $item);
    list($title, $aux) = split("<br>", $item);
    $link = ereg_replace("\" class=.*$", '', str_replace('<a href="', '', $item));
    $description = $item; 
    $xml['item'] .= item_xml($title, $link, $description);
  }
?>