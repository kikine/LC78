<html>
<head>
	<title>LC78 - Résultats</title>
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
//echo "=>".$categorie."<=";
//echo "<br />=>".$niveau."<=";
		$connexion = mysql_connect($mySQLserver,$mySQLuser,$mySQLpassword);
		mysql_select_db($mySQLdefaultdb,$connexion);
		
			$req = "SELECT * FROM `resultats` WHERE `epreuve` LIKE '%$niveau%' AND `categorie` LIKE '$categorie%' ORDER BY 'id' DESC";
			//echo "<br />".$req."<br />";
			$requete = mysql_query($req);
			if (mysql_num_rows($requete)== 0)
			{
				echo "<span class=\"centrage\">Pas de résultats avec les paramètres demandés<br /><br /><br /><br />";
				echo "<a href=\"./choix_resultats.php\"><img src=\"./images/icon-back-link.gif\" />Retour au choix des résultats</a></span>";
			}
			else
			{
				?>
<center>
	<table id="sample">
		<tr class="prem">
			<td>Date</td>
			<td>Epreuve</td>
			<td>Lieu</td>
			<td>Catégorie</td>
			<td>Résultats des Chesnaysiens</td>
		</tr>
				<?php
				for($n=0; $n<mysql_num_rows($requete); $n++)
				{
					$resultats = mysql_fetch_array($requete);
					$modulo=$n%2;
					
					if ($modulo!=0)
					{
						$couleur="#FF9933";
					}
					else
					{
						$couleur="#00CC66";
					}
					echo "\n<tr bgcolor=".$couleur.">\n<td class=\"data\">".$resultats['date_comp']."</td>\n<td class=\"data\">".$resultats['epreuve']."</td>\n<td class=\"data\">".$resultats['lieu']."</td>\n<td class=\"data\">".$resultats['categorie']."</td>\n<td class=\"res\">".$resultats['resultat_che']."</td></tr>";
				}
			
	echo "</table>\n</center>";
	}
	?>

</body>
</html>