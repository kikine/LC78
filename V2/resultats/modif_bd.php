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

	$date = $_GET['date'];
	$epreuve = $_GET['epreuve'];
	$lieu = $_GET['lieu'];
	$categorie = $_GET['categorie'];
	$res = $_GET['resultats'];
	$res=str_replace(chr(9),"<br />",$res);
	$res=str_replace(chr(13),"<br />",$res);
	$id=$_GET['id'];
	
	$connexion = mysql_connect($mySQLserver,$mySQLuser,$mySQLpassword);
	mysql_select_db($mySQLdefaultdb,$connexion);
		
			
	//renvoi 1 si la référence existe sinon 0
	$req = mysql_query("UPDATE resultats SET date_comp='$date', epreuve='$epreuve', lieu='$lieu', categorie='$categorie', resultat_che='$res' WHERE id='$id'");
	if($req)
	{
		echo "Modification effectuée<br />";
		echo "<a href=\"./listing_resultats.php\">Retour</a>";
	}
	else
	{
		echo "La modification n'a pas pu avoir lieu";
	}
	//fermeture de connexion à la BD
	mysql_close($connexion);
	
?>
		
</body>
</html>
