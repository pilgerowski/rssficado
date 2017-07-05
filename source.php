<?php
$arquivo = preg_replace('/|.php/', '', $_SERVER["QUERY_STRING"]);
$arquivo_nome = './'.$arquivo.'.php';
echo $arquivo_nome;
$conteudo = htmlspecialchars(read_file($arquivo_nome));
echo "<pre>$conteudo</pre>";  

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
