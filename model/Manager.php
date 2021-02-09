<?php 

class Manager 
{
    protected function bddConnect()
    {
        try
        {
            $bdd = new \PDO('mysql:host=127.0.0.1;port=8889;dbname=GBAF','root', 'root');        
            return $bdd;
        }
        catch (Exeception $e)
        {
            die('Erreur : '.$e->getMessage());
        }

    }
}