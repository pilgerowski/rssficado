<?php include("../util.inc.php"); ?>
<html>
<head>
<title>Parsers do Projeto RSSficado</title>
</head>
<body>
<h2>Parsers do Projeto RSSficado</h2>
<hr>
<ul>
<?php
	$diretorio = './';
	$arquivos = array_diff(scandir($diretorio), array('..', '.'));
	asort($arquivos);
	reset($arquivos);
	while(list($i,$k) = each($arquivos)) {
		if(!empty($k)) {
			if(contem($k, ".inc"))
				echo "<li><a href='$k'>$k</a></li>\n";
		}  
  	}
?>
</ul>
</body>
</html>
