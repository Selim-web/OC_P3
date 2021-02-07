<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title> GBAF</title>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <header>
        <img id="logo" src=public/img/logo.png alt="">
    </header>
    <main id="corps">
        <img src="public/img/mdp_oublie.png" alt="">
        <form novalidate method="post">
            <div class="champs">
                <label> Nom d'utilisateur :</label>
                <input type="text" name="username" placeholder="<?php if(isset($er_verif)) { echo $er_verif; } else { echo 'Entrez-votre nom d\'utilisateur'; } ?>"/>
            </div>
            <input name="changement_mdp" type="submit" value="Valider">
        </form>
    </main>
    <footer>
        <a href="mentions_legales.php">Mentions Légales</a>
</footer>
</body>
</html>