<?php
        // Connexion à la base de données
        try
        {
            $bdd = new PDO('mysql:host=localhost;dbname=php_project', 'root', 'root');
        }
        catch(Exception $e)
        {
            exit('Impossible de se connecter à la base de données.');
        }
?>
