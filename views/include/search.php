<?php

include('cnx.php');

    if(isset($_GET['query'])) 
    {
        // Mot tapé par l'utilisateur
        $query = htmlentities($_GET['query']);
 
        // Requête SQL
        $requete = "SELECT * FROM games WHERE name LIKE '". $query ."%' LIMIT 0, 5";
        
        // Exécution de la requête SQL
        $resultat = $bdd->query($requete) or die(print_r($bdd->errorInfo()));
 
        // On parcourt les résultats de la requête SQL
        while($donnees = $resultat->fetch(PDO::FETCH_ASSOC)) {
            // On ajoute les données dans un tableau
            $suggestions['suggestions'][] = $donnees['name'];
        }
 
        // On renvoie le données au format JSON pour permettre l'execution du plugin
        echo json_encode($suggestions);
    }
?>