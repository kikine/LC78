

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="MSSmartTagsPreventParsing" content="TRUE" />
	<title>
		CE Gradignan | Inscription Compet		 
	</title>
	<link rel="stylesheet" href="./all.css" media="all" />
	<style type="text/css" media="screen">
	<!--
		@import "./screen.css";
	-->
	</style>
</head>

<body>
<!-- GLOBAL -->
<!--  -->
<div id="body-wrapper">
	<!--  -->
	<p id="css-warning">
		Votre navigateur ne vous permet pas de profiter de la mise en page du site, utilisant le standard CSS2.<br />
		Nous vous recommandons de mettre &agrave; jour votre navigateur.		
	</p>
	<!--  -->
	<hr class="hide" />
	<!--  -->
	<div id="page">	
		
		<div id="page-header">
		<div id="page-header-wrapper">
		<!-- HEADER -->

		<img src="./images/logoCEG.GIF" id="header-books" align="left" />

		<h1>
			Inscription compétitions
		</h1>
		<hr class="hide" />
		<h2>
			<!--Signaler un problème-->
		</h2>
		
		<br clear="all" class="hide" />
		<!-- END HEADER -->
		
		</div>
		</div>
		<!--  -->
		<hr class="hide" />
		<!--  -->
		<!--  -->
		
		<!--  -->
		<div id="page-content">
		<div id="page-content-wrapper">
		<div class="spacer"></div>
		
		<!-- PAGE CONTENT -->
		<form action="<?php $_SERVER['PHP_SELF']?>" method="GET">
		<fieldset>
		<legend>Ajouter un tireur dans la base</legend>
			<div>
				<label for="nom">Nom</label><input type="text" name="nom" size="30" id="nom"/>
			</div>
			<div>
				<label for="prenom">Prénom</label><input type="text" name="prenom" size="30" id="prenom"/>
			</div>
			<div>
				<label for="licence">N° Licence</label>04033041<input type="text" name="licence" size="4" id="licence"/>
			</div>
			<div>
				<label for="sexe">Sexe</label>	M<input type="radio" name="sexe" value="M" />&nbsp;&nbsp;&nbsp;&nbsp;
								F<input type="radio" name="sexe" value="F" />
			</div>
			<div class="form-control">
						<input type="submit" value="Ajouter" class="form-submit"/>
						<input type="reset" value="Effacer" class="form-reset"/>
			</div>
		</fieldset>
		</form>
		
		<?php	
		if((@$_GET['nom']!="")&&(@$_GET['prenom']!="")&&(@$_GET['licence']!="")&& (@isset($_GET['sexe']))){
		
		$connexion = mysql_connect('localhost','root','');
		mysql_select_db('inscriptions',$connexion);
		$nom=$_GET['nom'];
		$nom = strtoupper($nom);
		$prenom=$_GET['prenom'];
		$licence="04033041";
		$licence.=$_GET['licence'];
		$sexe=$_GET['sexe'];
		
		$re="SELECT * FROM `tireurs` WHERE `licence`='$licence'";
		$req = mysql_query($re);
		$resultat=mysql_fetch_array($req);
		if($resultat == 1) // la référence n'existe pas
		{
			echo "<azerty>Le tireur est déjà référencé dans la base de données</azerty>";
		}
		else
			{
				$sql="INSERT INTO `tireurs` VALUES ('$nom','$prenom','$licence','$sexe')";
				$reqIns = mysql_query($sql);
				if($reqIns)
				{
					echo "<b><azerty>Insertion OK</azerty></b>";
				}
				else
				{
					echo "prout ca marche pas";
				}
			}
		}
		?>
		<br/>
		<br/>
		<div>
				<a href="./index.php" class="back-home-link">
					<img src="./images/icon-back-link.gif">Retour
				</a>
			</div>
		
		<!--  END PAGE CONTENT -->
		</div>
		</div>
		<!--  -->
		<hr class="hide" />
		<!--  -->
		<div id="page-footer">
		<div id="page-footer-wrapper">
		<div class="spacer"></div>
		<!-- FOOTER -->
			<p>
				Réalisation T. Raso dopé par <a href="http://www.jedit.org">jEdit</a>a>
			</p>
		<!-- END FOOTER -->		
		</div>
		</div>
	</div>
	<!--  -->
	
	<!--  -->
	<hr class="hide" />
	<!--  -->

</div>
</body>
</html>
