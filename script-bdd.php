<?php

include("./views/include/cnx.php");

$query = $bdd->prepare("SELECT * FROM Jaquettes");
$query->execute();
while($donnees = $query->fetch())
{
  $queryUpdateGame = $bdd->prepare("UPDATE Games SET jaquette_id = :jaquette_id WHERE id =:game_id");
  $queryUpdateGame->bindValue(":jaquette_id", $donnees['id']);
  $queryUpdateGame->bindValue(":game_id", $donnees['game_id']);
  $queryUpdateGame->execute();
}


?>
