<?php
set_time_limit(0);
include('../plugins/simple_html_dom.php');
include('../views/include/cnx.php');
include('../models/script-functions.php');

function enregistrerImage($paramId, $titreDuJeu, $src, $bdd)
{
  $queryInsert = $bdd->prepare("INSERT INTO Jaquettes (game_id) VALUES(:game_id)");
  $queryInsert->bindValue(":game_id", $paramId, PDO::PARAM_INT);
  $queryInsert->execute();
  $queryInsert->CloseCursor();
  $lastid = $bdd->lastinsertid();
  $nom_photo = $titreDuJeu ."_".$lastid;

  $upload = file_put_contents("../assets/img/jaquettes/".$nom_photo.".jpg",file_get_contents($src));
}

function getContentWorks($url)
{
  if (file_get_html($url) === false OR file_get_contents($url) === false)
  {
    return false;
  }
  return true;
}

function updateJaquette($id, $bdd)
{
  $queryUpdate = $bdd->prepare("UPDATE URL_Gameblog SET done_jaquette = 1 WHERE id = :id");
  $queryUpdate->bindValue(":id", $id, PDO::PARAM_INT);
  $queryUpdate->execute();
}





$query = $bdd->prepare("SELECT * FROM URL_Gameblog WHERE crawl_type = 2 AND done_jaquette = 0 LIMIT 40");
$query->execute();

while($donnees = $query->fetch())
{
  echo "<div style='width : 100%; border-top : 1px solid black;'></div>";
  if(!getContentWorks($donnees['url']))
  {
    updateJaquette($donnees['id'], $bdd);
    continue;
  }
  $html = file_get_html($donnees['url']);

  if($html->find('#gbBlocResume .jaquette a.noPopupJeu', 0))
    $test = $html->find('#gbBlocResume .jaquette a.noPopupJeu', 0);
  else
  {
    echo $donnees['url'];
    continue;
  }

  $test = $test->getAttribute("href");

  $test = "http://www.gameblog.fr".$test;

  if(!getContentWorks($test))
  {
    updateJaquette($donnees['id'], $bdd);
    continue;
  }

  $html = file_get_html($test);
  $lienImg = $html->find("#gbJeuJaquette a.clearfix", 0);
  if(empty($lienImg))
  {
    updateJaquette($donnees['id'], $bdd);
    continue;
  }
  $lienImg = $lienImg->getAttribute("href");

  $lienImg = "http://www.gameblog.fr".$lienImg;


  if(!getContentWorks($lienImg))
  {
    updateJaquette($donnees['id'], $bdd);
    continue;
  }
  $html = file_get_html($lienImg);
  $src = $html->find("#gbImg", 0)->getAttribute("src");
  $src = "http://www.gameblog.fr". $src;

  echo "<b>Src : </b>".$src.'<br>';

  $queryVerifLien = $bdd->prepare("SELECT COUNT(*) AS nbr FROM URL_Gameblog WHERE url = :url AND done_jaquette = 0"); // On vérifie qu'il n'est pas présent dans la base de données
  $queryVerifLien->bindValue(":url", $src, PDO::PARAM_STR);
  $queryVerifLien->execute();
  $req  = $queryVerifLien->fetch(PDO::FETCH_ASSOC);
  if($req['nbr']==0)
  {
    $queryInsertLien = $bdd->prepare("INSERT INTO URL_Gameblog (url, crawl_type, done, done_tri, done_jaquette) VALUES (:url, :crawl_type, :done, :done_tri, :done_jaquettes)");
    $queryInsertLien->bindValue(":url", $src, PDO::PARAM_STR);
    $queryInsertLien->bindValue(":crawl_type", 4, PDO::PARAM_INT);
    $queryInsertLien->bindValue(":done", 1, PDO::PARAM_INT);
    $queryInsertLien->bindValue(":done_tri", 1, PDO::PARAM_INT);
    $queryInsertLien->bindValue(":done_jaquettes", 1, PDO::PARAM_INT);
    $queryInsertLien->execute();
    if(!scriptGetJaquette($lienImg, $bdd, $src, $donnees['id']))
    {
      continue;
    }
    echo "<h2>Url crawled : ". $donnees['url'].'</h2><b>Lien de l\'image : </b> : '.$src.'<br>' ;
    echo "<img style=\"width : 200px;\" src='". $src."'><br><br>";
  }
  else
  {
    $querySelectLien = $bdd->prepare("SELECT * FROM URL_Gameblog WHERE url = :url AND done_jaquette = 0 LIMIT 1");
    $querySelectLien->bindValue(":url", $src, PDO::PARAM_STR);
    $querySelectLien->execute();
    $result = $querySelectLien->fetch();

    $queryUpdateLien = $bdd->prepare("UPDATE URL_Gameblog SET done_jaquette = 1, crawl_type = 4 WHERE id = :id");
    $queryUpdateLien->bindValue(":id", $result['id'], PDO::PARAM_INT);
    $queryUpdateLien->execute();

    scriptGetJaquette($lienImg, $bdd, $src, $donnees['id']);
  }

  updateJaquette($donnees['id'], $bdd);

}









$currentUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
?>
<p>Ajout des Jaquettes fini</p>

<?php

redirectPage($currentUrl);

?>
