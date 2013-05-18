<?php
	include("../includes/config.php");
	include("../includes/fonctions.php");
	include("../includes/header.inc");
	?>
	<div id="content">
	<form action="./select_tireur.php" method="GET" name="formulaire">
		<fieldset>
			<legend>Compétez les champs suivants</legend>
			<div>
					<label for="nom">Nom de la compétition</label><input type="text" id ="nom" name="nom"/>
			</div>
			<div>
				<label for="categorie">Catégorie</label>
					<select name="categorie">
						<option value="poussins">poussins</option>
						<option value="pupilles">pupilles</option>
						<option value="benjamins">benjamins</option>
						<option value="mimines">mimines</option>
						<option value="cadets">cadets</option>
						<option value="juniors">juniors</option>
						<option value="seniors">seniors</option>
						<option value="veteran">veteran</option>

					</select>
			</div>
			<div>
				<label>Sexe</label><input type="radio" value="M" name="sexe"/>Homme<br />
								<input type="radio" value="F" name="sexe"/>Femme
			</div>
			<div>
					<label for="date">Date (jj/mm/aaaa)</label><input type="text" id ="date" name="date"/>
			</div>
			<div>
					<label for="email">E-mail organisateur</label><input type="text" id ="email" name="email"/>
			</div>

				<br/>
		<div class="form-control">
				<input type="submit" value="Suivant" class="form-submit" />
				<input type="reset" value="Rétablir" class="form-reset" />
		</div>
		</fieldset>
	</form>


	<?php 	include("../includes/footer.inc"); ?>