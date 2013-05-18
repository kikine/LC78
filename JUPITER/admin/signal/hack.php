<?php

	/////voici la version Mine
	$headers = "MIME-Version: 1.0\r\n";
	
	//////ici on détermine le mail en format text
	$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
	$headers .= "From: thomas.raso@lc78-escrime.com\n";

	// On initialise les variables
	$destinataire = "thomas.raso@lc78-escrime.com";
	$objet = "LC78 - Tentative de hack" ;
	$message = "SCRIPT : ".$_GET['script']."\n";
	$message = "VARIABLE : ".$_GET['var']."\n";
	$message = "VALEUR : ".$_GET['valeur']."\n";
	// On envoi l’email
    mail($destinataire,$objet,$message,$headers);
	//on redirige vers le site
	header("Location: http://www.lc78-escrime.com/index.php");
?>
