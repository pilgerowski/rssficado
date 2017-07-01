<?php

$rss_str = "http://rss.phpnuke.org.br/rss2js/rss2js.php?src=" . urlencode($src) . "&chan=$chan&num=$num&desc=$desc&date=$date";

$html_str = "http://rss.phpnuke.org.br/rss2js/rss2html.php?src=" . urlencode($src) . "&chan=$chan&num=$num&desc=$desc&date=$date";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Cut n' Paste JavaScript RSS Feed</title>
		<link rel="Stylesheet" rev="Alternate" href="rss.css" />
<style>
p, .in { margin: 10px 15%;
	font-family: verdana, arial, sans-serif; 
	font-size: x-small;
	}
.first { margin-top:0;}

h1 { margin: 10px 15% 0;
	font-size: 140%; 
	}
h2 { margin: 10px 15% 0;
	font-size: 110%; 
	}
.spaced {margin: 0 0 8px 40px;}
</style>

</head>
<body>
<?php if ($generate) :?>
<h1>RSS Feeds via JavaScript</h1>
<p class="first">Segue abaixo o código que você precisa copiar&amp;colar para incluir o RSS feed na sua página:</p>

<p>&lt;script language="JavaScript" src="<?php echo htmlentities($rss_str) ?>"&gt;&lt;/script&gt;
</p>

<p>
&lt;noscript&gt;
&lt;a href="<?php echo htmlentities($html_str)?>"&gt;View RSS feed&lt;/a&gt;
&lt;/noscript&gt;
</p>

<?php else:?>
<p class="first">Segue abaixo é uma pré-visualização de como esse feed aparecerá:</p>

<script language="JavaScript" src="<?php echo $rss_str?>"></script>
<noscript>
<a href="<?php echo $html_str?>">Ver RSS feed</a>
</noscript>
<?php endif?>

<div align="center"><form><input type="button" value="Fechar janela" onclick="self.close()"></form></div>

</body>
</html>
