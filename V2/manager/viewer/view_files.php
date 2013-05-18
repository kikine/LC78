<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html xml:lang="fr" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>.:--Directories Listing--:.</title>
	<meta http-equiv=content-type content="text/html; charset=iso-8859-1">
	<meta http-equiv=content-script-type content=text/javascript>
	<meta http-equiv=content-style-type content=text/css>
	<meta lang=fr content="listingde repertoire" name=description>
	<meta content="listing, repertoire, fichier" name=keywords>
	<meta content="kikine" name=author>
	<meta content="internet" name=category>
	<meta content="index, follow" name=robots>
	<link title=normal media=screen href="style/normal.css" type=text/css rel=stylesheet>
	<!--<link href="style/headshok.ico" type=images/x-icon rel="shortcut icon">-->
	<meta content="mshtml 6.00.2800.1491" name=generator>
</head>

<body>

	<?php
		$dir_to_analyze = $_GET['direc'];
	
		$current_dir = $dir_to_analyze;
		$dir = opendir($current_dir);
	
		
		$counter = 0;
		while($file = readdir($dir))
		{
			$counter++;
		}
		$counter=$counter-2;
	?>

<h1>Fichiers indexés : <?php echo $counter;?></h1>
<div class="content">
	<?php
		
		print ("<h3>Répertoire Analysé => ".$dir_to_analyze."</h3>");
		
		print("<hr />");
		
		$current_dir = $dir_to_analyze;
		$dir = opendir($current_dir);
		
		while ($file = readdir($dir))
		{
		
			$file_array = explode('.',$file);
		
			if(@$file_array[1]=='')
				{
					print("&nbsp;&nbsp;<img src='images/dossier.gif' width='23' height='16' align='absbottom'>&nbsp;");
					print("<a href='".$file."'>$file</a>");
					print("<br />");
				}
			
		}
		echo '<hr />';
		closedir($dir);

		
		
		
		$current_dir = $dir_to_analyze;
		$dir = opendir($current_dir);
		
		//$exp_reg = '^[a-zA-Z0-9_\-]+\.[a-zA-Z0-9]{3}$';
		$video=array('avi','mpg','mov','asf','wmv','mpeg','mkv','MPG','mp3','MP3');
		$document=array('txt');
		$internet=array('html','htm','php','css','pl');
		
		
		while ($file = readdir($dir))
		{
		
			$file_array = explode('.',$file);

			$i=0;
			while($i<count($video))
			{
				if( @$file_array[1]==@$video[$i])
				{
					print("&nbsp;&nbsp;<img src='images/icones/codecs.ico' align='absbottom'>&nbsp;");
					print("<a href=\"./see.php?directory=".$dir_to_analyze."&to_see=".$file."\">$file</a>");
					print("<br />");
				}				
				$i++;
			}
			
			if(@$file_array[1]=='java')
			{
				print("&nbsp;&nbsp;<img src='images/icones/JavaCup.ico' align='absbottom'>&nbsp;");
				print("<a href='$file' class='text1'>$file</a>");
				print("<br />");
			}
			
			if( (@$file_array[1]=='html') || (@$file_array[1]=='htm') )
			{
				print("&nbsp;&nbsp;<img src='images/icones/Internet.ico' align='absbottom'>&nbsp;");
				print("<a href='$file' class='text1'>$file</a>");
				print("<br />");
			}
			
		}
		echo '<hr />';
		closedir($dir);
	?>
</div>	
</body>
</html>
