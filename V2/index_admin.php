<html>
<head>
	<title>LC78 - Résultats</title>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<link rel="stylesheet" type="text/css" href="./style/style.css" media="all" title="Normal" />
</head>
<body>
	<form action="./verif.php" method="post" name="identif">
        <fieldset>
                <legend>Identification</legend>
            <div>
                <label for="log">LOGIN</label><input type="text" id ="log" name="login"/>
            </div>
            <div>
                <label for="mdp">MOT DE PASSE</label><input type="password" id ="mdp" name="mdp"/>
            </div>
            <div class="form-control">
                <input type="submit" value="Valider" class="form-submit" />
                <input type="reset" value="Effacer" class="form-reset" />
            </div>
		</fieldset>
    </form>
</body>
</html>