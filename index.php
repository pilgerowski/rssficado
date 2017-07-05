<?php 

	include_once("./util.inc.php");
	$diretorio = str_replace("/index.php","",$_SERVER['PHP_SELF']);
	if($diretorio == '/') 
		$diretorio = '';
	$local = "http://{$_SERVER["SERVER_NAME"]}{$diretorio}"; 
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="estilo.css">
		<title>Projeto RSSficado</title>
	</head>
	<body bgcolor=White>

		<div id="sideBar">
			<img src="imagens/rssficado_130x45.gif" width=130 height=45><br />
			<br /><br />
			• <a href="#agencias">RSS x agências?</a> • <br />
			• <a href="#canais">Sites RSSficados</a> • <br />
			• <a href="#outros">Outros projetos</a> • <br />
			• <a href="#saladeimprensa">Sala de imprensa</a> • <br />
			• <a href="#detalhes">Detalhes técnicos</a> • <br />
			<br />
			<a href="<?php echo $local;?>/canais.php?pt.rdf">OCS</a><br />
			<br />
			<b>Fontes</b>:<br />
			<a href="https://github.com/pilgerowski/rssficado">Github</a><br />
			<br />
			<a href="<?php echo $local;?>/parsers/index.php">Parsers</a><br />
			<br />
			<a href="<?php echo $local;?>/rssficar.php">RSSficar</a><br />
			Conversor dinâmico de HTML-&gt;RSS<br />
			<br />
			<a href="<?php echo $local;?>/rss2js/">RSS2JS</a><br />
			Conversor dinâmico de RSS-&gt;JavaScript<br />
			<br />
			Projeto RSSficado: <br />
			criado por <a href="http://charles.pilger.com.br">Charles Pilger</a> em 01/02/2002<br />
			<br />
			Apoio cultural de <br />
			<a href="http://www.baggio.com" target="baggio">Baggio Technology</a>.<br />
			<br />
			<a href="http://www.baggio.com" target="Baggio Technology">
				<img src="imagens/baggio.png" border=0 width="150" height="50">
			</a><br />
			<br />
			<a href="mailto:rssficado@pilger.com.br">Contato</a><br />
			<br />
		</div>

		<div id="header">
		  <h1>Projeto RSSficado</h1>
		</div>

		<div id="mainClm">
			<p>
				O <b>RSS (Rich Site Sumary)</b> é um formato de arquivo XML padronizado mundialmente para troca de notícias e usando RSS você pode ler as manchetes de seus sites preferidos sem precisar visitá-los toda hora. A idéia do <b>Projeto RSSficado</b> é permitir que você acesse notícias de diversas fontes (fontes estas que geralmente disponibilizam notícias apenas para acesso via navegador HTML) em um único programa (<i>RSS reader</i>) permitindo que você mantenha-se informado e otimize seu tempo. Geralmente as notícias no formato RSS fornecem um título, resumo da manchete e um link através do qual você pode obter maiores informações, dessa forma você só abre o seu navegador para ler aquilo que realmente te interessa.
			</p>
			<p>
				Há <i>RSS readers</i> em vários sistemas operacionais. Um que recomendamos é o <a href="http://www.feedreader.com/">Feedreader</a>, disponível para usuários do Windows. Outros leitores podem ser encontrados <a href="http://blogspace.com/rss/readers">aqui</a>.
			</p>

			<a name="agencias"></a>
			<hr size=1 noshade>
			<strong>RSS <i>versus</i> agências: roubo de público?</strong>
			<hr size=1 noshade>
			<p>
				Uma pergunta que se pode fazer quando se usa RSS é se isso não está prejudicando a agência de notícia, já que o internauta deixaria de acessar o site da agência. A resposta é simples: não, não está. O RSS não substitui a agência, ela apenas fornece para esta mais um modo do internauta chegar até a notícia, com a vantagem que este não precisa ficar acessando toda a hora para ver se houve alguma atualização (o <i>RSS Reader</i> faz isso por ele). Ganha assim o internauta, pela praticidade e economia de tempo, e a agência, que passa a receber um público mais qualificado realmente interessado no material disponibilizado, fazendo valer assim mais os seus <i>banners</i>.  
			</p>
			<p>
				Na verdade, são <a href="http://blogspace.com/rss/writers">vários sites de notícias</a> (entre elas CNN, Reuters, Salon, ...) que disponibilizam arquivos RSS ou XML para os seus usuários utilizarem. Aqui no Brasil é que a prática não é difundida, e foi em função disso que o projeto foi criado. Tanto é assim que o projeto não tem qualquer fim lucrativo. Na verdade o que procuramos é suprir o que consideramos uma falha por parte das agências, tornando assim a nossa vida mais agradável ;)
			</p> 

			<a name="sites"></a>
			<hr size=1 noshade>
			<strong>Sites "RSSficados"</strong>
			<hr size=1 noshade>
			<p>
			Temos atualmente uma série de sites "rssficados". Para fazer uso deles é só instalar o <a href="http://www.feedreader.com/">Feedreader</a> ou <a href="http://blogspace.com/rss/readers">outro leitor de RSS</a> e copiar para o leitor o endereço apontado pela palavra <b>link</b> (aperte com o botão direito do mouse sobre a palavra e vá em <b>Copiar Atalho</b>), que automaticamente ele começará a fazer a leitura das notícias. Se você tiver um servidor web rodando PHP na sua casa ou empresa você pode muito bem instalar os conversores nele, bastando clicar na palavra <b>fonte</b>. Com conversores locais você economiza assim no uso da sua rede e ainda contribuiu com o projeto, já que temos um limite para tráfego de dados no nosso servidor.  
			</p>

			<p>
				Os sites atualmente "rssficados" podem ser vistos <a href="canais.php">aqui</a>. Uma outra opção é acessar ele no formato <a href="canais.php?pt.rdf">OCS</a>.
			</p>

			<p> 
				Você também pode participar do <b>Projeto RSSficado</b>. Basta enviar sua contribuição para <a href="mailto:charles@pilger.com.br">Charles Pilger</a>. Colaboraram no projeto até o presente momento: 
			</p>
			<ul>
				<li><a href="http://www.mise.com.br/kenji/blog.php">Anderson Kenji Mise</a>
				<li><a href="http://andrefonseca.com">André Fonseca</a>
				<li>Carlos Carbonari
				<li><a href="http://charles.pilger.inf.br">Charles Pilger</a>
				<li><a href="http://www.crisdias.com">Cristiano Dias</a>
				<li><a href="http://www.interney.net">Edney Soares de Souza</a>
				<li><a href="http://www.hipermail.com">Fabio Sampaio</a>
				<li><a href="http://linux.unleashed.com.br/jason/">Marcelo Subtil Marçal</a>
			</ul> 

			<a name="outros"></a>
			<hr size=1 noshade>
			<strong>Outros projetos interessantes: </strong>
			<hr size=1 noshade>
			<ul>
				<li><a href="http://elcio.locaweb.com.br/rss/">RSSficador do Elcio</a>: script em ASP que se utiliza de <A href="http://guia-er.sourceforge.net/guia-er.html">expressões regulares</a> para criar arquivos RSS    
				<li><a href="http://rssregexp.codigolivre.org.br/">RSS RegExp</a>: script em PHP que se utiliza de <A href="http://guia-er.sourceforge.net/guia-er.html">expressões regulares</a> para criar arquivos RSS    
				<li>Para usuários do <b>Blogger</b>: <a href="rssficar.php">Exportando seus posts para RSS</a> </li>
				<li><a href="http://www.feeds.com.br">Feeds.com.br</a> : Lista de sites brasileiros que disponibilizam arquivos RSS</a> </li>
				<li><a href="http://www.milrumos.com.br/logs/rss_br.xml">Arquivo XML para o FeedsReader com sites brasileiros que usam RSS</a> </li>
				<li><a href="<?php echo $local;?>/source.php?b2xml.php">RSS para o b2</a>: permite a geração de RSS para o sistema de gerenciamento de conteúdo <a href="http://cafelog.com/">b2</a><br />
				</li>
			</ul>

			<p>
				E não deixe de participar da lista <a href="http://groups.yahoo.com/group/rssficado/">Projeto RSSficado</a>, onde são trocadas informações técnicas sobre RSS.
			</p>

			<hr size=1 noshade>
			<a name="saladeimprensa"></a>
			<strong>Sala de imprensa: </strong>
			<hr size=1 noshade>
			<ul>
				<li>07/11/2002: <a href="<?php echo $local;?>/imprensa/20021107-dicas-l.htm">News is Free</a> <font size=-3>[ <a href="http://www.dicas-l.unicamp.br/dicas-l/20021107.shtml">Dicas-L</a> ]</font> </li>
				<li>13/05/2002: <a href="<?php echo $local;?>/imprensa/20020513-webinsider.htm">RSS busca conteúdo sem roubar pageviews</a> <font size=-3>[ <a href="http://www.webinsider.com.br/vernoticia.php?id=1269">Webinsider</a> ]</font> </li>
				<li>06/05/2002: <a href="<?php echo $local;?>/imprensa/20020506-gildot.htm">Gildot foi RSSficado e muitos outros sites também!</a> <font size=-3>[ <a href="http://www.gildot.org/article.pl?sid=02/05/06/1827240">Gildot</a> ]</font> </li>
				<li>24/04/2002: <a href="<?php echo $local;?>/imprensa/20020424-comunique-se.htm">RSS e Feedreader: lidando com a overdose de informação</a> <font size=-3>[ <a href="http://www.comunique-se.com.br/NewsClip/JornalismoOnline.asp?op2=2&op3=5&Editoria=135">Comunique-se</a> ]</font> </li>
				<li>22/04/2002: <a href="<?php echo $local;?>/imprensa/20020422-oglobo.htm">Que tal dar um RSS de presente ao seu blog?</a> <font size=-3>[ <a href="http://oglobo.globo.com/suplementos/informaticaetc/18617088.htm">O Globo</a> ]</font> </li>
				<li>15/04/2002: <a href="<?php echo $local;?>/imprensa/20020415-oglobo.htm">Criatividade Máxima</a> <font size=-3>[ <a href="http://oglobo.globo.com/colunas/ultimas.htm">O Globo</a> ]</font> </li>
				<li>11/04/2002: <a href="<?php echo $local;?>/imprensa/20020411-jb.htm">Huuum, RSSificado...</a> <font size=-3>[ <a href="http://jbonline.terra.com.br/jb/papel/colunas/insite/2002/04/11/jorcolins20020411002.html">JB</a> ]</font> </li>
				<li>09/04/2002: <a href="<?php echo $local;?>/imprensa/20020409-hotbits.htm">Projeto RSSficado leva notícias a todos os sites</a> <font size=-3>[ <a href="http://hotbits.hiper.com.br/p1/internet/2002/04/0009">HotBits</a>] </font> </li> 
			</ul>
			<p>
				E não dá para deixar de lado o apoio dado pelo <a href="http://samizdat.manilasites.com/2002/02/22">Guilherme Kujawski</a>, jornalista de tecnologia da revista <a href="http://www.terra.com.br/cartacapital/">Carta Capital</a>, e que foi um dos primeiros a olhar para o nosso trabalho e ver o potencial que há nele... Muito obrigado!  
			</p> 

			<a name="detalhes"></a>
			<hr size=1 noshade>
			<strong>Detalhes técnicos</strong>
			<hr size=1 noshade>

			<p align=justify>
				RSS é um padrão que utiliza a especificação <a href="http://www.w3.org/XML/">XML (eXtended Markup Language)</a> e os links disponibilizados nessa página utilizam um <a href="source.php?xml.php">script padrão</a> (utilizando uma <a href="util.inc">biblioteca de rotinas</a>) que formata as notícias em RSS retiradas dos sites originais através de scripts (<i>parsers</i>) desenvolvidos pelos colaboradores do projeto. Tanto o script padrão quanto os <i>parsers</i> são desenvolvidos em <a href="http://www.php.net">PHP</a>, e a licença de uso que usamos para os códigos aqui disponíveis é o <a href="http://www.gnu.org/copyleft/gpl.html">GPL</a>. 
			</p>
		</div>
	</body>
</html>

