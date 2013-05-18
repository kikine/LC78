<?php
	include("../includes/config.php");
	include("../includes/fonctions.php");
	include("../includes/header.inc");
	?>
	<div id="content">
	<form action="<?php $_SERVER['PHP_SELF']?>" method="GET">
		<fieldset>
			<legend>Complétez les champs suivants</legend>
			<div>
					<label for="nom_compet">Nom de la compétition</label><input type="text" id ="nom_compet" name="nom_compet"/>
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
					<label for="date_comp">Date (jj-mm-aaaa)</label><input type="text" id ="date_comp" name="date_comp"/>
			</div>
			<div>
					<label for="email">E-mail organisateur</label><input type="text" id ="email" name="email"/>
			</div>
		</fieldset>
<?php
if (@$_GET['nom_compet'] == ""  && @$_GET['valid'] != "OK")
{
?>
		<br/>
		<div class="form-control">
				<input type="submit" value="Suivant" class="form-submit" />
				<input type="reset" value="Rétablir" class="form-reset" />
		</div>

<?php
}
?>
	</form>		

<?php
if (@$_GET['nom_compet'] != "" && @$_GET['valid'] != "OK")
{



?>

<form action="<?php $_SERVER['PHP_SELF']?>" method="GET">
<?php echo "<input type=\"hidden\" name=\"destinataire\" value=".$_GET['email'].">"; ?>
<?php echo "<input type=\"hidden\" name=\"date_comp\" value=".$_GET['date_comp'].">"; ?>
<?php echo "<input type=\"hidden\" name=\"categorie\" value=".$_GET['categorie'].">"; ?>
<?php echo "<input type=\"hidden\" name=\"nom_compet\" value=".$_GET['nom_compet'].">"; ?>
<?php echo "<input type=\"hidden\" name=\"sexe\" value=".$_GET['sexe'].">"; ?>
	<table class="tableau">
		<tr class="titre_tab">
			<td></td>
			<td>NOM</td>
			<td>PRENOM</td>
			<td>N° LICENCE</td>
		</tr>
		<?php
			$req = "SELECT * FROM `tireurs` WHERE `sexe` = \"".$sexe."\" order by nom, prenom";
			$retour = mysql_query($req);
			
			echo "\n";
			for ($i=0;$i<mysql_num_rows($retour);$i++)
				{
					$res1 = mysql_fetch_array($retour);
					
					if($res1['sexe']=='M')
			{
				echo "<tr class=\"content_tab_masc\">";
			}
			else if($res1['sexe']=='F')
			{
				echo "<tr class=\"content_tab_fem\">";
			}
				
					echo "<td><input type=checkbox name=\"lic[]\" value=" . $res1['numlic'] . "></td>";
					echo "<td>".$res1['nom']."</td>";
					echo "<td>".$res1['prenom']."</td>";
					echo "<td>".$res1['numlic']."</td>";
					echo "<input type=\"hidden\" name=\"nom[]\" value=".$res1['nom'].">";
					echo "<input type=\"hidden\" name=\"prenom[]\" value=".$res1['prenom'].">";
					echo "</tr>";
					echo "\n";
				}
				
		?>
		</table>

		<div>
				<label for="sup">Tireurs supplémentaires</label><textarea name="manuel" cols="50" rows="10"></textarea>
		</div>
		<hr />
		<div>
			<!--<label for="ma">Maitre d'Armes</label><input type="text" id ="ma" name="maitre"/>-->
				<br /><input type="radio" name="maitre" value="HUET Jean-Yves" />HUET Jean-Yves
				<br /><input type="radio" name="maitre" value="PLUCHET Renaud" />PLUCHET Renau
				<br /><input type="radio" name="maitre" value="VOISEUX Jean-Christophe" />VOISEUX Jean-Christophe
		</div>
		<hr />
		<div>
			<label for="arb">Arbitre</label><input type="text" id ="arb" name="arbitre"/>
		</div>
		<div>	
			<!--<label fpr="niv">Niveau</label>-->
				<br /><input type="radio" name="niveau" value="Formation Départemental" />Formation Départemantal
				<br /><input type="radio" name="niveau" value="Départemental" />Départemantal
				<br /><input type="radio" name="niveau" value="Formation Régional" />Formation Régional
				<br /><input type="radio" name="niveau" value="Régional" />Régional
				<br /><input type="radio" name="niveau" value="Formation Nationale" />Formation Nationale
				<br /><input type="radio" name="niveau" value="National" />National
				<br /><input type="radio" name="niveau" value="Formation International" />Formation Internationale
				<br /><input type="radio" name="niveau" value="International" />International
		</div>

		
		<br/>
		<input type="hidden" name="valid" value="OK" />
		<div class="form-control">
				<input type="submit" value="Génération mail et envoi" class="form-submit" />
				<input type="reset" value="Rétablir" class="form-reset" />
		</div>
</form>

<?php
}
?>

<?php
if (@$_GET['valid'] == "OK") //alors génération, stockage et envoi du pdf
{
	$destinataire = $_GET['email'];
	$date_comp = $_GET['date_comp'];
	$categorie = $_GET['categorie'];
	$nom_compet = $_GET['nom_compet'];
	$sexe = $_GET['sexe'];

		$nom = $_GET['nom'] ;
		$prenom = $_GET['prenom'] ;
		$numlic = $_GET['lic'] ;
		$a = count($numlic);
		$message="";
		for($n=0;$n < $a; $n++){
		$message.= $nom[$n]." ".$prenom[$n]." ".$numlic[$n]."\r\n";
		}

	//$nom = $_GET['nom'] ;
	//$prenom = $_GET['prenom'] ;
	//$numlic = $_GET['lic'] ;
	$manuel = $_GET['manuel'];
	$arbitre = $_GET['arbitre'];
	$niveau = $_GET['niveau'];
	$maitre = $_GET['maitre'];
	
	echo $message;

	include("./generate.php");

/*
	echo $date.$nom_compet;
	$pdf = pdf_new();
	pdf_open_file($pdf, "".$date.$nom_compet.".pdf");
	pdf_set_info($pdf, "Author", "Le Chesnay 78 Escrime");
	pdf_set_info($pdf, "Title", "Inscription compétition");
	pdf_set_info($pdf, "Creator", "See Author");
	pdf_set_info($pdf, "Subject", "Test");
	pdf_begin_page($pdf, 595, 842);
	pdf_add_bookmark($pdf, "Page 1");
	pdf_set_font($pdf, "Times-Roman", 30, "host");
	pdf_set_value($pdf, "textrendering", 1);
	pdf_show_xy($pdf, "Feuille d'engagement pour le <br />".$nom_compet." le ".$date."", 50, 750);
	pdf_moveto($pdf, 50, 740);
	pdf_lineto($pdf, 330, 740);
	pdf_stroke($pdf);
	pdf_end_page($pdf);
	pdf_close($pdf);
	pdf_delete($pdf);
	//$fp = fopen("test.pdf", "r");
	//header("Content-type: application/pdf");
	//fpassthru($fp);
	//fclose($fp);*/
} 
?>

<?php 	include("../includes/footer.inc"); ?>
