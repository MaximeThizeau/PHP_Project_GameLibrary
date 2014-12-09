<?php
require_once("models/script-functions.php");
class Game {


  static function all() {
    include 'views/include/cnx.php';
    $query = $bdd->prepare("SELECT * FROM Games");
    $query->execute();
    $result = $query->fetch();
    return $result;
  }

  static function getGamesByDateWithLimit($limit)
  {
    include 'views/include/cnx.php';
    $query = $bdd->prepare("SELECT * FROM Games ORDER BY added_at DESC LIMIT :theLimit");
    $query->bindValue(":theLimit", $limit, PDO::PARAM_INT);
    $query->execute();

    while ( $row = $query->fetch() )
    {
      $data[] = $row;
    }


    return $data;
  }


  static function getGamesByPopularityWithLimit($limit)
  {
    include 'views/include/cnx.php';
    $query = $bdd->prepare("SELECT * FROM Games ORDER BY RAND() LIMIT :theLimit");
    $query->bindValue(":theLimit", $limit, PDO::PARAM_INT);
    $query->execute();

    while ( $row = $query->fetch() )
    {
      $data[] = $row;
    }


    return $data;
  }

  static function getGame($game_id) {
    include 'views/include/cnx.php';
    $query = $bdd->prepare("SELECT * FROM Games WHERE id = :id");
    $query->bindValue(":id", $game_id, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch();
    return $result;
  }


  static function getJaquetteName($game_id) {
    if(Game::jaquetteExist($game_id))
    {
      include 'views/include/cnx.php';
      $query = $bdd->prepare("SELECT * FROM Jaquettes WHERE game_id = :id");
      $query->bindValue(":id", $game_id, PDO::PARAM_INT);
      $query->execute();
      $result = $query->fetch();
      $jaquetteName = remove_special_char(Game::getGame($game_id)['name']) ."_".$result['id'].".jpg";
      return $jaquetteName;
    }
    else
    {
      return "defaultJaquette.jpg";
    }

  }

   static function jaquetteExist($game_id) {
    include 'views/include/cnx.php';
    $query = $bdd->prepare("SELECT COUNT(*) AS nbr FROM Jaquettes WHERE game_id = :id");
    $query->bindValue(":id", $game_id, PDO::PARAM_INT);
    $query->execute();
    $req  = $query->fetch(PDO::FETCH_ASSOC);

    if($req['nbr']==0)
    {
      return false;
    }
    else
    {
      return true;
    }
  }

}
?>
