<?php
session_start();
	include("../includes/config.php");
	include("../includes/fonctions.php");
	include("../includes/header.inc");
	?>
	<div id="content">
		<?php
		
		// On initialise les variables
		$_SESSION['destinataire'] = $_GET['email'];
		$_SESSION['date'] = $_GET['date'];
		$_SESSION['categorie'] = $_GET['categorie'];
		$_SESSION['nom_compet'] = $_GET['nom'];
		$_SESSION['sexe'] = $_GET['sexe'];
		?>
		
		
		
		<!--<form action="./send.php" method="GET">-->
		<form action="./ajout_manuel.php" method="GET">
		<?php
//		echo "<input type=\"hidden\" name=\"destinataire\" value=\"".$destinataire."\">";
//		echo "<input type=\"hidden\" name=\"date\" value=\"".$date."\">";
//		echo "<input type=\"hidden\" name=\"nom_compet\" value=\"".$nom_compet."\">";
//		echo "<input type=\"hidden\" name=\"categorie\" value=\"".$categorie."\">";
//		echo "<input type=\"hidden\" name=\"sexe\" value=\"".$sexe."\">";
		?>
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
		<div class="form-control">
				<input type="submit" value="Inscrire" class="form-submit" />
				<input type="reset" value="Rétablir" class="form-reset" />
		</div>
		</form>
		
	<?php 	include("../includes/footer.inc"); ?>
