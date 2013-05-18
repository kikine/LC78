<!-- Page de modification des classements -->

<?php
$mySQLserver = "sql1.lc78-escrime.com";
$mySQLuser = "lc78escrimecom";
$mySQLpassword = "rEx0HoNS";
$mySQLdefaultdb = "lc78escrimecom";

$categorie=$_GET['cat'];
$niveau=$_GET['niv'];

		$connexion = mysql_connect($mySQLserver,$mySQLuser,$mySQLpassword);
		mysql_select_db($mySQLdefaultdb,$connexion);
		
			$req = "SELECT * FROM `classements` WHERE `niveau` LIKE '%$niveau%' AND `categorie` LIKE '$categorie%'";
			//echo "<br />".$req."<br />";
			$requete = mysql_query($req);
			$resultats = mysql_fetch_array($requete);
?>
<html>
<head>
	<title>LC78 - Classements</title>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<link rel="stylesheet" type="text/css" href="./style/style.css" media="all" title="Normal" />
	<link rel="stylesheet" type="text/css" href="./style/resultat.css" media="all" title="Normal" />
</head>
<body>
	<form action="./changer_classement.php" method="GET" name="formulaire">
		<input type="hidden" name="niveau" value="<?php echo $niveau;?>" />
		<input type="hidden" name="categorie" value="<?php echo $categorie;?>" />
		<fieldset>
			<legend>Modification du classement <?php echo $categorie." ".$niveau;?></legend>
			<div>
				<label for="resultat">Classements des Chesnaysiennes<br />
				</label><textarea name="class_dames" cols="35" rows="10">
<?php $dames=str_replace("<br />",chr(13),$resultats['dames']);echo $dames;?>	
</textarea>
			</div>
			<div>
				<label for="resultat">Classements des Chesnaysiens<br />
				</label><textarea name="class_hommes" cols="35" rows="10">
<?php $hommes=str_replace("<br />",chr(13),$resultats['hommes']);echo $hommes;?>			
</textarea>
			</div>
				<br/>
			<div class="form-control">
					<input type="submit" value="Enregistrer" class="form-submit" />
					<input type="reset" value="Effacer" class="form-reset" />
					<a href="help.php"><input type="button" value="Aide" class="form-help" /></a>
			</div>
		</fieldset>
	</form>
</body>
</html>