<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<link rel="stylesheet" type="text/css" href="./style/style.css" media="all" title="Normal" />
</head>
<body>
<?php

/*
*	Script d'installation de l'application de gestion des comp�titions (inscription)  et r�sultats
*	
*/

//d�claration des variables
$mySQLserver = "sql1.lc78-escrime.com";
$mySQLuser = "lc78escrimecom";
$mySQLpassword = "rEx0HoNS";
$mySQLdefaultdb = "lc78escrimecom";
$mySQLprefix = "compet_";

echo "Cr�ation des tables des r�sultats";
//Cr�ation des tables de r�sultats
$connexion = mysql_connect($mySQLserver,$mySQLuser,$mySQLpassword);
mysql_select_db($mySQLdefaultdb,$connexion);

$req = mysql_query("CREATE TABLE ");

mysql_close($connexion);

echo " : <b>OK</b><br />";

echo "Cr�ation des tables des classements";
//Cr�ation des tables de classements

echo " : <b>OK</b><br />";
?>
</body>
</html>