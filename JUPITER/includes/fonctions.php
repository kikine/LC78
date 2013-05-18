<?php

// Permet la connexion à une base de données
function connexion($bd_server,$bd_user,$bd_passwd,$bd_base_ceg)
{
	global $connexion;
	$connexion = mysql_connect($bd_server,$bd_user,$bd_passwd);
	mysql_select_db($bd_base_ceg,$connexion);
	
	if (!$connexion)
	{
		echo 'L\'accès à la base de données est momentanément indisponible.<br /> Veuillez nous excuser pour la gêne occasionnée.';
		exit;
	}
}
/////////////////////////////////////////////

// Fonction permettant de checker le contenu d'une variable issue d'une formulaire et de la rejeter en cas de tentative de XSS

function check_var($script,$var,$valeur)
{
	/* SQL */
	$interdit[] = 'DELETE';
	$interdit[] = 'DO';
	$interdit[] = 'HANDLER';
	$interdit[] = 'INSERT';
	$interdit[] = 'LOAD DATA INFILE';
	$interdit[] = 'REPLACE';
	$interdit[] = 'SELECT';
	$interdit[] = 'TRUNCATE';
	$interdit[] = 'UPDATE';
	$interdit[] = 'DATABASE';
	$interdit[] = 'ALTER';
	$interdit[] = 'CREATE';
	$interdit[] = 'INDEX';
	$interdit[] = 'TABLE';
	$interdit[] = 'DROP';
	$interdit[] = 'RENAME';
	$interdit[] = 'DESCRIBE';
	$interdit[] = 'EXPLAIN';
	$interdit[] = 'HELP';
	$interdit[] = 'USE';
	$interdit[] = 'SET';
	$interdit[] = 'SHOW';
	$interdit[] = '%';
	$interdit[] = ' ';
	/* SCRIPTS */
	$interdit[] = 'script';
	$interdit[] = 'window';
	$interdit[] = 'document';
	/* DIVERs */
	$interdit[] = "1";
	
	$taille = sizeof($interdit);
	for ($i = 0; $i < $taille; $i++) {
		if (strtolower($valeur) == strtolower($interdit[$i]))
		{
			header("Location: http://".$_SERVER['SERVER_NAME']."/JUPITER/admin/signal/hack.php?script=$script&var=$var&valeur=$valeur");
		}
	}
}
/////////////////////////////////////////////
?>