<html>
<head>
	<title>LC78 - Inscription</title>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<link rel="stylesheet" type="text/css" href="./style/style.css" media="all" title="Normal" />
</head>
<body>
<center><img src="./images/logo_lc78_escrime.gif" alt="logo LC78-escrime" /></center>

	<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="GET" name="formulaire">
		<fieldset>
			<legend>Inscription</legend>
			<div>
				<label for="nom">NOM</label><input type="text" id ="nom" name="nom"/>
			</div>
			<div>
				<label for="prenom">Prénom</label><input type="text" id ="prenom" name="prenom"/>
			</div>
			<div>
				<label for="date">Date de naissance(JJ-MM-AAAA)</label><input type="text" id ="date" name="date"/>
			</div>
			<div>
				<label for="club">Club</label><input type="text" id ="club" name="club"/>
			</div>
			<div>
				<label for="licence">N° de licence</label><input type="text" id ="licence" name="licence"/>
			</div>
			<br/>
			<input type="hidden" id ="licence" name="valeur" value="1"/>
		<div class="form-control">
				<input type="submit" value="S'inscrire !" class="form-submit" />
				<input type="reset" value="Effacer" class="form-reset" />
		</div>
		</fieldset>
	</form>
	<?php
		$valeur=@$_GET['valeur'];
		$nom=$_GET['nom'];
		$prenom=$_GET['prenom'];
		$naissance=$_GET['date'];
		$club=$_GET['club'];
		$licence=$_GET['licence'];
		if($valeur!="")
		{
			$mySQLserver = "sql1.lc78-escrime.com";
			$mySQLuser = "lc78escrimecom";
			$mySQLpassword = "rEx0HoNS";
			$mySQLdefaultdb = "lc78escrimecom";
			$connexion = mysql_connect($mySQLserver,$mySQLuser,$mySQLpassword);
			//Selection de la base
			mysql_select_db($mySQLdefaultdb,$connexion);
			
		$requete="INSERT into `inscription_RPL`(nom,prenom,naissance,club,licence) values ('".$nom."','".$prenom."','".$naissance."','".$club."','".$licence."')";
		//echo $requete."<br />";
		//La mise à jour renvoi TRUE en cas de succès et FALSE en cas d'erreur
		$reqIns = mysql_query($requete);
		
		if(!$reqIns)
		{
			echo "<b>Problème de mise à jour... Réessayez plus tard.</b><br />";
			echo "Contacter <a href=\"mailto:thomasraso@free.fr?subject=pb LC78 inscription RPL\">Thomas Raso</a>";
		}
		else
		{
			echo "Vous êtes inscrit !<br />";
		}
		}
	?>
</body>
</html>