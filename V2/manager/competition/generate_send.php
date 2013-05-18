<?php
//génération, stockage et envoi du PDF
session_start() ;
		$message = $_POST['message'];
		$manuel = $_POST['manuel'];
		$arbitre = $_POST['arbitre'];

		$nom_compet = $_POST['nom_compet'];
		$date = $_POST['date'];
		$destinataire = $_POST['destinataire'];
		$categorie = $_POST['categorie'];
		$sexe = $_POST['sexe'];

echo "message => ".$message."<br />";
echo "manuel => ".$manuel."<br />";
echo "arbitre => ".$arbitre."<br />";
echo "nom_compet => ".$_SESSION['nom_compet']."<br />";
echo "date => ".$_SESSION['date']."<br />";
echo "destinataire => ".$_SESSION['destinataire']."<br />";
echo "categorie => ".$_SESSION['categorie']."<br />";
echo "sexe => ".$_SESSION['sexe']."<br />";


?>
