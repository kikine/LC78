<html>
<head>
	<title>LC78 - Donner son avis</title>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<link rel="stylesheet" type="text/css" href="./style/style.css" media="all" title="Normal" />
</head>
<body>
<center><img src="./images/logo_lc78_escrime.gif" alt="logo LC78-escrime" /></center>

	<!--formulaire de saisie des résultats-->
	<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST" name="formulaire">
			<fieldset>
				<legend>Donnez nous vos idées...</legend>
				<div>
						<label for="nom">Nom</label><input type="text" id ="nom" name="nom" />
				</div>
				<div>
						<label for="prenom">Prénom</label><input type="text" id ="prenom" name="prenom" />
				</div>
				<div>
						<label for="sujet">Sujet</label><input type="text" id ="sujet" name="sujet" size="30"/>
				</div>
				<div><textarea name="proposition" cols="74" rows="20"></textarea>
				<input type="hidden" name="go" value="1"/>
				</div>
			<div class="form-control">
					<input type="submit" value="Envoyer !" class="form-submit" />
					<input type="reset" value="Effacer" class="form-reset" />
			</div>
			</fieldset>
	</form>
	<?php
		$go=@$_POST['go'];
		if($go!="")
		{
			$proposition = $_POST['proposition'];
			$nom = $_POST['nom'];
			$prenom = $_POST['prenom'];
			$sujet = $_POST['sujet'];
			//Pramètres de connexion à la BDD
			$mySQLserver = "sql1.lc78-escrime.com";
			$mySQLuser = "lc78escrimecom";
			$mySQLpassword = "rEx0HoNS";
			$mySQLdefaultdb = "lc78escrimecom";
			//connexion à la BD
			$connexion = mysql_connect($mySQLserver,$mySQLuser,$mySQLpassword);
			//Selection de la base
			mysql_select_db($mySQLdefaultdb,$connexion);
			$requete="INSERT into `idee`(id_idee,nom,prenom,sujet,proposition) values ('','".$nom."','".$prenom."','".$sujet."','".$proposition."')";
			//echo $requete."<br />";
			//La mise à jour renvoi TRUE en cas de succès et FALSE en cas d'erreur
			$reqIns = mysql_query($requete);
			
			if(!$reqIns)
			{
				echo "<b>Réessayez plus tard.</b><br />";
				echo "Contacter <a href=\"mailto:thomasraso@free.fr?subject=pb LC78 ajout idee\">Thomas Raso</a>";
			}
			else
			{
				echo "<br /><center><b>Votre proposition a été enregistrée</b></center>";
			}
			//fermeture de connexion à la BD
			mysql_close($connexion);
			
			//ENVOI PAR MAIL
						/////voici la version Mine
			$headers = "MIME-Version: 1.0\r\n";
			
			//////ici on détermine le mail en format text
			$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
			$headers .= "From: boiteidee@lc78-escrime.com\n";

			// On initialise les variables
			$destinataire = "thomas.raso@lc78-escrime.com";
			$objet = "LC78 >> Boite a idee" ;
			$message = "NOM => ".$nom."<br />\n"."PRENOM => ".$prenom."<br />\n"."SUJET => ".$sujet."<br />\n"."PROSPOSITION => ".$proposition;
			// On envoi l’email
			mail($destinataire,$objet,$message,$headers);	
		}
	?>
	</body>
</html>