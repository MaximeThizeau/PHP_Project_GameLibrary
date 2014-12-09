<?php


function remove_special_char($str, $charset='utf-8')
{
    $str = htmlentities($str, ENT_NOQUOTES, $charset);

    $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
    $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
    $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères

    $str = str_replace(' ', '', $str); // Replaces all spaces with hyphens.

    $str = preg_replace('/[^A-Za-z0-9\-]/', '', $str); // Removes special chars.

    $str = str_replace('-', '', $str); // Replaces all spaces with hyphens.

    return strtolower($str);
}


function scriptGetJaquette($uneUrl, $bdd, $src, $urlID)
{
  $queryGames = $bdd->prepare("SELECT * FROM Games");
  $queryGames->execute();
  $html = file_get_html($uneUrl);

  foreach($html->find("h1.titre a.blanc") as $titre)
  {
    $titreJeu = $titre->plaintext;
  }

  echo $titreJeu;
  $titreJeu = explode(" - ", $titreJeu);

  $titreJeu = $titreJeu[0];
  echo "<br><b>Bon titre : </b> ".$titreJeu."<br>";
  $titreJeu = remove_special_char($titreJeu);
  echo "<b>TitreJeu : </b>".$titreJeu."<br>";
  if($titreJeu == '')
  {
    echo "<h2> TitreJeu est vide </h2>";
    updateJaquette($urlID, $bdd);
    return 0;
  }

  while($donneesGames = $queryGames->fetch())
  {
    $titreBdd = remove_special_char($donneesGames['name']);
    //  echo "**JEU**".$titreJeu .'<br>';
    //  echo "**BDD**".$titreBdd .'<br>';
    if($titreBdd == '')
    {
      updateJaquette($urlID, $bdd);;
      continue;
    }
    if($titreJeu == $titreBdd)
    {
      echo '<b>La jaquette a un jeu qui lui correspond.</b>';
      $queryVerif = $bdd->prepare("SELECT COUNT(*) AS nbr FROM Jaquettes WHERE game_id = :id");
      $queryVerif->bindValue(":id", $donneesGames['id'], PDO::PARAM_INT);
      $queryVerif->execute();
      $req  = $queryVerif->fetch(PDO::FETCH_ASSOC);

      if($req['nbr']==0)
      {
        enregistrerImage($donneesGames['id'], $titreJeu, $src, $bdd);
      }
    }
  }
}

function redirectPage($url)
{
  echo '<SCRIPT LANGUAGE="JavaScript">
  document.location.href="'. $url .'"
  </SCRIPT>';
}
