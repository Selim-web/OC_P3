<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>GBAF</title>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <header>
        <img id="logo" src=public/img/logo.png alt="">
    </header>
    <main id="corps">
        <img src=public/img/login.png alt="">
        <form action="index.php?action=Connexion" method="post">
            <div class="champs">
                <label>Nom d'utilisateur :</label>
                <input type="text" name="username" placeholder="<?php if(isset($er_username)) { echo $er_username; } else { echo 'Username'; } ?> "/>
            </div>
            <div class="champs">
                <label>Mot de passe :</label>
                <input type="password" name="password" placeholder="********"/>
            </div>
                <p><?php if(isset($er_verif)) { echo $er_verif; } ?></p>
                <a href="index.php?action=MdpOublier">Mot de passe oublié</a>
                <br>
                <input type="submit" name="connexion" value="Connexion">
        </form>
        <a id="inscription" href="index.php?action=Inscription">Inscripton</a>
    </main>
    <footer>
            <a href="mentions_legales.php">Mentions Légales</a>
    </footer>
</body>
</html>