<?php
	include("./includes/config.php");
	include("./includes/fonctions.php");
	include("./includes/header.inc");
	?>
	
	<div id="content">
		<form action="./verif.php" method="get">
			<fieldset>
				<legend>Veuillez vous identifier...</legend>
				<div>
						<label for="log">LOGIN</label><input type="text" id ="log" name="login"/>
				</div>
				<div>
						<label for="mdp">MOT DE PASSE</label><input type="password" id ="mdp" name="mdp"/>
				</div>
				<br/>
				<div class="form-control">
					<input type="submit" value="Valider" class="form-submit" />
					<input type="reset" value="Effacer" class="form-reset" />
				</div>
			</fieldset>
		</form>
	
	<?php 	include("./includes/footer.inc"); ?>