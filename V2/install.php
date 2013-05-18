<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<link rel="stylesheet" type="text/css" href="./style/style.css" media="all" title="Normal" />
</head>
<body>
<?php

/*
*	Script d'installation de l'application de gestion des compétitions (inscription)  et résultats
*	
*/

//déclaration des variables
$mySQLserver = "sql1.lc78-escrime.com";
$mySQLuser = "lc78escrimecom";
$mySQLpassword = "rEx0HoNS";
$mySQLdefaultdb = "lc78escrimecom";
$mySQLprefix = "compet_";

echo "Création des tables des résultats";
//Création des tables de résultats
$connexion = mysql_connect($mySQLserver,$mySQLuser,$mySQLpassword);
mysql_select_db($mySQLdefaultdb,$connexion);

$req = mysql_query("CREATE TABLE ");

mysql_close($connexion);

echo " : <b>OK</b><br />";

echo "Création des tables des classements";
//Création des tables de classements

echo " : <b>OK</b><br />";
?>
</body>
</html>