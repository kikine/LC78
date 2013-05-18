<html>
<head>
	<title>LC78 - Classements</title>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<link rel="stylesheet" type="text/css" href="./style/style.css" media="all" title="Normal" />
	<link rel="stylesheet" type="text/css" href="./style/resultat.css" media="all" title="Normal" />
</head>
<body>
<?php
$mySQLserver = "sql1.lc78-escrime.com";
$mySQLuser = "lc78escrimecom";
$mySQLpassword = "rEx0HoNS";
$mySQLdefaultdb = "lc78escrimecom";

$categorie=$_GET['cat'];
$niveau=$_GET['niv'];

		$connexion = mysql_connect($mySQLserver,$mySQLuser,$mySQLpassword);
		mysql_select_db($mySQLdefaultdb,$connexion);
		
			$req = "SELECT * FROM `classements` WHERE `niveau` LIKE '%$niveau%' AND `categorie` LIKE '$categorie%'";
			//echo "<br />".$req."<br />";
			$requete = mysql_query($req);

				?>
<center>
<font size="+2"><u><b>Classements <?php echo $categorie;?></b></u></font>
	<table id="sample">
		<tr class="prem">
			<td>Catégorie</td>
			<td>Epée Dames</td>
			<td>Epée Hommes</td>
		</tr>
				<?php
				for($n=0; $n<mysql_num_rows($requete); $n++)
				{
					$resultats = mysql_fetch_array($requete);
					$nivo=$resultats['niveau'];
					if ($nivo=="FIE")
					{
						$couleur="#FFCC99";
					}
					if ($nivo=="National")
					{
						$couleur="#99FF33";
					}
					if ($nivo=="Ligue")
					{
						$couleur="#FFFF00";
					}
					echo "\n<tr bgcolor=".$couleur.">\n<td class=\"data\">".$resultats['categorie']." <b>".$resultats['niveau']."</b></td>\n<td class=\"res\">".$resultats['dames']."</td>\n<td class=\"res\">".$resultats['hommes']."</td></tr>";
				}
			
	echo "</table>\n</center>";
	?>

</body>
</html>