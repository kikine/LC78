<?php
	include("../includes/config.php");
	include("../includes/fonctions.php");
	include("../includes/header.inc");
	?>
	<div id="content">
		<?php

		$nom_compet = $_GET['nom_compet'];
		$date = $_GET['date'];
		$destinataire = $_GET['destinataire'];
		$categorie = $_GET['categorie'];

		$headers = "MIME-Version: 1.0\r\n";
			
		$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
		$headers .= "From: \"cercle-escrime-gradigna@wanadoo.fr\"\n";

		$objet = "inscription ".$nom_compet." du ". $date ;

		$message = "Bonjour, \n \n Veuillez trouver ci-joint les engagements du club du Chesnay pour le ".$nom_compet."\n\nBonne réception\nSportivement\n\nLC78-Escrime";
		
		$nom = $_GET['nom'] ;
		$prenom = $_GET['prenom'] ;
		$numlic = $_GET['lic'] ;
		$a = count($numlic);
		for($n=0;$n < $a; $n++){
		$message.= $nom[$n]." ".$prenom[$n]." \t04033041".$numlic[$n]."\n";
		}
		$message.="\n \n Cordialement,\n \n \t Le Cercle d'Escrime de Gradignan";

		if ( mail($destinataire,$objet,$message,$headers) ) 
		{
			echo "<div id=\"return\">Inscription effectuée</div>";
		}
		else 
		{
			echo "<div id=\"return\">Gros bug !! ça veut pas marcher</div>";
		}

	include("../includes/footer.inc"); ?>
