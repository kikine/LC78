<?php	
	
	session_start();
	
	$mySQLserver = "sql1.lc78-escrime.com";
	$mySQLuser = "lc78escrimecom";
	$mySQLpassword = "rEx0HoNS";
	$mySQLdefaultdb = "lc78escrimecom";
	
	$login=$_POST['login'];
	$mdp=$_POST['mdp'];
	$connection = mysql_connect($mySQLserver,$mySQLuser,$mySQLpassword)or die(mysql_error());
	mysql_select_db($mySQLdefaultdb,$connection);
	
	$res = mysql_query("SELECT * FROM `users` WHERE login='".$login."' AND mdp='".$mdp."'");
	$rows = mysql_num_rows($res);
	$resultats= mysql_fetch_array($res);
	if($rows == 1) {
		$_SESSION['auth'] = "yes";
		header("Location: ./ajout_res.php");
		exit();
	}
	else {
		header("Location: http://lc78-escrime.com/news.php");
		exit();
	}
?>
