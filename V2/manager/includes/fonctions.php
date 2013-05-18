<?php

// Permet la connexion à une base de données
function connexion($bd_server,$bd_user,$bd_passwd,$bd_base_ceg)
{
	global $connexion;
	$connexion = mysql_connect($bd_server,$bd_user,$bd_passwd);
	mysql_select_db($bd_base_ceg,$connexion);
	
	if (!$connexion)
	{
		echo 'Error: Could not connect to database. Plase try again later.';
		exit;
	}
}
/////////////////////////////////////////////
?>