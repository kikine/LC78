<?php

if(isset($_FILES['photos']))
{
  // params
  unset($erreur);
  $extensions_ok = array('png', 'gif', 'jpg', 'jpeg');
  $taille_max = 500000;
  //$dest_dossier = '/home/monsite/photos/';
  //$dest_dossier = '/opt3/local/apache/htdocs/sites/l/lc78-escrime.com/photos/';
  $dest_dossier = '/home/local/apache/htdocs/sites/l/lc78-escrime.com/photos/';
 
  // vérifications
  if( !in_array( substr(strrchr($_FILES['photos']['name'], '.'), 1), $extensions_ok ) )
  {
    $erreur = 'Veuillez sélectionner un fichier de type png, gif ou jpg !';  
  }
  elseif( file_exists($_FILES['photos']['tmp_name']) 
          and filesize($_FILES['photos']['tmp_name']) > $taille_max)
  {
    $erreur = 'Votre fichier doit faire moins de 500Ko !';
  }
  // copie du fichier
  if(!isset($erreur))
  {
    $dest_fichier = basename($_FILES['photos']['name']);
    // formatage nom fichier
    // enlever les accents
    $dest_fichier = strtr($dest_fichier, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜİàáâãäåçèéêëìíîïğòóôõöùúûüıÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
    // remplacer les caracteres autres que lettres, chiffres et point par _
    //$dest_fichier = preg_replace('/([^.a-z0-1]+)/i', '_', $dest_fichier);
    // copie du fichier
    move_uploaded_file($_FILES['photos']['tmp_name'], $dest_dossier . $dest_fichier);
	$url = 'http://www.lc78-escrime.com/photos/'.$dest_fichier.'';
	echo 'Votre image à été uploadée sur le serveur avec succes!<br>Voici le lien: <input type="text" value="' . $url . '" size="60">'; 
	
  }
}

?>
<html>
<body>
<!-- Erreur ? -->
<?php 
if(isset($erreur)){
  echo '<p>', $erreur ,'</p>';
}
?>
<!-- Formulaire -->
<!-- Attention, ne de ne pas oublier le  enctype="multipart/form-data" -->
<form method="POST" action="ajouter.php" enctype="multipart/form-data">
<!-- Limiter la taille des fichiers à 500Ko -->
<input type="hidden" name="MAX_FILE_SIZE" value="500000" /> 
<fieldset>
<legend>Envoi de fichiers</legend>
<!-- champs d'envoi de fichier, de type file -->
<p><label for="photo">Photo :</label><input type="file" name="photos" /></p>
<!--<p><label for="photo_2">Photo 2 :</label><input type="file" name="photo_2" /></p>-->
<!-- bouton d'envoi -->
<p><input type="submit" name="envoi" value="Envoyer les fichiers" /></p>
</legend>
</fieldset>
</form>
</body>
</html>