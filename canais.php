<?php
// ** Inicio da rotina principal

  require_once("util.inc.php");

  $diretorio = preg_replace("/canais.*/","",$_SERVER["PHP_SELF"]);
  $diretorio = preg_replace("/\/$/", '', $diretorio);

  if($diretorio == '/') $diretorio = '';

  $itemTime = date("Y-m-d").'T00:00';

  $url = 'http://'.$_SERVER["SERVER_NAME"].$diretorio.'/'; 

  $thisScript = "$url/index.php";
  $xmlScript  = "$url/xml.php?";
  $xmlScript  = str_replace('//xml.php?', '/xml.php?', $xmlScript);
  list($language, $mode) = explode('.', $_SERVER['QUERY_STRING']);
  switch($mode) {
    case 'rdf' : $format = rdf();
                 $accent = 0;
                 break;
    default    : $mode = 'html';
                 $format = html();
                 $accent = 1;
  }
  $file['title']   = 'Projeto RSSficado - Lista de Canais';
  $file['creator'] = 'Charles Pilger (mailto:charles@pilger.inf.br)';
  $file['description'] = 'Lista de canais coletada pelo Projeto RSSficado';
  
  $output = $format['header'];
  $output = str_replace('%%THISSCRIPT%%',      $thisScript,          $output);
  $output = str_replace('%%FILETITLE%%',       $file['title'],       $output);
  $output = str_replace('%%FILECREATOR%%',     $file['creator'],     $output);
  $output = str_replace('%%FILEDESCRIPTION%%', $file['description'], $output);

  $data = file2array("./canais.txt");
  while(list($keyitem, $aux) = each($data)){
var_dump($keyitem, $aux); die();
    $item['title'] = $keyitem;
    while(list($keyvalue,$value) = each($aux)) {
      if($accent) $value = noaccent($value);
      $item[$keyvalue] = noaccent($value);
    }
//    if(!ereg('http:', $item['linkxml'])) { 
//      $item['linkxml'] = $xmlScript.$item['linkxml'];
//    }
    if($mode == 'html') {
      $item['title'] = str_replace('//', '',    $item['title']);
      $item['title'] = str_replace('/',  ' » ', $item['title']);
    } else {  
      $item['linkxml'] = str_replace('&', '&amp;', $item['linkxml']);
    }   
    $itemx = $format['item'];
    $itemx = str_replace('%%ITEMTITLE%%',      $item['title'],           $itemx);
    $itemx = str_replace('%%ITEMLINKXML%%',    $item['linkxml'],         $itemx);
    $itemx = str_replace('%%ITEMLINKPAGE%%',   $item['linkpage'],        $itemx);
    $itemx = str_replace('%%ITEMDESCRIPTION%%',$item['linkdescription'], $itemx);
    $itemx = str_replace('%%ITEMLANGUAGE%%',   $item['linklanguage'],    $itemx);
    $itemx = str_replace('%%ITEMCREATOR%%',    $item['linkcreator'],     $itemx);
    $itemx = str_replace('%%ITEMDATE%%',       $item['linkdate'],        $itemx);
    $itemx = str_replace('%%ITEMSUBJECT%%',    $item['linksubject'],     $itemx);
    $itemx = str_replace('%%ITEMTIME%%',       $itemTime,                $itemx);
    $output .= $itemx;   
  }

  $output .= $format['footer'];
  $content = 'Content-Type: '.$format['content'];
  header ($content);
  echo $output;

// ** Final da rotina principal
    
    
function rdf() {
  $output['content'] = 'text/xml';
  $output['header']  = '<'.'?xml version="1.0" encoding="ISO-8859-1"?'.'>'.'
    <rdf:RDF
       xmlns:rdf = "http://www.w3.org/1999/02/22-rdf-syntax-ns#"
       xmlns:ocs = "http://InternetAlchemy.org/ocs/directory#"
       xmlns:dc  = "http://purl.org/metadata/dublin_core#">

       <rdf:description about="%%THISSCRIPT%%">        
          <dc:title>%%FILETITLE%%</dc:title>
          <dc:creator>%%FILECREATOR%%</dc:creator>
          <dc:description>%%FILEDESCRIPTION%%</dc:description>
  ';
  $output['item'] = '
          <rdf:description about="%%ITEMLINKPAGE%%">        
            <dc:title>%%ITEMTITLE%%</dc:title>
            <dc:creator>%%ITEMCREATOR%%</dc:creator>
            <dc:description>%%ITEMDESCRIPTION%%</dc:description>
            <dc:subject>%%ITEMSUBJECT%%</dc:subject>
    
            <rdf:description about="%%ITEMLINKXML%%">
               <dc:language>en</dc:language>
               <ocs:format>http://my.netscape.com/rdf/simple/0.9/</ocs:format>
               <ocs:updatePeriod>hourly</ocs:updatePeriod>
               <ocs:updateFrequency>2</ocs:updateFrequency>
               <ocs:updateBase>%%ITEMTIME%%</ocs:updateBase>
            </rdf:description>
        
          </rdf:description>                 
  ';
  $output['footer'] = '
       </rdf:description>        
    </rdf:RDF>
  ';
  return $output;
}

function html() {
  $output['content'] = 'text/html';
  $output['header']  = "<ul>\n";
  $output['item']    = "<li><a href='%%ITEMLINKXML%%'>%%ITEMTITLE%%</a></li>\n";
  $output['footer']  = "</ul>\n";
  return $output;
}    

function file2array($file) {
  $source = read_file($file);
  $items = explode("%", $source);
  $numitems = count($items) - 1;
  $keys = explode("#", array_shift($items));
  $numvalues = count($keys) - 1;
  for($i = 0; $i <= $numvalues; $i++) {
    $keys[$i] = trim($keys[$i]);
    // echo '['.$i.']['.$keys[$i]."]<br>\n";
  }
  sort($items);
  reset($items);
  for($i = 0; $i <= $numitems; $i++) {
    $line = trim($items[$i]);
    if($line != "") {
      $values = explode("#", $items[$i]);
      for($j = 1; $j <= $numvalues; $j++) {
        $key = trim($values[0]);
        $output[$key][$keys[$j]] = trim($values[$j]);
        // echo '['.$key.']['.$keys[$j].']['.$output[$key][$keys[$j]]."]<br>\n";
      }
    }        
  }

  return $output;
}
?>
