<?php
	include("../includes/config.php");
	include("../includes/fonctions.php");
	include("../includes/header.inc");

	?>
	<div id="content">
		<div id="search">
			<p>
				<a href="./search_tireurs.php?lettre=A">A</a> - 
				<a href="./search_tireurs.php?lettre=B">B</a> -
				<a href="./search_tireurs.php?lettre=C">C</a> -
				<a href="./search_tireurs.php?lettre=D">D</a> -
				<a href="./search_tireurs.php?lettre=E">E</a> -
				<a href="./search_tireurs.php?lettre=F">F</a> -
				<a href="./search_tireurs.php?lettre=G">G</a> -
				<a href="./search_tireurs.php?lettre=H">H</a> -
				<a href="./search_tireurs.php?lettre=I">I</a> -
				<a href="./search_tireurs.php?lettre=J">J</a> -
				<a href="./search_tireurs.php?lettre=K">K</a> -
				<a href="./search_tireurs.php?lettre=L">L</a> -
				<a href="./search_tireurs.php?lettre=M">M</a> -
				<a href="./search_tireurs.php?lettre=N">N</a> -
				<a href="./search_tireurs.php?lettre=O">O</a> -
				<a href="./search_tireurs.php?lettre=P">P</a> -
				<a href="./search_tireurs.php?lettre=Q">Q</a> -
				<a href="./search_tireurs.php?lettre=R">R</a> -
				<a href="./search_tireurs.php?lettre=S">S</a> -
				<a href="./search_tireurs.php?lettre=T">T</a> -
				<a href="./search_tireurs.php?lettre=U">U</a> -
				<a href="./search_tireurs.php?lettre=V">V</a> -
				<a href="./search_tireurs.php?lettre=W">W</a> -
				<a href="./search_tireurs.php?lettre=X">X</a> -
				<a href="./search_tireurs.php?lettre=Y">Y</a> -
				<a href="./search_tireurs.php?lettre=Z">Z</a> -
				<a href="./search_tireurs.php?lettre=all">TOUS</a> 
			</p>
			<hr />
		</div>
		<form action="<?php $_SERVER['PHP_SELF']?>" method="GET">
			<fieldset>
			<legend>Saisi un nom</legend>
				<div>
					<label for="nom">Nom</label>
						<input type="text" name="lettre" size="30" id="nom" />
						<input type="hidden" name="form" value="formul" />
						
				</div>
				<div class="form-control">
							<input type="submit" value="Valider" class="form-submit"./>
							<input type="reset" value="Effacer" class="form-reset"./>
				</div>
			</fieldset>
		</form>
		
		<hr />
		
		<?php
		$lettre = @$_GET['lettre'];
		$form = @$_GET['form'];
			if($form=='' && $lettre!='')
			{
				$affich = "select * from `tireurs` where nom like \"".$lettre."%\" ORDER BY `nom`";
			}

			if( ($form=='formul' && $lettre=='') || ($form=='' && $lettre=='') || ($lettre=='all'))
			{
				$affich = "select * from `tireurs` ORDER BY `nom`";
			}
			if($form=='formul' && $lettre!='')
			{
				$affich = "select * from `tireurs` where nom like \"%".$lettre."%\" ORDER BY `nom`";
			}
			$requete2 = mysql_query($affich);
		echo "<table class=\"tableau\">";
		?>
		<tr class="titre_tab">
			<td>NOM</td>
			<td>PRENOM</td>
			<td>DATE DE NAISSANCE<br />YYYY-MM-DD</td>
			<td>N° de licence</td>
		</tr>

		<?php
		for($n=0; $n < mysql_num_rows($requete2); $n++)
		{
			$resultats = mysql_fetch_array($requete2);
			if($resultats['sexe']=='M')
			{
				echo "<tr class=\"content_tab_masc\">";
			}
			else if($resultats['sexe']=='F')
			{
				echo "<tr class=\"content_tab_fem\">";
			}
			
				echo "<td><a href=\"./fiche.php?numlic=".$resultats['numlic']."\">".$resultats['nom']."</a></td>";
				echo "<td><a href=\"./fiche.php?numlic=".$resultats['numlic']."\">".$resultats['prenom']."</a></td>";
				echo "<td><a href=\"./fiche.php?numlic=".$resultats['numlic']."\">".$resultats['date_naiss']."</a></td>";
				echo "<td><a href=\"./fiche.php?numlic=".$resultats['numlic']."\">04033041".$resultats['numlic']."</a></td>";
			echo "</tr>";
		}
		echo "</table>";
		
		?>

	<?php 	include("../includes/footer.inc"); ?>