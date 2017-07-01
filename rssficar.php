<?
if ($url) {
  parse_html($url);
} else {
  show_form();
}

function show_form() {
  global $SERVER_NAME, $REQUEST_URI;
?>
<html>
<head>
<title>RSSficar</title>
<style type="text/css" media="screen">
@import url( /rssficar.css );
</style>
</head>
</body>
   <center><B>RSSficar</B></center>
   <p>
   Este form captura sua p�gina web e a converte em RSS 2.00 . Isto � particularmente �til para usu�rios do Blogger. Para utiliz�-lo siga os seguintes passos:
   </p>
   <ol>
     <li> 
       Coloque &lt;span class="rss:item"> ... &lt;/span> em cada item da sua p�gina.<br />No Blogger voc� pode fazer isso mudando o seu template, trocando o <br />
       <b>&lt;$BlogItemBody$></b> <br />
       por <br />
       <b>&lt;span class="rss:item">&lt;$BlogItemBody$>&lt;/span></b><br />
       e publique algo para recriar a p�gina com o novo template.
    </li>   
    <li>Feito isso coloque a URL de sua p�gina no formul�rio abaixo</li>
    <li>Verifique se o que voc� obteve se assemelha a RSS</li>
    <li>Agora voc� pode fazer um link para este arquivo assim: <br />
      <b>"http://rss.phpnuke.org.br/rssificar.php?url=url_da_sua_pagina"</b>
    </li>
    <li>Voc� pode utilizar a seguinte imagem:
      <img src="/imagens/xml.gif" alt="This gif is freely copyable. Just right click, save"><br />
    </li>  
  </ol>
  <form action="rssficar.php">
     URL de sua p�gina: <input type="text" name="url" size=50> <br /> 
     Inclua um "/" final ou nome de arquivo
     <input type="submit" value="Criar RSS">
   </form><br />
   <b>Uso</b>: http://rss.phpnuke.org.br/rssificar.php?url=url_da_sua_pagina
   <p><b>Notas:</b>
   <ul>
     <li>O item text � colocado no elemento&nbsp;description</li>
     <li>Os primeiros 40 caracteres do item s�o colocados no elemento title</li>
     <li>O primeiro link na descri��o � colocado no link elemento. Se n�o h� nenhum link a URL da p�gina � utilizada</li>      
     <li>Todas tags exceto &lt;A> &lt;B> &lt;BR> &lt;BLOCKQUOTE> &lt;CENTER> &lt;DD> &lt;DL> &lt;DT> &lt;HR> &lt;I> &lt;IMG> &lt;LI> &lt;OL> &lt;P> &lt;PRE> &lt;U> &lt;UL> s�o retiradas do elemento description.</li>
     <li>Um m�ximo de 25 items s�o inclu�dos no RSS </li>
     <li>Se voc� quiser saber mais sobre RSS d� uma olhada no <a href="/">Projeto RSSficado</A></li>
     <li>Se voc� quer rodar uma c�pia deste em seu pr�prio servidor o c�digo-fonte est� <a href="/source.php/rssficar.php">aqui</a></li>
     <li>O c�digo aqui utilizado foi adaptado a partir do c�digo originalmente criado para o <a href="http://www.voidstar.com/rssify.php">RSSify at VoidStar.com</a></li>
   </ul>
</body>
</html>   
<?  
}

function parse_html($url){
  // C�digo criado por goran_johansson at yahoo dot com
  // Fonte: http://www.php.net/manual/en/function.utf8-decode.php 
  $itemregexp = "%rss:item *\" *>(.+?)</span>%is";
  $allowable_tags = "<A><B><BR><BLOCKQUOTE><CENTER><DD><DL><DT><HR><I><IMG><LI><OL><P><PRE><U><UL>";

  $urlparts = parse_url($url);
  if ($urlparts[path] == "") $url .= "/";

  if ($fp = @fopen($url, "r")) {
    while (!feof($fp)) {
      $data .= fgets($fp, 128);
    }
    fclose($fp);
  }
  
  $data =  smart_utf8_decode($data);

  eregi("<title>(.*)</title>", $data, $title);
  $channel_title = $title[1];

  $match_count = preg_match_all($itemregexp, $data, $items);
  $match_count = ($match_count > 25) ? 25 : $match_count;
  
  header("Content-Type: text/xml");

  $output .= "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>\n";
  $output .= "<?xml-stylesheet type=\"text/css\" href=\"rssficar.css\" ?>";
  $output .= "<!DOCTYPE rss [<!ENTITY % HTMLlat1 PUBLIC \"-//W3C//ENTITIES Latin 1 for XHTML//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml-lat1.ent\">\n";
  $output .= "%HTMLlat1;]>\n";
  $output .= "<rss version=\"2.0\" 
    xmlns:dc=\"http://purl.org/dc/elements/1.1/\"
    xmlns:sy=\"http://purl.org/rss/1.0/modules/syndication/\"
    xmlns:admin=\"http://webns.net/mvcb/\"
    xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\"
    xmlns:content=\"http://purl.org/rss/1.0/modules/content/\">
  ";  
  $output .= "  <channel>\n";
  $output .= "    <title>". htmlentities(strip_tags($channel_title)) ."</title>\n";
  $output .= "    <link>". htmlentities($url) ."</link>\n";
  $output .= "    <description>". htmlentities($url) ." via Projeto RSSficado</description>\n";
  $output .= "    <dc:language>pt</dc:language>\n";
  $output .= "    \n";

  for ($i=0; $i< $match_count; $i++) {

    $desc = $items[1][$i];
    $title = substr(trim(strip_tags($desc)),0,50) . " ...";
    $item_url = get_link($desc, $url);
    $link = htmlentities($item_url);
    $desc = str_replace('&', '&amp;', trim(htmlentities(strip_tags($desc))));

    $output .= "  <item rdf:about=\"".$link."\">\n";
    $output .= "    <title>". htmlentities($title) ."</title>\n";
    $output .= "    <link>".$link."</link>\n";
    $output .= "    <description>". $desc ."</description>\n";
    $output .= "  </item>\n";
  }

  $output .= "  </channel>\n";
  $output .= "</rss>\n";

  print $output;
}

function get_link($desc, $url) {
  if (stristr($desc, "href")) {
    $linkurl = stristr($desc, "href");
    $linkurl = substr($linkurl, strpos($linkurl, "\"")+1);
    $linkurl = substr($linkurl, 0, strpos($linkurl, "\""));
    $linkurl = trim($linkurl);
    return $linkurl;
  } else {
    return $url;
  }
}

function smart_utf8_decode($in_str){
  // Replace ? with a unique string
  $new_str = str_replace("?", "q0u0e0s0t0i0o0n", $in_str);
  // Try the utf8_decode
  $new_str=utf8_decode($in_str);
  // if it contains ? marks
  if (strpos($new_str,"?")>0) {
    // Something went wrong, set new_str to the original string.
    $new_str=$in_str;
  }else{
    // If not then all is well, put the ?-marks back where is belongs
    $new_str = str_replace("q0u0e0s0t0i0o0n", "?", $new_str);
  }
  return $new_str;
}

?>

