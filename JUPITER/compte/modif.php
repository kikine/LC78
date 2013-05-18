<?php
	include("../includes/config.php");
	include("../includes/fonctions.php");
	include("../includes/header.inc");
?>
	<div id="content">
		<form action="./verif.php" method="post">
			<fieldset>
				<legend>Modification de votre mot de passe</legend>
				<div>
						<label for="log">Ancien mot de passe</label><input type="text" id ="log" name="old_mdp"/>
				</div>
				<div>
						<label for="log">Nouveau mot de passe</label><input type="text" id ="log" name="new_mdp"/>
				</div>
				<div>
						<label for="log">Confirmation</label><input type="text" id ="log" name="confirm_mdp"/>
				</div>
					<input type="hidden" name="activate" value="1" />
				<br/>
				<div class="form-control">
					<input type="submit" value="Valider" class="form-submit" />
					<input type="reset" value="Effacer" class="form-reset" />
				</div>
			</fieldset>
		</form>
	
<?php
	include("../includes/footer.inc");
?>