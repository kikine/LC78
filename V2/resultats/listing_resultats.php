<?php
        //session_start();

        //if( empty($_SESSION['auth']) || ($_SESSION['auth']!="yes") ) {
        //       header("Location: http://www.lc78-escrime.com/news.php");
	//       exit();
        //}
?>

<html>
<head>
	<title>LC78 - Administration des Résultats</title>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<link rel="stylesheet" type="text/css" href="../style/style.css" media="all" title="Normal" />
</head>
<body>

<?php
	$mySQLserver = "sql1.lc78-escrime.com";
	$mySQLuser = "lc78escrimecom";
	$mySQLpassword = "rEx0HoNS";
	$mySQLdefaultdb = "lc78escrimecom";


	$connexion = mysql_connect($mySQLserver,$mySQLuser,$mySQLpassword);
	mysql_select_db($mySQLdefaultdb,$connexion);
	//requete sur la table moteur
	$requete = mysql_query("SELECT * FROM resultats ORDER BY `id` DESC");
	//Deconnexion
	mysql_close($connexion);


	echo "<table class=\"tableau\">";
	echo "<tr><td>Date</td><td>Epreuve</td><td>Lieu</td><td>Categorie</td><td>Résultats</td></tr>";

	for($n=0; $n<mysql_num_rows($requete); $n++)
	{
		//récup des données ligne par ligne
		$resultats = mysql_fetch_array($requete);
		//Insertion des données dans le code HTML
		echo "<tr><td>".$resultats['date_comp']."</td><td>".$resultats['epreuve']."</td><td>".$resultats['lieu']."</td><td>".$resultats['categorie']."</td><td>".$resultats['resultat_che']."</td><td><form action=\"./modif.php\" method=\"GET\"><input type=\"hidden\" name=\"id\" value=\"".$resultats['id']."\"><div class=\"form-control\"><input type=\"submit\" value=\"Modifier\" class=\"form-submit\" /></div></form></td></tr>";
	}
	echo "</table>";
?>


</body>
</html>
