<?php

include "cnx.php";
include "avis.class.php";


$query = $bdd->prepare("INSERT INTO reviews (id,name,body,game_id) VALUES(1, :name1, :body1, 1)");
$query->bindValue(":name1", "GamerZ");
$query->bindValue(":body1", "Pas encore de commentaire pour ce jeu ?");
$query->execute();

$game_id = 1;
$comments = array();
$result = $bdd->prepare("SELECT * FROM reviews WHERE game_id = '$game_id' ORDER BY id DESC");
$result->execute();

while($row = $result->fetch(PDO::FETCH_ASSOC))
{
  $comments[] = new Comment($row);
}


foreach($comments as $c)
{
  echo $c->markup();
}

?>
