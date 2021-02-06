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
            <a href="parametre_compte.php">
                <img class="icon" src="public/img/user.png" alt="">
                <p><?php echo $_SESSION['nom'] .' '. $_SESSION['prenom']; ?></p>
            </a>
            <a href="deconnexion.php">
               <img class="icon" src="public/img/logout.png" alt=""> 
            </a>
        </nav>
    </header>
    <main id="main">
        <div id="acteur_detail">
            <?php echo '<img src= "'. $acteur['logo'] . '"/>'; ?> 
            <h2><br><?php echo $acteur['acteur']; ?></h2>
            <a href="<?php echo $acteur['acteur'] . '.fr' ?>"><br><?php echo $acteur['acteur']; ?></a>
            <p><br> <?php echo $acteur['descriptions']; ?> </p>
        </div>
        <div id="bloc_com">
           <div class="header_bloc_com">
                <h3><?php echo $nbr_commentaire['commentaires_total']; ?> COMMENTAIRES</h3>
                <div id="bloc_reaction">
                    <a id="button_commentaire" href="#nouveau_com">Nouveau Commentaire</a>
                    <p><?= $likes ?></p>
                    <a href="index.php?action=addLike/Dislike&type=1&id_acteur=<?php echo $_GET['id_acteur']; ?>">
                        <img src="public/img/like.png" alt="">
                    </a>
                    <p><?= $dislikes ?></p>
                    <a href="index.php?action=addLike/Dislike&type=2&id_acteur=<?php echo $_GET['id_acteur']; ?>">
                        <img src="public/img/dislike.png" alt="">
                    </a>
                </div>
            </div>
            <?php
            while($commentaire = $req_commentaire->fetch())
            {
            ?>
                <div id="dernier_com">
                    <article>
                        <div class="header_dernier_com">
                            <h4><?php echo $commentaire['username']; ?> </h4>
                            <label><?php echo $commentaire['date_creation'];?></label>
                            <p><?php echo $commentaire ['commentaires']; ?></p>
                        </div>
                    </article>
            <?php
            }
            $req_commentaire->closeCursor();
            ?>
                <h3>AJOUTER UN COMMENTAIRE</h3>
                <form action="index.php?action=addCommentaire&amp;id_acteur=<?= $_GET['id_acteur']; ?>" id="nouveau_com" method="post">
                    <textarea name="text" placeholder="<?php if(isset($er_commentaire)) { echo $er_commentaire; } else { echo 'Votre commentaire...'; } ?>"></textarea>
                    <br>
                    <input name="commentaires_post" type="submit" value="ENVOYER">
                </form>
            </div>
        </div>
    </main>
    <footer>
        <a href="mentions_legales.php">Mentions Légales</a>
    </footer>
</body>
</html>