<?php
	include("./includes/config.php");
	include("./includes/fonctions.php");
	session_start();
	
	$login=$_GET['login'];
	$mdp=$_GET['mdp'];
	connexion($bd_server,$bd_user,$bd_passwd,$bd_base_ceg);
	$res = mysql_query('SELECT * FROM `users` WHERE `login`="'.$login.'" AND `password`="'.$mdp.'"');
	$rows = mysql_num_rows($res);
	$resultats= mysql_fetch_array($res);
	if($rows == 1) {
		$_SESSION['login'] = $login;
		header("Location: ./home.php");
		exit();
		}
	else {
		header("Location: ./index.php");
		exit();
	}
?>
