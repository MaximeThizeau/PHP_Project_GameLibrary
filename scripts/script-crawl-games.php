<?php
include('../plugins/simple_html_dom.php');
include('../views/include/cnx.php');
include('../models/script-functions.php');

$query = $bdd->prepare("SELECT * FROM Url WHERE Gamesite_id = 1 && crawl_type = 0 && done_game = 0 LIMIT 100");
$query->execute();

while($donnees = $query->fetch())
{
  if (file_get_html($donnees['url']) == false OR file_get_contents($donnees['url']) == false)
  {
    continue;
  }
  echo "<h2>Url crawled : ". $donnees['url'].'</h2>' ;
  // Retrieve the DOM from a given URL
  $html = file_get_html($donnees['url']);

  foreach($html->find('td#nom_jeu h1 b') as $e)
  {
    $titreJeu = utf8_decode($e->plaintext);
    echo "Titre du jeu : ". $titreJeu ."<br>";
  }




  $queryVerif = $bdd->prepare("SELECT COUNT(*) AS nbr FROM Games WHERE name = :name");
  $queryVerif->bindValue(":name", $titreJeu, PDO::PARAM_STR);
  $queryVerif->execute();
  $req  = $queryVerif->fetch(PDO::FETCH_ASSOC);

  if($req['nbr']==0)
  {
    $queryInsert = $bdd->prepare("INSERT INTO Games (name, added_at) VALUES(:name, NOW())");
    $queryInsert->bindValue(":name", $titreJeu, PDO::PARAM_STR);
    $queryInsert->execute();
    echo "Done.<br><br>";
  }
  $queryUpdate = $bdd->prepare("UPDATE Url SET done_game = 1 WHERE id = :id");
  $queryUpdate->bindValue(":id", $donnees['id'], PDO::PARAM_INT);
  $queryUpdate->execute();

}
$currentUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
?>
<p>Ajout des jeux videos fini</p>

<SCRIPT LANGUAGE="JavaScript">
document.location.href="<?php echo $currentUrl; ?>"
</SCRIPT>
