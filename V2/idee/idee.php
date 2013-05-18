<html>
<head>
	<title>LC78 - Idées</title>
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
		
			$req = "SELECT * FROM `idee`ORDER BY 'id_idee'";
			//echo "<br />".$req."<br />";
			$requete = mysql_query($req);
				?>
<center><img src="./images/logo_lc78_escrime.gif" alt="logo LC78-escrime" />

	<table id="sample">
		<tr class="prem">
			<td>id_idee</td>
			<td>nom</td>
			<td>prénom</td>
			<td>sujet</td>
			<td>proposition</td>
		</tr>
				<?php
				for($n=0; $n<mysql_num_rows($requete); $n++)
				{
					$resultats = mysql_fetch_array($requete);
					$modulo=$resultats['id']%2;
					
					if ($modulo!=0)
					{
						$couleur="#FF9933";
					}
					else
					{
						$couleur="#00CC66";
					}
					echo "\n<tr bgcolor=".$couleur.">\n<td class=\"data\">".$resultats['id_idee']."</td>\n<td class=\"data\">".$resultats['nom']."</td>\n<td class=\"data\">".$resultats['prenom']."</td>\n<td class=\"data\">".$resultats['sujet']."</td>\n<td class=\"data\">".$resultats['proposition']."</td></tr>";
				}
			
	echo "</table>\n</center>";
	?>

</body>
</html>