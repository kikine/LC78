<?php
session_start() ;
	include("../includes/config.php");
	include("../includes/fonctions.php");
	include("../includes/header.inc");
	?>
	<div id="content">
		<?php

		//$nom_compet = $_GET['nom_compet'];
	//	$date = $_GET['date'];
	//	$destinataire = $_GET['destinataire'];
	//	$categorie = $_GET['categorie'];
	//	$sexe = $_GET['sexe'];

				
		$nom = $_GET['nom'] ;
		$prenom = $_GET['prenom'] ;
		$numlic = $_GET['lic'] ;
		$a = count($numlic);
		$message="<ul type=none>";
		for($n=0;$n < $a; $n++){
		$message.= "<li>".$nom[$n]." ".$prenom[$n]." \t04033041".$numlic[$n]."</li>";
		}
		$message.="</ul>";	
		echo $message;	
		?>
		<hr />
		Vous pouvez ajouter manuellement d'autres tireurs à cette compétition :
		<form action="./validation.php"  method="POST">
			<?php echo "<input type=\"hidden\" name=\"message\" value=\"".$message."\"/>"; ?>
			
			<?php echo "<input type=\"hidden\" name=\"nom_compet\" value=\"".$nom_compet."\"/>"; ?>
			<?php echo "<input type=\"hidden\" name=\"date\" value=\"".$date."\"/>"; ?>
			<?php echo "<input type=\"hidden\" name=\"destinataire\" value=\"".$destinataire."\"/>"; ?>
			<?php echo "<input type=\"hidden\" name=\"categorie\" value=\"".$categorie."\"/>"; ?>
			<?php echo "<input type=\"hidden\" name=\"sexe\" value=\"".$sexe."\"/>"; ?>

			<fieldset>
				<legend>Dernières Informations</legend>
				<div>
						<label for="sup">Tireurs suplémentaires</label><textarea name="manuel" cols="50" rows="10"></textarea>
				</div>
				<div>
						<label for="arb">Arbitre</label><textarea name="arbitre" cols="50" rows="3"></textarea>
						<div>						
						<label fpr="niv">Niveau</label>
							<br /><br /><input type="radio" name="niveau" value="départemental" />Départemantal
							<br /><input type="radio" name="niveau" value="régional" />Régional
							<br /><input type="radio" name="niveau" value="natiotal" />National
							<br /><input type="radio" name="niveau" value="international" />International
						</div>
				</div>	
				<br/>
				<div class="form-control">
					<input type="submit" value="Valider" class="form-submit" />
					<input type="reset" value="Effacer" class="form-reset" />
				</div>
			</fieldset>
		</form>
		

<?php	include("../includes/footer.inc"); ?>
