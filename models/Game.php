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

  static function incrementViews($game_id)
  {
    include 'views/include/cnx.php';
    $query = $bdd->prepare("UPDATE Games SET views=views+1 WHERE id = :id");
    $query->bindValue(":id", $game_id,  PDO::PARAM_INT);
    $query->execute();
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

  static function getGamesWithJaquetteWithLimit($limit)
  {
    include 'views/include/cnx.php';
    $query = $bdd->prepare("SELECT * FROM Games WHERE jaquette_id != 0 ORDER BY RAND() LIMIT :theLimit");
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



  static function getGameDescription($game_id) {
    include 'views/include/cnx.php';
    $query = $bdd->prepare("SELECT text FROM Descriptions WHERE game_id = :id");
    $query->bindValue(":id", $game_id, PDO::PARAM_INT);
    $query->execute();

    $row = $query->fetch();
    $description = $row['text'];


    return $description;
  }

  static function getGameWithMostViews()
  {
    include 'views/include/cnx.php';
    $query = $bdd->prepare("SELECT * FROM Games ORDER BY views DESC LIMIT 1");
    $query->execute();
    $result = $query->fetch();
    return $result;

  }

  static function getPlatformsArray($game_id)
  {
    $platformsArray = Array();
    include 'views/include/cnx.php';
    $query = $bdd->prepare("SELECT * FROM Association_platforms WHERE game_id = :game_id");
    $query->bindValue(":game_id", $game_id, PDO::PARAM_INT);
    $query->execute();
    while ( $row = $query->fetch() )
    {
      $platformsArray = $row['platform_id'];
    }
    return $platformsArray;
  }

  static function getPlatformsForGameWithId($game_id)
  {
    include 'views/include/cnx.php';
    $platformsArray = Game::getPlatformsArray($game_id);
    for($i = 0; $i < count($platformsArray); $i++)
    {
      $query = $bdd->prepare("SELECT * FROM Platforms WHERE id = :id");
      $query->bindValue(":id", $platformsArray[$i], PDO::PARAM_INT);
      $query->execute();

      $platformName = $query->fetch();
      $platformName = $platformName['name'];

      $platformsArray[$i] = $platformName;
    }

    return $platformsArray;
  }

  static function getBrandFromGameWithId($game_id)
  {
    include 'views/include/cnx.php';
    $platformsArray = Game::getPlatformsArray($game_id);
    $brandArray = Array();

    for($i = 0; $i < count($platformsArray); $i++)
    {
      $query = $bdd->prepare("SELECT * FROM Platforms WHERE id = :id");
      $query->bindValue(":id", $platformsArray[$i], PDO::PARAM_INT);
      $query->execute();

      $brandID = $query->fetch();
      $brandID = $brandID['brand_id'];

      if($brandID != NULL)
      {
        $query2 = $bdd->prepare('SELECT * FROM Brands WHERE id = :id');
        $query2->bindValue(":id", $brandID, PDO::PARAM_INT);
        $query2->execute();

        $donnees = $query2->fetch();
        $estPresent = false;
        foreach($brandArray as $brandTest)
        {
          if($brandTest == $donnees['name'])
          {
            $estPresent = true;
          }
        }

        if(!$estPresent)
        {
          $brandArray[] = $donnees['name'];
        }

      }
    }

    return $brandArray;
  }

  static function getGameCategory($game_id)
  {
    include 'views/include/cnx.php';
    $categoryArray = Array();
    $query = $bdd->prepare("SELECT * FROM Association_category  WHERE game_id = :game_id");
    $query->bindValue(":game_id", $game_id, PDO::PARAM_INT);
    $query->execute();

    while ( $row = $query->fetch() )
    {
      $query2 = $bdd->prepare("SELECT * FROM Categories WHERE id = :category_id");
      $query2->bindValue(':category_id', $row['category_id'], PDO::PARAM_INT);
      $query2->execute();
      while($data = $query2->fetch())
      {
        $categoryArray[] = $data['name'];
      }
    }


    return $categoryArray;
  }






}
?>
