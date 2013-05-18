<?php
	//récup des données envoyées par le formulaire
	$date = $_GET['date'];
	$epreuve = $_GET['epreuve'];
	$lieu = $_GET['lieu'];
	$categorie = $_GET['categorie'];
	$sexe=$_GET['sexe'];
	$categorie.= " ".$sexe;
	$resultat = $_GET['resultat'];
	$resultat=str_replace(chr(13),"<br />",$resultat);
	//Pramètres de connexion à la BDD
	$mySQLserver = "sql1.lc78-escrime.com";
	$mySQLuser = "lc78escrimecom";
	$mySQLpassword = "rEx0HoNS";
	$mySQLdefaultdb = "lc78escrimecom";
	//connexion à la BD
	$connexion = mysql_connect($mySQLserver,$mySQLuser,$mySQLpassword);
	//Selection de la base
	mysql_select_db($mySQLdefaultdb,$connexion);
		$requete="INSERT into `resultats`(date_comp,epreuve,lieu,categorie,resultat_che) values ('".$date."','".$epreuve."','".$lieu."','".$categorie."','".$resultat."')";
		echo $requete."<br />";
		//La mise à jour renvoi TRUE en cas de succès et FALSE en cas d'erreur
		$reqIns = mysql_query($requete);
		
		if(!$reqIns)
		{
			echo "<b>Problème de mise à jour... Réessayez plus tard.</b><br />";
			echo "Contacter <a href=\"mailto:thomasraso@free.fr?subject=pb LC78 ajout resultats\">Thomas Raso</a>";
		}
		else
		{
			echo "Insertion <b>OK</b><br />";
			echo "<a href=\"./ajout_res.php\">Ajouter de nouveaux résultats</a>";
		}
	//fermeture de connexion à la BD
	mysql_close($connexion);
	
?>
