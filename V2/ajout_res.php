<?php
        session_start();

        if( empty($_SESSION['auth']) || ($_SESSION['auth']!="yes") ) {
               header("Location: http://lc78-escrime.com/news.php");
	       exit();
        }
?>

<html>
<head>
	<title>LC78 - Administration des R�sultats</title>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<link rel="stylesheet" type="text/css" href="./style/style.css" media="all" title="Normal" />
</head>
<body>
	<!--formulaire de saisie des r�sultats-->
	<form action="./add_res.php" method="GET" name="formulaire">
			<fieldset>
				<legend>Ajouter les r�sultats d'une comp�tition</legend>
				<div>
						<label for="date">Date (AAAA-MM-JJ)</label><input type="text" id ="date" name="date"/>
				</div>
				<div>
						<label for="epreuve">Epreuve</label>
						<select name="epreuve">
							<option value="non">Votre choix</option>
							<option value="non">-----------</option>
							<option value="D�partemental">D�partementale</option>
							<option value="Circuit Ligue">Ligue</option>
							<option value="Cirucit Zone">Zone</option>
							<option value="Circuit National">Nationale</option>
							<option value="Internationale">Internationale</option>
						</select>
				</div>
				<div>
						<label for="sexe">Sexe</label>
							<input type="radio" id ="dame" name="sexe" value="Dames" /> Dames<br />
							<input type="radio" id ="home" name="sexe" value="Hommes" /> Hommes
				</div>
				<div>
						<label for="lieu">Lieu</label><input type="text" id ="lieu" name="lieu"/>
				</div>
				<div>
					<label for="categorie">Cat�gorie</label>
						<select name="categorie">
							<option value="non">Votre choix</option>
							<option value="non">-----------</option>
							<option value="Benjamins">Benjamins</option>
							<option value="Minimes">Minimes</option>
							<option value="Cadets">Cadets</option>
							<option value="Juniors">Juniors</option>
							<option value="Seniors">Seniors</option>
							<option value="Veterans">V�t�rans</option>
						</select>
				</div>
				<div>
					<label for="resultat">R�sultats des Chesnaysiens<br />
					</label><textarea name="resultat" cols="30" rows="10">
1 - BING Chandler
2 - DALTON Joe
3 - PIGNON Fran�ois</textarea>
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
