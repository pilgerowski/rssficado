<?php
{
  header ("Content-Type: text/xml");  
  include ("blog.header.php"); 

  $xml['title']       = "Nome do blog";
  $xml['link']        = "Endereço do blog";
  $xml['description'] = "Descrição do Blog";
  $xml['publisher']   = "Nome do dono do blog";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  $counter = 0;
  while($counter <= 10 && $row = mysql_fetch_object($result)) { 
    start_b2();
    $title = $postdata["Title"];	
    $link  = $xml['link']."/b2.php?p=$id";
    $description = $postdata["Content"];
    $xml['item'] .= item_xml($title, $link, $description);
    $counter++;
  }
  $saida = template_xml();
  $saida = str_replace('%%TITLE%%', $xml['title'], $saida);
  $saida = str_replace('%%LINK%%', $xml['link'], $saida);
  $saida = str_replace('%%DESCRIPTION%%', $xml['description'], $saida);
  $saida = str_replace('%%PUBLISHER%%', $xml['publisher'], $saida);
  $saida = str_replace('%%ITEM%%', $xml['item'], $saida);
  header ("Content-Type: text/xml");
  echo $saida;
}

function read_file($filename) {
  $f = fopen("$filename", "r");
  if(!$f) {
    echo "Erro ao abrir o arquivo $filename";
    exit;
  }
  while(!feof($f)) {
    $s .= fgets($f, 256);
  }
  fclose($f);
  return $s;
}

function template_xml() {
  $template = '<'.'?xml version="1.0" encoding="ISO-8859-1"?'.'>'.'

<!DOCTYPE rss PUBLIC "-//Projeto RSSficado//DTD RSS 0.91//EN" "http://rssficado.pilger.inf.br/rss-0.91.dtd">

<rss version="0.91">
<channel>
   <title>%%TITLE%%</title>
   <link>%%LINK%%</link>
   <description>%%DESCRIPTION%%</description>
   <publisher>%%PUBLISHER%%</publisher>
   <language>pt-br</language>

%%ITEM%% 
   
</channel>
</rss>
';
  return $template;   
}

function item_xml($title, $link, $description) {
  $allowable_tags = "<A><B><BR><BLOCKQUOTE><CENTER><DD><DL><DT><HR><I><IMG><LI><OL><P><PRE><U><UL>";
  $title = htmlspecialchars($title);  
  $link = htmlspecialchars($link);  
  $description = htmlspecialchars(strip_tags($description, $allowable_tags));
  $item = '
    <item>
      <title>%%TITLE%%</title>
      <link>%%LINK%%</link>
      <description>
%%DESCRIPTION%%
      </description>
    </item>
  ';
  $item = str_replace('%%TITLE%%', $title, $item);
  $item = str_replace('%%LINK%%', $link, $item);
  $item = str_replace('%%DESCRIPTION%%', $description, $item);
  return $item; 
}

