<?php
	include("../includes/config.php");
	include("../includes/fonctions.php");
	include("../includes/header.inc");
?>
	<div id="content">
	
			<?php
			$numlic = $_GET['numlic'];
			$affich = "select * from `tireurs` where numlic =".$numlic."";
			$requete2 = mysql_query($affich);
			$resultats = mysql_fetch_array($requete2);
			
			$nom = $resultats['nom'];
			$prenom = $resultats['prenom'];
			$photo = substr($prenom,0,1);
			$photo .= $nom;
			$photo = strtolower($photo);
			
			?>
	
		<div class="cadre1">
			<img src="./photos/<?php echo $photo ?>.jpg"></img>
		</div>
		<div class="cadre">
			<p>NOM : <span><?php echo $nom; ?></span></p>
			<p>Prénom : <span><?php echo $prenom; ?></span></p>
			<p>Date de Naissance : <span><?php echo $resultats['date_naiss']; ?></span></p>
			<p>N° de Licence : <span>04033041<?php echo $resultats['numlic']; ?></span></p>
			<p>Catégorie : <span><?php echo $resultats['categorie']; ?></span></p>
			<p>&nbsp;</p>
		</div>
		<div class="cadre">
			<p>N° veste : <span>personnel</span></p>
			<p>N° masque : <span>personnel</span></p>
			<p>N° pantalon : <span>personnel</span></p>
			<p>Location : <span></span></p>
			<p>&nbsp;: <span></span></p>
			<p>&nbsp;:<span></span></p>
		</div>
		<div class="cadre">
			<p>Domicile :  <span><?php echo $resultats['tel_fixe']; ?></span></p>
			<p>Portable : <span><?php echo $resultats['tel_port']; ?></span></p>
			<p>E-mail : <span><a href="mailto:<?php echo $resultats['email']; ?>"><?php echo $resultats['email']; ?></a></span></p>
			<p>MSN messenger: <span><?php echo $resultats['msn']; ?></span></p>
			<p><span></span></p>
			<p><span></span></p>
		</div>
		<div class="cadre">
			<p>Adresse: <span></span></p>
		</div>
		<div class="cadre">
			<p><span></span></p>
			<p><span></span></p>
			<p><span></span></p>
			<p><span></span></p>
			<p><span></span></p>
			<p><span></span></p>
		</div>
		<div class="cadre">
			<p><span></span></p>
			<p><span></span></p>
			<p><span></span></p>
			<p><span></span></p>
			<p><span></span></p>
			<p><span></span></p>
		</div>

		<?php
		include("../includes/footer.inc");
		?>