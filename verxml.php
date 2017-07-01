<?  
require_once("util.inc.php");
$rulename = ereg_replace('/|.xml', '', $_SERVER["QUERY_STRING"]);
$rulename = str_replace('/', '', $rulename);
if($rulename == "") {
  include("./index.htm");
} else {
  $arquivo_regra = './parsers/'.$rulename.'.inc.php';
  include($arquivo_regra);
  $saida = template_xml();
  $saida = str_replace('%%TITLE%%', $xml['title'], $saida);
  $saida = str_replace('%%LINK%%', $xml['link'], $saida);
  $saida = str_replace('%%DESCRIPTION%%', $xml['description'], $saida);
  $saida = str_replace('%%PUBLISHER%%', $xml['publisher'], $saida);
  $saida = str_replace('%%ITEM%%', $xml['item'], $saida);
  $saida = str_replace('<', '&lt;', $saida);
  $saida = str_replace('>', '&gt;', $saida);
  echo "<pre>$saida</pre>";
}
?>
