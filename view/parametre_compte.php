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
        <a href="index.php">
            <img id="logo" src=public/img/logo.png alt="">
        </a>
        <nav>
            <a href="index.php?action=parametre">
                <img class="icon" src="public/img/user.png" alt="">
                <p><?= $_SESSION['nom'] .' '. $_SESSION['prenom']; ?></p>
            </a>
            <a href="index.php?action=deconnexion">
               <img class="icon" src="public/img/logout.png" alt=""> 
            </a>
        </nav>
    </header>
    <main id="corps">
        <img src="public/img/login.png" alt="">
        <h2>MON COMPTE</h2>
        <form method="post" novalidate>
            <div class="champs">
                <label> Nom :</label>
                <input type="text" name="nom" value="<?php echo $req_donnees['nom'] ?>"/>
            </div>
            <div class="champs">
                <label> Prenom :</label>
                <input type="text" name="prenom" value="<?php echo $req_donnees['prenom'] ?>"/>
            </div>
            <div class="champs">
                <label> Nom d'utilisateur :</label>
                <input type="text" name="username" value="<?php echo $req_donnees['username'] ?>"/>
            </div>
            <div class="champs">
                <label>Question secrète :</label>
                <select id="question" name="question">
                    <option value="<?php echo $req_donnees['question'] ?>"> Votre question :  <?php echo $req_donnees['question'] ?> </option>
                    <option value="Quel est le nom de votre ville natal ?">Quel est le nom de votre ville natal ?</option>
                    <option value="Quelle est la marque de votre première voiture ?">Quelle est la marque de votre première voiture ?</option>
                    <option value="Quel est le nom de jeune fille de votre mère ?">Quel est le nom de jeune fille de votre mère ?</option>
                    <option value="Quel est le nom de votre ami d'enfance ?">Quel est le nom de votre ami d'enfance ?</option>
                </select>
            </div>
            <div class="champs">
                <label> Réponse :</label>
                <input type="text" name="reponse" value="<?php echo $req_donnees['reponse'] ?>"/>
            </div>
            <p><?php if (isset($er_username)) { echo $er_username; }?></p>
            <input name="parametre_compte" type="submit" value="Valider">
        </form>
    </main>

    <footer>
        <a href="mentions_legales.php">Mentions Légales</a>
    </footer>
</body>
</html>