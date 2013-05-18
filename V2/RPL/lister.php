<html>
<head>
	<title>LC78 - Inscription</title>
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

		$connexion = mysql_connect($mySQLserver,$mySQLuser,$mySQLpassword);
		mysql_select_db($mySQLdefaultdb,$connexion);
		
			//$req = "SELECT * FROM `inscription_RPL` ORDER BY 'nom','prenom' DESC";
			$req = "SELECT * FROM `inscription_RPL`";
			//echo "<br />".$req."<br />";
			$requete = mysql_query($req);
			if (mysql_num_rows($requete)== 0)
			{
				echo "<span class=\"centrage\">Pas de résultats avec les paramètres demandés<br /><br /><br /><br />";
			}
			else
			{
				?>
<center>
	<img src="./images/logo_lc78_escrime.gif" alt="logo LC78-escrime" />
	<table id="sample">
		<tr class="prem">
			<td>Nom</td>
			<td>Prénom</td>
			<td>Date de Naissance</td>
			<td>Club</td>
			<td>Numéro de Licence</td>
		</tr>
				<?php
				for($n=0; $n<mysql_num_rows($requete); $n++)
				{
					$resultats = mysql_fetch_array($requete);
					/*$modulo=$resultats['id']%2;
					
					if ($modulo!=0)
					{
						$couleur="#FF9933";
					}
					else
					{
						$couleur="#00CC66";
					}*/
					$couleur="white";
					echo "\n<tr bgcolor=".$couleur.">\n<td class=\"data\">".$resultats['nom']."</td>\n<td class=\"data\">".$resultats['prenom']."</td>\n<td class=\"data\">".$resultats['naissance']."</td>\n<td class=\"data\">".$resultats['club']."</td>\n<td class=\"res\">".$resultats['licence']."</td></tr>";
				}
			
	echo "</table>\n</center>";
	}
	?>

</body>
</html>