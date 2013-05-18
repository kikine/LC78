<?php
	session_start();
	include("../includes/config.php");
	include("../includes/fonctions.php");
	include("../includes/header.inc");
	
	?>
	<div id="content">
	
		<?php
			$login = $_SESSION['login'];
			echo '<table class="tableau">';
		$req = mysql_query("SELECT * FROM `users` WHERE login='$login'");
			for($n=0; $n<mysql_numrows($req); $n++) {
				$resultats = mysql_fetch_array($req);
				print "<tr><td>NOM</td><td>".$resultats['nom']."</td><td><div class=\"form-control\"><input type=\"submit\" value=\"Non Modifiable\" class=\"form-reset\" /></div></td></tr>";
				print "<tr><td>Prénom</td><td>".$resultats['prenom']."</td><td><div class=\"form-control\"><input type=\"submit\" value=\"Non Modifiable\" class=\"form-reset\" /></div></td></tr>";
				print "<tr><td>Trigramme</td><td>".$resultats['trigram']."</td><td><div class=\"form-control\"><input type=\"submit\" value=\"Non Modifiable\" class=\"form-reset\" /></div></form></td></tr>";
				print "<tr><td>Login</td><td>".$resultats['login']."</td><td><div class=\"form-control\"><input type=\"submit\" value=\"Non Modifiable\" class=\"form-reset\" /></div></form></td></tr>";
			}
		mysql_close($connexion);
		$nb_etoile=rand(2,10); 
		?>
		<tr>
			<td>Mot de passe</td>
			<td><?php $i=0;while($i<$nb_etoile){echo '*';$i++;} ?></td>
			<td><form action="./modif.php?" method="get">
					<input type="hidden" name="mod" value="mdp" />
					<div class="form-control">
						<input type="submit" value="Modifier" class="form-submit" />
					</div>
				</form>
			</td>
		</tr>
		</table>
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
