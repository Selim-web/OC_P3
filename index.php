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
                Inscription($_POST['nom'],
                $_POST['prenom'],
                $_POST['username'],
                $_POST['password'],
                $_POST['conf_password'],
                $_POST['question'],
                $_POST['reponse']);
            }
            else {
                PageInscription();
            }
        }
        elseif($_GET['action'] == 'MdpOublier') {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                MdpOublier($_POST['username']);
            }
            else {
                PageMdpOublier();
            }
        }
        elseif($_GET['action'] == 'ModificationMdp') {
            if($_GET['username']) {
                if($_SERVER['REQUEST_METHOD'] == 'POST') {
                    MdpOublierModification($_POST['reponse'], 
                    $_POST['password'], 
                    $_POST['conf_password'], 
                    $_GET['username']);
                }
                else {
                    PageMdpModification($_GET['username']);
                }
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
        else if($_GET['action'] == 'parametre') {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                Parametre($_POST['nom'],
                $_POST['prenom'],
                $_POST['username'],
                $_POST['question'],
                $_POST['reponse'],
                $_SESSION['id_user']);
            }
            else {
                PageParametre($_SESSION['id_user']);
            }
        }
        else if($_GET['action'] == 'deconnexion') {
            Deconnexion();
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