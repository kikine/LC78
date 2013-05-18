<?php
session_start() ;
	include("../includes/config.php");
	include("../includes/fonctions.php");
	include("../includes/header.inc");
	?>
	<div id="content">
		<?php

		$message = $_POST['message'];
		$manuel = $_POST['manuel'];
		$arbitre = $_POST['arbitre'];

		$nom_compet = $_GET['nom_compet'];
		$date = $_GET['date'];
		$destinataire = $_GET['destinataire'];
		$categorie = $_GET['categorie'];
		$sexe = $_GET['sexe'];

		?>

		<fieldset>
			<legend>Saisies automatiques</legend>	
			<div><?php echo $message; ?></div>	
		</fieldset>
		<fieldset>
			<legend>Saisies manuelles</legend>
			<div><?php echo $manuel; ?></div>	
		</fieldset>
		<fieldset>
			<legend>Arbitres</legend>		
			<div><?php echo $arbitre; ?></div>	
		</fieldset>
		<form action="./generate_send.php" method="POST">
		<?php
		echo "<input type=\"hidden\" name=\"message\" value=\"".$message."\">";
		echo "<input type=\"hidden\" name=\"manuel\" value=\"".$manuel."\">";
		echo "<input type=\"hidden\" name=\"arbitre\" value=\"".$arbitre."\">";

		echo "<input type=\"hidden\" name=\"nom_compet\" value=\"".$nom_compet."\"/>";
		echo "<input type=\"hidden\" name=\"date\" value=\"".$date."\"/>";
		echo "<input type=\"hidden\" name=\"destinataire\" value=\"".$destinataire."\"/>";
		echo "<input type=\"hidden\" name=\"categorie\" value=\"".$categorie."\"/>";
		echo "<input type=\"hidden\" name=\"sexe\" value=\"".$sexe."\"/>";

		?>
		<div class="form-control">
				<input type="submit" value="Génération et Envoi du PDF" class="form-submit" />
		</div>

		</form>
<?php	include("../includes/footer.inc"); ?>
