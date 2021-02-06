<?php
require('controller/intranet.php');

if(isset($_GET['action'])) {
    if($_GET['action'] == 'PageHome') {
        PageHome();
    }
    elseif($_GET['action'] == 'PageActeur') {
        if($_GET['id_acteur']) {
            ListActeurDetail();
        }
        else {
            echo 'Erreur !!';
        }
    }
    else if($_GET['action'] == 'addCommentaire') {
        if(isset($_GET['id_acteur'])) {
            PostCommentaire($_SESSION['id_user'], $_GET['id_acteur'], $_SESSION['username'], $_POST['text']);
        }
    }
}
else {
    PageHome();
}


