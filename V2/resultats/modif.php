<?php
        //session_start();

        //if( empty($_SESSION['auth']) || ($_SESSION['auth']!="yes") ) {
        //       header("Location: http://www.lc78-escrime.com/news.php");
	//       exit();
        //}
?>

<html>
<head>
	<title>LC78 - Administration des Résultats</title>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<link rel="stylesheet" type="text/css" href="../style/style.css" media="all" title="Normal" />
</head>
<body>

<?php
	$mySQLserver = "sql1.lc78-escrime.com";
	$mySQLuser = "lc78escrimecom";
	$mySQLpassword = "rEx0HoNS";
	$mySQLdefaultdb = "lc78escrimecom";


	$connexion = mysql_connect($mySQLserver,$mySQLuser,$mySQLpassword);
	mysql_select_db($mySQLdefaultdb,$connexion);
	//requete sur la table moteur
		
		$id = $_GET['id'];

		// RECUP DES DONNEES
		//requete sur la table moteur
		$req="SELECT * FROM `resultats` WHERE `id`='$id'";
		$requete = mysql_query($req);
		//Deconnexion$
		$resultats = mysql_fetch_array($requete);
		//Insertion des données dans le code HTML
		?>
		<form action="./modif_bd.php" method="GET" name="formulaire">
			<fieldset>
				<legend>Modification d'un résultat de compétition</legend>
					<div>
						<label for="date">Date</label>
							<input type="text" id ="date" name="datee" value="<?php echo $resultats['date_comp'];?>"/>
					</div>
					<div>
						<label for="epreuve">Epreuve</label>
							<input type="text" id ="epreuve" name="epreuve" value="<?php echo $resultats['epreuve'];?>"/>
					</div>
					<div>
						<label for="lieu">Lieu</label>
							<input type="text" id ="lieu" name="lieu" value="<?php echo $resultats['lieu'];?>"/>
					</div>
					<div>
						<label for="categorie">Categorie</label>
							<input type="text" id ="categorie" name="categorie" value="<?php echo $resultats['categorie'];?>"/>
					</div>
					<div>
				<label for="resultats">Résultats des Chesnaysiens<br />
				</label><textarea name="resultats" cols="35" rows="10">
<?php $res=str_replace("<br />",chr(13),$resultats['resultat_che']);echo $res;?>	
</textarea>
					</div>
					<input type="hidden" name="id" value="<?php echo $id; ?>">
					<br/>
			<div class="form-control">
					<input type="submit" value="Modifier" class="form-submit" />
			</div>
			</fieldset>
		</form>		
		
</body>
</html>
