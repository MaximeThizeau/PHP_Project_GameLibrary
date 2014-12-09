<?php
set_time_limit(0);
include('../plugins/simple_html_dom.php');
include('../views/include/cnx.php');
include('../models/script-functions.php');
 $type = 0;
 // (0:Undefined, 1:URL, 2: Test, 3: Images, 4: Jaquette, 5:Other)

$query = $bdd->prepare("SELECT * FROM URL_Gameblog WHERE done_tri = 0 LIMIT 5000");
$query->execute();
while($donnees = $query->fetch())
{
  echo "<h2>Url crawled : ". $donnees['url'].'</h2>' ;
  $url = $donnees['url'];
  if (preg_match("#\/images\/#", $url)  && preg_match("#Jaquette#", $url))
  {
    echo "C'est une jaquette ! <br>";
    $queryUpdate = $bdd->prepare("UPDATE URL_Gameblog SET crawl_type = 3 WHERE id = :id");
    $queryUpdate->bindValue(":id", $donnees['id'], PDO::PARAM_INT);
    $queryUpdate->execute();
  }

  if (preg_match("#http:\/\/www\.gameblog\.fr\/tests\/#", $url) )
  {
    echo "C'est un test ! <br>";
    $queryUpdate = $bdd->prepare("UPDATE URL_Gameblog SET crawl_type = 2 WHERE id = :id");
    $queryUpdate->bindValue(":id", $donnees['id'], PDO::PARAM_INT);
    $queryUpdate->execute();
  }




   $queryUpdate = $bdd->prepare("UPDATE URL_Gameblog SET done_tri = 1 WHERE id = :id");
   $queryUpdate->bindValue(":id", $donnees['id'], PDO::PARAM_INT);
   $queryUpdate->execute();

}




$currentUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
?>
<p>Tri des URLs pour Gameblog fini</p>

<?php

redirectPage($currentUrl);

?>
