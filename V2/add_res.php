<?php
	//r�cup des donn�es envoy�es par le formulaire
	$date = $_GET['date'];
	$epreuve = $_GET['epreuve'];
	$lieu = $_GET['lieu'];
	$categorie = $_GET['categorie'];
	$sexe=$_GET['sexe'];
	$categorie.= " ".$sexe;
	$resultat = $_GET['resultat'];
	$resultat=str_replace(chr(13),"<br />",$resultat);
	//Pram�tres de connexion � la BDD
	$mySQLserver = "sql1.lc78-escrime.com";
	$mySQLuser = "lc78escrimecom";
	$mySQLpassword = "rEx0HoNS";
	$mySQLdefaultdb = "lc78escrimecom";
	//connexion � la BD
	$connexion = mysql_connect($mySQLserver,$mySQLuser,$mySQLpassword);
	//Selection de la base
	mysql_select_db($mySQLdefaultdb,$connexion);
		$requete="INSERT into `resultats`(date_comp,epreuve,lieu,categorie,resultat_che) values ('".$date."','".$epreuve."','".$lieu."','".$categorie."','".$resultat."')";
		echo $requete."<br />";
		//La mise � jour renvoi TRUE en cas de succ�s et FALSE en cas d'erreur
		$reqIns = mysql_query($requete);
		
		if(!$reqIns)
		{
			echo "<b>Probl�me de mise � jour... R�essayez plus tard.</b><br />";
			echo "Contacter <a href=\"mailto:thomasraso@free.fr?subject=pb LC78 ajout resultats\">Thomas Raso</a>";
		}
		else
		{
			echo "Insertion <b>OK</b><br />";
			echo "<a href=\"./ajout_res.php\">Ajouter de nouveaux r�sultats</a>";
		}
	//fermeture de connexion � la BD
	mysql_close($connexion);
	
?>
