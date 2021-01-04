<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title> GBAF</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
        <img id="logo" src=img/logo.png alt="">
    </header>
    <main id="main">
        <?php
        $bdd = new PDO('mysql:host=127.0.0.1;port=8889;dbname=GBAF','root', 'root'); 
        $req = $bdd->prepare('SELECT * FROM acteur WHERE id_acteur = ?');
        $req->execute(array($_GET['id_acteur']));
        $donnees = $req->fetch();
        ?>
        <div id="acteur_detail">
            <?php echo '<img src= "'. $donnees['logo'] . '"/>'; ?> 
            <h2><br><?php echo $donnees['acteur']; ?></h2>
            <a href="<?php echo $donnees['acteur'] . '.fr' ?>"><br><?php echo $donnees['acteur']; ?></a>
            <p><br> <?php echo $donnees['descriptions']; ?> </p>
        </div>
        <div id="bloc_com">
           <div class="header_bloc_com">
                <h3>1 COMMENTAIRES</h3>
                <div id="bloc_reaction">
                    <a id="button_commentaire" href="#nouveau_com">Nouveau Commentaire</a>
                    <p>1</p>
                    <a href="like.php">
                        <img src="img/like.png" alt="">
                    </a>
                    <p>1</p>
                    <a href="dislike.php">
                        <img src="img/dislike.png" alt="">
                    </a>
                </div>
            </div>
            <div id="dernier_com">
                <article>
                    <div class="header_dernier_com">
                        <h4>Selim</h4>
                        <label>28-12-2020</label>
                        <p>Super ! Je le recommande. </p>
                    </div>
                </article>
                <h3>AJOUTER UN COMMENTAIRE</h3>
                <form id="nouveau_com" method="POST">
                    <textarea name="new_com" placeholder="Votre commentaire..."></textarea>
                    <br>
                    <input type="submit" value="ENVOYER" name="button_envoyer">
                </form>
            </div>
        </div>
    </main>
    <footer>
        <a href="mentions_legales.php">Mentions Légales</a>
    </footer>
</body>
</html>