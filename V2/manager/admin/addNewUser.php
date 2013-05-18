<?php
	include("../includes/config.php");
	include("../includes/header.inc");
	include("../includes/fonctions.php");
	?>
	<div id="content">
	
		<form action="<?php $_SERVER['PHP_SELF'] ?>" method="get">
			<fieldset>
				<legend>Ajouter un utilisateur à l'application</legend>
				<div>
						<label for="nom">NOM</label><input type="text" id ="nom" name="nom"/>
				</div>
				<div>
						<label for="prenom">PRENOM</label><input type="text" id ="prenom" name="prenom"/>
				</div>
				<div>
						<label for="email">E-MAIL</label><input type="text" id ="email" name="email"/>
				</div>

				<br/>
				<div class="form-control">
					<input type="submit" value="Valider" class="form-submit" />
					<input type="reset" value="Effacer" class="form-reset" />
				</div>
			</fieldset>
		</form>
	
		<?php
		$nom = @$_GET['nom'];
		$prenom = @$_GET['prenom'];
		$email = @$_GET['email'];

		if( ($nom!='') && ($prenom!='') && ($email!='') )
		{
			$trigramme = substr($prenom,0,1);
			$trigramme.= substr($nom,0,2);
			$trigramme = strtoupper($trigramme);
			$login = substr($prenom,0,1);
			$login .= $nom;
			$login = strtolower($login);
			$nom = strtoupper($nom);
			$prenom = strtolower($prenom);
			$firstletter = substr($prenom,0,1);
			$firstletter = strtoupper($firstletter);
			$lastletter = substr($prenom,1);
			$prenom = $firstletter;
			$prenom .= $lastletter;
			$email = addslashes($email);
			$insertion = 'INSERT INTO `users`';
			$insertion .= "VALUES ('$nom','$prenom','$login','$login','$trigramme','$email')";
			$result = mysql_query($insertion);
			if($result)
			{
				echo '<div id="return">Utilisateur ajouté avec succès.</div>';
			}
			else
			{
				echo '<div id="return">Echec d\'ajout d\'utilisateur.</div>';
			}
		}
		else
		{
			echo '<div id="return">Les trois champs sont obligatoires</div>';
		}
		mysql_close($connexion);
		?>

		
		<div id="footer">
				<p>
					<a href="mailto:kikine_33@hotmail.com?subject=CEG_Manager">Réalisation T. Raso</a>
				</p>
				<p>
					<a href="#">C.E. Gradignan</a>
				</p>
		</div>
		
	</div>
	
</body>
</html>
