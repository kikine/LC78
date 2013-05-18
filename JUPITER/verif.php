<?php
	include("./includes/config.php");
	include("./includes/fonctions.php");
	session_start();
	
	$login=$_POST['login'];
	$mdp=$_POST['mdp'];
	
	check_var('verif.php','login',$login);
	check_var('verif.php','mdp',$mdp);
	//echo "variables non dangeureuses<br /><br /><br />";
	
	$valid_login = ereg("^(.+)\.(.+)$", strtolower($login));
	$quedeschiffres = ereg("^[0-9]*$", $mdp) ;
	
	if (($valid_login) && ($quedeschiffres))
	{
	
		//récupération du prénom et du nom
		$dec=explode(".", $login);
		$prenom = $dec[0];
		$nom = $dec[1];
		
		connexion($bd_server,$bd_user,$bd_passwd,$bd_base_ceg);
		$res = mysql_query('SELECT * FROM '.$prefix_table.'XXXXXXXXX` WHERE `prenom`="'.$prenom.'" AND `nom`="'.$nom.'" AND `password`="'.$mdp.'"');
		$rows = mysql_num_rows($res);
		$resultats= mysql_fetch_array($res);
		if($rows == 1) {
			$_SESSION['login'] = $login;
			header("Location: ./home.php");
		}
		else {
			header("Location: ./index.php");
		}
	}
	else
	{
		echo "Echec de l'authentification";
	}
	
?>
