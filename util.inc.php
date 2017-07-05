<?php
function clearspaces($string) {
	$string = str_replace("\r", "\n", $string);
	$string = str_replace("\t", " ", $string);
	$lines = split("\n", $string);
	$total = count($lines);
	$output = "";
	for($i = 0; $i <= $total; $i++) {
		$line = trim($lines[$i]);
		$test = "[$line]";
		if($test != '[]') { $output .= "$line\n"; }
	}
	return $output;
}

function singleline($string) {
	$string = str_replace("\r", "\n", $string);
	$string = str_replace("\t", " ", $string);
	$lines = split("\n", $string);
	$total = count($lines);
	$output = "";
	for($i = 0; $i <= $total; $i++) {
		$line = trim($lines[$i]);
		$test = "[$line]";
		if($test != '[]') { $output .= "$line "; }
	}
	return $output;
}

function valid_file($filename) {
	$timenow = time(); $time = 0;
	if(file_exists($filename)) {
		$time = filemtime($filename);  
	}
	$count = $timenow - $time;
	return ($count <= 1800); // se o arquivo foi criado a menos de 30 minutos retorna verdadeiro   
}

function GetFile($dominio,$url,$cookie) {
	$fp = fsockopen ($dominio, 80, $errno, $errstr, 30);
	$ret="";
	if (!$fp) {
		echo "$errstr ($errno)<br>\n";
	} else {
		fputs ($fp, "GET $url HTTP/1.0\r\n");
		fputs ($fp, "Cookie: $cookie\r\n\r\n");    
		while (!feof($fp)) {
			$ret.= fgets ($fp,128);
		}
		fclose ($fp);
	}   
	return $ret;
}

function GetPage($page) {
	$fp = fsockopen ($page, 80);
	$ret="";
	if($fp) {
		fputs ($fp, "GET $url HTTP/1.0\r\n");
		while (!feof($fp)) {
			$ret.= fgets ($fp,128);
		}
		fclose ($fp);
	}   
	return $ret;
}

function read_file($filename) {
	$f = fopen($filename, "r");
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

function write_file($filename, $contents) {
	$f = fopen("$filename", "w");
	if(!$f) {
		echo "Erro ao abrir o arquivo $filename";
		exit;
	} else {
		fputs($f, $contents);
		fclose($f);
	}  
	return $s;
}

function template_xml() {
	$template = '<'.'?xml version="1.0" encoding="ISO-8859-1"?'.'>';
	$template.= '<!DOCTYPE rss PUBLIC "-//Netscape Communications//DTD RSS 0.91//EN" "http://my.netscape.com/publish/formats/rss-0.91.dtd">

	<rss version="0.91">
		<channel>
			<title>%%TITLE%%</title>
			<link>%%LINK%%</link>
			<description>%%DESCRIPTION%%</description>
			<publisher>%%PUBLISHER%%</publisher>
			<language>pt</language>

			%%ITEM%% 

		</channel>
	</rss>
	';
	return $template;   
}

function item_xml($title, $link, $description) {
	$tags = "<A><B><I><BR><BLOCKQUOTE><CENTER><DD><DL><DT><HR><IMG><P><PRE><U><UL><LI><OL><STRONG>";
	$title = str_replace('&quot;', '"', $title);
	$title = htmlspecialchars(noaccent($title));  
	$link = htmlspecialchars($link);  
	$description = htmlspecialchars(strip_tags($description, $tags));

	$item = '
			<item>
				<title>%%TITLE%%</title>
				<link>%%LINK%%</link>
				<description>
					%%DESCRIPTION%%
				</description>
			</item>

	';
	$item = str_replace('%%TITLE%%', trim($title), $item);
	$item = str_replace('%%LINK%%', trim($link), $item);
	$item = str_replace('%%DESCRIPTION%%', $description, $item);
	return $item; 
}

function noaccent($string) {
	if(strlen($string) > 0) {
		$string = html_entity_decode($string);
		$string = strtr($string, "·‡„‚ÈÍÌÛÙı˙¸Á", "aaaaeeiooouuc");
		$string = strtr($string, "¡¿√¬… Õ”‘’⁄‹«", "AAAAEEIOOOUUC");
	}
	return $string;
}

function contem($mystring, $findme) {
	// codigo copiado de http://br.php.net/manual/en/function.strpos.php
	$pos = strpos($mystring, $findme);

	// Note our use of ===.  Simply == would not work as expected
	// because the position of 'a' was the 0th (first) character.
	if ($pos === false) {
		$contem = false;
	} else {
		$contem = true;
	}
	return $contem;
}

