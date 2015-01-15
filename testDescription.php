<?php
include('plugins/simple_html_dom.php');
include('views/include/cnx.php');
include('models/script-functions.php');
?>

<?php
  $query = $bdd->prepare("SELECT * FROM Descriptions");
  $query->execute();
  while($donnees = $query->fetch())
  {
    echo '<b>ID :</b> '. $donnees['id'] . '<br><b>Text</b> : '. $donnees['text'] . "<br><br>";
  }
?>
