<?php
	//r�cup des donn�es envoy�es par le formulaire
	$homme=$_GET['class_hommes'];
	$dame=$_GET['class_dames'];
	$niveau=$_GET['niveau'];
	$categorie=$_GET['categorie'];
	
	$homme=str_replace(chr(9),"<br />",$homme);
	$homme=str_replace(chr(13),"<br />",$homme);
	$dame=str_replace(chr(9),"<br />",$dame);
	$dame=str_replace(chr(13),"<br />",$dame);
	
	//Pram�tres de connexion � la BDD
	$mySQLserver = "sql1.lc78-escrime.com";
	$mySQLuser = "lc78escrimecom";
	$mySQLpassword = "rEx0HoNS";
	$mySQLdefaultdb = "lc78escrimecom";
	//connexion � la BD
	$connexion = mysql_connect($mySQLserver,$mySQLuser,$mySQLpassword);
	//Selection de la base
	mysql_select_db($mySQLdefaultdb,$connexion);
		$requete="update `classements` set hommes='".$homme."',dames='".$dame."' where niveau='".$niveau."' and categorie='".$categorie."'";
		
		//$requete="INSERT into `resultats`(date_comp,epreuve,lieu,categorie,resultat_che) values ('".$date."','".$epreuve."','".$lieu."','".$categorie."','".$resultat."')";
		echo $requete."<br />";
		//La mise � jour renvoi TRUE en cas de succ�s et FALSE en cas d'erreur
		$reqIns = mysql_query($requete);
		
		if(!$reqIns)
		{
			$headers = "MIME-Version: 1.0\r\n";
			//////ici on d�termine le mail en format text
			$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
			$headers .= "From: classements@lc78-escrime.com\n";
			// On initialise les variables
			$destinataire = "thomasraso@free.fr";
			$objet = "LC78 >> [ECHEC] Mise � jour des classements" ;
			$message = $requete." \n";
			mail($destinataire,$objet,$message,$headers);
			echo "<html><head>	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=ISO-8859-1\" /></head><body>";
			echo "<b>Probl�me de mise � jour... R�essayez plus tard.</b><br />";
			echo "Contacter <a href=\"mailto:thomasraso@free.fr?subject=pb LC78 modif classement\">Thomas Raso</a>";
			echo "</body></html>";
		}
		else
		{
			/////voici la version Mine
			$headers = "MIME-Version: 1.0\r\n";
			//////ici on d�termine le mail en format text
			$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
			$headers .= "From: resultats@lc78-escrime.com\n";

			// On initialise les variables
			$destinataire = "thomas.raso@lc78-escrime.com";
			$objet = "LC78 >> [SUCCES] Mise � jour des classements" ;
			$message = "Les r�sultats des comp�titions on �t� mis � jour...   ".$requete." \n";;
			mail($destinataire,$objet,$message,$headers);
			echo "<html><head>	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=ISO-8859-1\" /></head><body>";
			echo "Modification du classement $niveau $categorie <b>OK</b><br />";
			echo "<a href=\"./modif.php\">Modifier d'autres classements</a>";
			echo "</body></html>";
		}
	//fermeture de connexion � la BD
	mysql_close($connexion);
	
?>
