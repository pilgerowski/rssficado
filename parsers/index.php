<html>
<head>
<title>Parsers do Projeto RSSficado</title>
</head>
<body>
<h2>Parsers do Projeto RSSficado</h2>
<hr>
<ul>
<?
  $diretorio = `ls *.inc`;
  $arquivos = split("\n", $diretorio);
  asort($arquivos);
  reset($arquivos);
  while(list($i,$k) = each($arquivos)) {
    if(!empty($k)) {
      echo "<li><a href='$k'>$k</a></li>\n";
    }  
  }
?>
</ul>
</body>
</html>