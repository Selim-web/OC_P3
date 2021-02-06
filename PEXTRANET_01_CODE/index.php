<?php
session_start();
require('controller/intranet.php');



if(isset($_GET['action'])) 
{
    if (!isset($_SESSION['username'])) {
        if($_GET['action'] == 'Connexion') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                Connexion($_POST['username'], $_POST['password']);
            }
            else {
                PageConnexion();
            }
        }
        else if($_GET['action'] == 'Inscription') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                Inscription();
            }
            else {
                PageInscription();
            }
        }
    }
    else {
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
                if($_POST['text'] != "") {
                PostCommentaire($_SESSION['id_user'], $_GET['id_acteur'], 
                $_SESSION['username'], $_POST['text']);
                } 
                else {
                header('Location: index.php?action=PageActeur&id_acteur='. $_GET['id_acteur']);
                }
            } 

        }
        else if($_GET['action'] == 'addLike/Dislike') {
            if(isset($_GET['id_acteur'])) {
                if($_GET['type'] == 1) {
                    toggle_like($_GET['id_acteur'], $_SESSION['id_user']);
                }
                else if($_GET['type'] == 2) {
                    toggle_dislike($_GET['id_acteur'], $_SESSION['id_user']);
                }
            }
        }
    }      
}
else {
    if(!isset($_SESSION['username'])) {  
         PageConnexion();
    }
    else {
        PageHome();
    }
}