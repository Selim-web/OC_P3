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
    <main id="main">
        <div id="presentation">
            <h1>GBAF (Groupement Banque Assurance Français)</h1>
            <br>
            <?php echo "Salut toi"; ?>
            <p> Le Groupement Banque Assurance Français (GBAF) est une fédération représentant les 6 grands groupes français : BNP Paribas / BPCE / Crédit Agricole / Crédit Mutuel-CIC / Société Générale / La Banque Postale.
            <br>
            <br>
                Même s’il existe une forte concurrence entre ces entités, elles vont toutes travailler de la même façon pour gérer près de 80 millions de comptes sur le territoire national. Le GBAF est le représentant de la profession bancaire et des assureurs sur tous les axes de la réglementation financière française. Sa mission est de promouvoir l'activité bancaire à l’échelle nationale.
                C’est aussi un interlocuteur privilégié des pouvoirs publics.
            </p>
            <img src="public/img/extranet_t.jpg" alt="">
        </div>
        <div id="acteur">
            <h2>Acteurs et partenaires du système bancaire français</h2>
            <p>
                Comme de nombreux autres métiers, la finance se trouve confrontée à l’apparition de nouveaux acteurs, de nouveaux modes de distribution, de nouveaux comportements de la part des clients et de nouveaux business models. <br> Si toutes ses activités sont affectées, ce sont les activités bancaires traditionnelles, celles de prêts, de dépôts et de paiement, qui sont toutefois les plus impactées par ce phénomène en raison de la mise en place des nouvelles régulations et de l’émergence des FinTech. Les banques disposent d’atouts importants pour faire face à ces évolutions, elles devront toutefois repenser en profondeur leurs modèles opérationnels.
            </p> 
       <?php
       while($acteur = $reponse->fetch())
       {
        ?>  
        <article>
                <img src="<?= $acteur['logo'] ?>" alt=""/> 
                <div id="bande_acteur">
                   <h3><?= $acteur['acteur']; ?></h3>
                   <p> <?= substr ($acteur['descriptions'], 0, 70) . '...'; ?></p>
                </div>
                <a  id="button_suite" href="index.php?action=PageActeur&id_acteur=<?= $acteur['id_acteur']; ?>">Lire la suite</a>
            </article> 
       <?php
       }
       $reponse->closeCursor();
       ?>
        </div>
    </main>
    <footer>
        <a href="mentions_legales.php">Mentions Légales</a>
    </footer>
</body>
</html>