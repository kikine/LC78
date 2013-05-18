<?php
	include("../includes/config.php");
	include("../includes/fonctions.php");
	include("../includes/header.inc");
?>
	<div id="content_admin">
	
		<div class="cadre">
			<form action="#" method="get"><div class="form-control"><input type="submit" value="Ajouter un utilisateur" class="form-submit" />
			</div>
			</form>
			
			<form action="#" method="get"><div class="form-control"><input type="submit" value="Modifier un utilisateur" class="form-submit" />
			</div>
			</form>
			
			<form action="#" method="get"><div class="form-control"><input type="submit" value="Supprimer un utilisateur" class="form-submit" />
			</div>
			</form>
			
			<form action="#" method="get"><div class="form-control"><input type="submit" value="Ré-initialiser password" class="form-submit" />
			</div>
			</form>
				
		</div>
		
		
		
		<div class="cadre">
			<form action="http://<?php echo $hostname; ?>/JUPITER/competition/ADM_index.php" method="post"><div class="form-control"><input type="submit" value="Admin Compétition" class="form-submit" />
			</div>
			</form>
			
			<form action="#" method="get"><div class="form-control"><input type="submit" value="GenStats Compétition" class="form-submit" />
			</div>
			</form>
			
		</div>
		<!--
		<div class="cadre">
			
		</div>

		<div class="cadre">
			
		</div>		
-->
	
<?php
	include("../includes/footer.inc");
?>