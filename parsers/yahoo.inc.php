<?
$baseurl = "http://br.news.yahoo.com/";
$counter = 0;

  if (!$url) {

    $init         = "/18/ajb.html";
    $end = array ('<table bgcolor=669933 border=0 width=100% cellspacing=0 cellpadding=1><tr><td>');
    $op = "Homepage";
    $patharray = array ("/");

  }else{

    $init = "Fotos</a>";

    switch ($url) {
      case 'capa': 
        $op = "Primeira Página";
        $end = array ('Galeria de fotos', 'Meu Yahoo!</b>', 'Meu Yahoo!</b>');
        $patharray = array ("35/","18/panorama.html","18/ajb.html");
        switch ($ag) {
         case 'rt':
          unset($patharray);
          $patharray = array ("35/");
          break;
         case 'pb':
          unset($patharray);
          $patharray = array ("18/panorama.html");
          unset($end);
          $end = array ('Meu Yahoo!</b>');
          break;
         case 'jb':
          unset($patharray);
          $patharray = array ("18/ajb.html");
          unset($end);
          $end = array ('Meu Yahoo!</b>');
          break;
         }
        break;
      case 'mundo':
        $op = "Mundo";
        $end = array ('Galeria de fotos', '<DIV ALIGN="right">');
        $patharray = array ("36/","19/");
        switch ($ag) {
         case 'rt':
          unset($patharray);
          unset($end);
          $patharray = array ("36/");
          $end = array ('Galeria de fotos');
          break;
         case 'jb':
          unset($patharray);
          unset($end);
          $patharray = array ("19/");
          $end = array ('<DIV ALIGN="right">');
          break;
         } 
        break;
      case 'eco':
        $op = "Economia";
        $end = array ('Galeria de fotos', 'Meu Yahoo!</b>', 'Meu Yahoo!</b>');
        $patharray = array ("42/","20/panorama.html","20/ajb.html");
        switch ($ag) {
         case 'rt':
          unset($patharray);
          unset($end);
          $end = array ('Galeria de fotos');
          $patharray = array ("42/");
          break;
         case 'pb':
          unset($patharray);
          unset($end);
          $end = array ('Meu Yahoo!</b>');
          $patharray = array ("20/panorama.html");
          break;
         case 'jb':
          unset($patharray);
          unset($end);
          $end = array ('Meu Yahoo!</b>');
          $patharray = array ("20/ajb.html");
          break;
         } 
        break;
      case 'pol':
        $init = "<br><hr size=1 noshade></td>";
        $op = "Politica";
        $end = array ('Copyright © 2002 Yahoo!', '<b>Meu Yahoo!</b>', '<b>Meu Yahoo!</b>');
        $patharray = array ("21/","21/panorama.html","21/ajb.html");
        switch ($ag) {
         case 'rt':
          unset($patharray);
          unset($end);
          $end = array ('Copyright © 2002 Yahoo!');
          $patharray = array ("21/");
          break;
         case 'pb':
          unset($patharray);
          unset($end);
          $end = array ('<b>Meu Yahoo!</b>');
          $patharray = array ("21/panorama.html");
          break;
         case 'jb':
          unset($patharray);
          unset($end);
          $end = array ('<b>Meu Yahoo!</b>');
          $patharray = array ("21/ajb.html");
          break;
         } 
        break;
      case 'tec':
        $init = "<br><hr size=1 noshade></td>";
        $op = "Tecnologia";
        $end = array ('<DIV ALIGN="right">', '<b>Meu Yahoo!</b>', '<b>Meu Yahoo!</b>');
        $patharray = array ("38/","16/magnet.html","16/pcmaster.html");
        switch ($ag) {
         case 'rt':
          unset($patharray);
          unset($end);
          $end = array ('<DIV ALIGN="right">');
          $patharray = array ("38/");
          break;
         case 'mg':
          unset($patharray);
          unset($end);
          $end = array ('<b>Meu Yahoo!</b>');
          $patharray = array ("16/magnet.html");
          break;
         case 'pc':
          unset($patharray);
          unset($end);
          $end = array ('<b>Meu Yahoo!</b>');
          $patharray = array ("16/pcmaster.html");
          break;
         }
        break;
      case 'esp':
        $init = '<br><hr size=1 noshade></td>';
        $op = "Esportes";
        $end = array ('<DIV ALIGN="right">', '<DIV ALIGN="right">');
        $patharray = array ("39/","22/ajb.html");
        switch ($ag) {
         case 'rt':
          unset($patharray);
          unset($end);
          $end = array ('<DIV ALIGN="right">');
          $patharray = array ("39/");
          break;
         case 'jb':
          unset($patharray);
          unset($end);
          $end = array ('<DIV ALIGN="right">');
          $patharray = array ("22/ajb.html");
          break;
         }
        break;
      case 'entret':
        $init = '<br><hr size=1 noshade></td>';
        $op = "Entretenimento";
        $end = array ('<DIV ALIGN="right">', '<DIV ALIGN="right">', '<DIV ALIGN="right">', '<DIV ALIGN="right">', '<DIV ALIGN="right">');
        $patharray = array ("40/","17/ajb.html","17/brpress.html", "17/rockwave.html","17/panorama.html");
        switch ($ag) {
         case 'rt':
          unset($patharray);
          unset($end);
          $end = array ('<DIV ALIGN="right">');
          $patharray = array ("40/");
          break;
         case 'jb':
          unset($patharray);
          unset($end);
          $end = array ('<DIV ALIGN="right">');
          $patharray = array ("17/ajb.html");
          break;
         case 'br':
          unset($patharray);
          unset($end);
          $end = array ('<DIV ALIGN="right">');
          $patharray = array ("17/brpress.html");
          break;
         case 'rw':
          unset($patharray);
          unset($end);
          $end = array ('<DIV ALIGN="right">');
          $patharray = array ("17/rockwave.html");
          break;
         case 'pb':
          unset($patharray);
          unset($end);
          $end = array ('<DIV ALIGN="right">');
          $patharray = array ("17/panorama.html");
          break;
         }
        break;
      case 'saude':
        $op = "Saude";
        $patharray = array ("41/");
        $end = array ('<DIV ALIGN="right">');
        break;
      default:  
        $path = "";
        $op = "Homepage";
    }

  }
  $xml['title']       = "Y! Brasil : ".$op;
  $xml['description'] = "Yahoo! Brasil - Notícias";
  $xml['publisher']   = "Yahoo!";
  $xml['item']        = ""; // Esta variavel será preenchida durante o parsing da página

  foreach ($patharray as $path) {
    if (!$ag) $xml['link'] = $baseurl . $patharray[0];
    else 
         $xml['link'] = $baseurl . $path;

    $file = $baseurl . $path;
    $html = read_file($file);
    $html = str_replace($init, "##########", $html);

    $j=key($patharray);
    $html = str_replace($end[$j], "##########", $html);
    next($patharray);
    
    list($header, $source, $footer) = split("##########", $html);
 

// Limpando a Homepage (argh!)
    if ($op = "Homepage") {
      $source = strip_tags($source, '<A>');
      $source = str_replace('Reuters</a>','###',$source);
      $source = str_replace('Agência JB</a>','###',$source);
      $source = str_replace('Rockwave</a>','###',$source);
      $source = str_replace('Brasil</a>','###',$source);
      $source = str_replace('Fotos</a>','###',$source);
      $source = str_replace('PC Master</a>','###',$source);
      $source = str_replace('Magnet</a>','###',$source);
      $source = str_replace('Rockwave</a>','###',$source);
      $source = str_replace('BR Press</a>','###',$source);
      $source = str_replace('Todos</a>','###',$source);
      $source = str_replace('&nbsp;','  ',$source);
      $source = str_replace('<a href','<A HREF',$source);

      $strarray = explode('<A HREF=',$source);

    }
    else {

      $source = strip_tags($source, '<a>');
      $strarray = explode('<a href=',$source);

    }

    foreach ($strarray as $stritem) {
      if(ereg('</a>', $stritem)) {
        $pos = strpos($stritem, ">");
        $link = substr($stritem, 1, $pos-1);
        if (strpos($link,"/") == 0) $link = substr($link,1);
        $link = str_replace ( '"', '', $link);
        list($link, $trash) = split(' ', $baseurl . $link);

        list($title,$trash) = split("\n",
           strip_tags(substr($stritem,$pos+1,strpos($stritem,"</a>"))));
        if (ereg('-',$stritem)) $description =
          substr($stritem,strpos($stritem,"-")+1);
        else $description = $title;
        if (strlen($description < 10)) $description = $title;
        if($counter < 10) {
          $xml['item'] .= item_xml($title, $link, "$description");
          $counter++;
        }  
        unset ($description);
      }
    }
  }

?>
