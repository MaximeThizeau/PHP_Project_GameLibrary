<?php
set_time_limit(0);
include('../plugins/simple_html_dom.php');
include('../views/include/cnx.php');
include('../models/script-functions.php');

$genreArray = Array(); // Tableau qui contiendra les genres du Jeu
$consoleArray = Array(); // Tableau qui contiendra les consoles du Jeu
$developpeurArray = Array(); // Tableau qui contiendra les developpeurs du Jeu

$currentUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; // Url courante, on s'en servira pour reload la page a la fin du script.

function updateUrlDoneGame($id, $bdd) // Fonction qui met à jour l'Url en bdd, en passant "done_game" à True, ce qui veut dire qu'on s'est occupé de récuperrer le jeu pour cette Url
{
  $queryUpdate = $bdd->prepare("UPDATE Url SET done_game = 1 WHERE id = :id");
  $queryUpdate->bindValue(":id", $id, PDO::PARAM_INT);
  $queryUpdate->execute();
}

function clean($string) {
  $string = str_replace(' :', ':', $string); // Replaces all spaces with hyphens.
  $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.
  $string = str_replace('&#039;', '%27', $string); // Replaces all spaces with hyphens.
  $string = strtr($string, 'ÁÀÂÄÃÅÇÉÈÊËÍÏÎÌÑÓÒÔÖÕÚÙÛÜÝ', 'AAAAAACEEEEEIIIINOOOOOUUUUY');
  $string = strtr($string, 'áàâäãåçéèêëíìîïñóòôöõúùûüýÿ', 'aaaaaaceeeeiiiinooooouuuuyy');
  return $string; // Removes special chars.
}
?>

<?php
$query = $bdd->prepare("SELECT * FROM Url WHERE Gamesite_id = 1 && crawl_type = 6 && done_game = 0  LIMIT 50");
$query->execute();

while($donnees = $query->fetch())
{

  // S'il y a un problème avec l'URL que l'on crawl, on passe à la suivante et on met à jour en disant qu'on la faîte.
  if (file_get_html($donnees['url']) == false OR file_get_contents($donnees['url']) == false){
    continue;
  }



  echo "<h2>Url crawled : ". $donnees['url'].'</h2>' ;

  // On récupère le contenu de la page que l'on crawl.
  $html = file_get_html($donnees['url']);

  // On met dans une variable l'url pour que ce soit plus simple par la suite.
  $url = $donnees['url'];

  // On initialise le titre du jeu, pour savoir s'il y a eu un problème pour le récuperer par la suite.
  $titreJeu = '';

  // On récupère le titre du Jeu dans la page que l'on crawl.
  foreach($html->find('#bloc-meta-titre-jeu .table-meta .cell-meta .bloc-txt-meta .titre-meta') as $e){
    $titreJeu = $e->plaintext;
    echo "Titre du jeu : ". $titreJeu ."<br>";
  }

  // Si le titre du jeu est vide (qu'il y a eu un problème pour récuperer le titre du jeu), on passe au suivant.
  if($titreJeu == ''){
    echo "<h2> TitreJeu est vide </h2>";
    updateUrlDoneGame($donnees['id'], $bdd);
    continue;
  }

  // On va récuperer le genre du jeu, les developpeurs, les consoles, et autres informations importantes.
  foreach($html->find('.col-md-6 ul.list-first-info li') as $e){

    foreach($e->find("strong") as $strong)
    {
      $contentLi = explode("</strong>", $e->outertext);

      $contentLi = $contentLi[1];

      //On récupère les développeurs
      if($strong->plaintext == "Editeur(s) / Développeur(s) : "){
        echo "editeurs / developpeurs : ";

        foreach($e->find("span.JvCare") as $dev)
        {
          $developpeurArray[] =  $dev->plaintext;

        }
      }

      // On récupère la date de sortie.
      else if($strong->plaintext == "Sortie France : ")
      {
        echo "sortie : ". $contentLi ."<br>";
        $dateSortie = explode("<span", $contentLi);
        $dateSortie = $dateSortie[0];
      }
      // On récupère les genres
      else if($strong->plaintext == "Genre(s) :"){
        echo "Genres : ";

        foreach($e->find("span.JvCare") as $genre)
        {
          $genreArray[] =  $genre->plaintext;

        }
        echo "<br>";
      }
    }
  }

  // On enlève les caractères spéciaux du titre pour pouvoir le comparer à la base de données et obtenir un résultat correct (exemple "Assassin's Creed IV - Unity" et "Assassin's Creed IV : Unity")
  $titreJeuChar = remove_special_char($titreJeu);

  // Initialisation d'une variable booléen que l'on passera à vrai si l'on trouve le jeu dans la base de données
  $jeuDejaPresent = false;

  // Requete pour récuperer tous les jeux que l'on va comparer un a un au jeu que l'on veut ajouter.
  $queryGames = $bdd->prepare("SELECT * FROM Games");
  $queryGames->execute();
  while($donneesGames = $queryGames->fetch()){

    // On enlève les caractères spéciaux du nom du jeu qui est en bdd.
    $titreBdd = remove_special_char($donneesGames['name']);

    // Si le titre du jeu en bdd est vide, on passe au suivant.
    if($titreBdd == ''){
      continue;
    }

    // Si le jeu de la bdd est le même que celui que l'on veut ajouter, on arrête la boucle et on passe la variable à True
    if($titreJeuChar == $titreBdd){
      $jeuDejaPresent = true;
      break;
    }

  }

  $consoles = $html->find(".panel-jv-fiche .rappel-fiche .rappel-machine", 0);
  $consoles = $consoles->plaintext;
  $consoles = explode(" ", $consoles);



  echo "Consoles : ";
  foreach($consoles as $console){
    //1: Nintendo DS, 2: Nintendo 3DS, 3 : PlayStation 3, 4 : Playstation 4, 5 : Xbox 360, 6 : Xbox One, 7 : PC, 8 : Wii, 9 : Wii U, 10 : PlayStation Vita, 11 : PSP

    switch ($console) {
      case "ONE":
      $consoleArray[] = "Xbox One";
      break;
      case "PC":
      $consoleArray[] = "PC";
      break;
      case "PS4":
      $consoleArray[] = "PlayStation 4";
      break;
      case "WiiU":
      $consoleArray[] = "Wii U";
      break;
      case "Wii":
      $consoleArray[] = "Wii";
      break;
      case "PS3":
      $consoleArray[] = "PlayStation 3";
      break;
      case "360":
      $consoleArray[] = "Xbox 360";
      break;
      case "Vita":
      $consoleArray[] = "PlayStation Vita";
      break;
      case "3DS":
      $consoleArray[] = "Nintendo 3DS";
      break;
      case "DS":
      $consoleArray[] = "Nintendo DS";
      break;
      case "PSP":
      $consoleArray[] = "PSP";
      break;
      default:
      $consoleArray[] = $console;
    }

  }

  foreach($html->find(".bloc-onglet-machine a.onglet-machine") as $otherConsoles)
  {
    $esPresent = false;
    foreach($consoles as $theConsole)
    {
      if($theConsole = $otherConsoles)
      $estPresent = true;
    }
    if($estPresent != true)
    $consolesArray[] = $otherConsoles->plaintext;
  }


  foreach($consoleArray as $console)
  {
    echo $console.",";
  }
  echo "<br>dev : ";
  foreach($developpeurArray as $dev)
  {
    echo $dev.",";
  }
  // Si le jeu est déjà présent, alors on l'ajoute dans la bdd

  if($descriptionJVC = $html->find(".description span", 0))
  {
    $descriptionJVC = $descriptionJVC->plaintext;
    echo utf8_decode($descriptionJVC);
  }
  else
  {
    $descriptionJVC = NULL;
  }
  // $urlWikipedia =  "http://fr.wikipedia.org/wiki/".clean(trim($titreJeu, ' '));
  // if($htmlWiki  = file_get_html($urlWikipedia))
  // {
  //   $homonyme = $htmlWiki->find(".homonymie", 0);
  //
  //   $descriptionWiki = $htmlWiki->find("#mw-content-text", 0);
  //   echo "<br>". $descriptionWiki->plaintext;
  //   $descriptionWiki = str_replace($homonyme->outertext, "", $descriptionWiki);
  //
  //   $descriptionWiki = explode("<div id=\"toc\" class=\"toc\">", $descriptionWiki);
  //   echo "<br>".strip_tags($descriptionWiki[0])."<br>";
  //   if(strlen($descriptionJVC) < strlen($descriptionWiki)){
  //
  //   }

  // echo $urlWikipedia;
  // if($html->find(".noarticletext"))
  // {
  //   echo "pas d'articl pour l'url : ". $urlWikipedia;
  // }

  if(preg_match("#</li>#", $dateSortie))
    {
      $dateSortie = NULL;
    }

  if($jeuDejaPresent == false){

    $queryVerif = $bdd->prepare("SELECT COUNT(*) AS nbr FROM Games WHERE name = :name");
    $queryVerif->bindValue(":name", utf8_decode($titreJeu), PDO::PARAM_STR);
    $queryVerif->execute();
    $reqVerif  = $queryVerif->fetch(PDO::FETCH_ASSOC);

    if($reqVerif['nbr']==0)
    {



      // On insert le Jeu
      $queryInsertGame = $bdd->prepare("INSERT INTO Games (name, date_production, added_at) VALUES(:name, :date_production, NOW())");
      $queryInsertGame->bindValue(":name", utf8_decode($titreJeu), PDO::PARAM_STR);
      $queryInsertGame->bindValue(":date_production", utf8_decode($dateSortie), PDO::PARAM_STR);
      $queryInsertGame->execute();
      $game_id = $bdd->lastinsertid();


      $developer_id = 0;
      // On enregistre le développeur

      foreach($developpeurArray as $nameDevelopper)
      {
        $queryVerif = $bdd->prepare("SELECT COUNT(*) AS nbr FROM Developers WHERE name = :name");
        $queryVerif->bindValue(":name", utf8_decode($nameDevelopper), PDO::PARAM_STR);
        $queryVerif->execute();
        $req  = $queryVerif->fetch(PDO::FETCH_ASSOC);

        if($req['nbr']==0)
        {
          $queryInsertDeveloper = $bdd->prepare("INSERT INTO Developers (name) VALUES (:name)");
          $queryInsertDeveloper->bindValue(":name", utf8_decode($nameDevelopper), PDO::PARAM_STR);
          $queryInsertDeveloper->execute();
          $developer_id = $bdd->lastinsertid();
        }
        else
        {
          $querySelectDeveloper = $bdd->prepare("SELECT * FROM Developers WHERE name = :name");
          $querySelectDeveloper->bindValue(":name", utf8_decode($nameDevelopper), PDO::PARAM_STR);
          $querySelectDeveloper->execute();
          $developer_id = $querySelectDeveloper->fetch();
          $developer_id = $developer_id['id'];
        }

        $queryInsertAssociation = $bdd->prepare("INSERT INTO Association_Developers (developer_id, game_id) VALUES (:developer_id, :game_id)");
        $queryInsertAssociation->bindValue(":developer_id", $developer_id);
        $queryInsertAssociation->bindValue(":game_id", $game_id);
        $queryInsertAssociation->execute();
      }

      // On relie le jeu à ses platformes

      foreach($consoleArray as $consoleName)
      {
        if($consoleName == "")
          continue;

        $queryVerif = $bdd->prepare("SELECT COUNT(*) AS nbr FROM Platforms WHERE name = :name");
        $queryVerif->bindValue(":name", utf8_decode($consoleName), PDO::PARAM_STR);
        $queryVerif->execute();
        $req  = $queryVerif->fetch(PDO::FETCH_ASSOC);

        if($req['nbr']==0)
        {
          $queryInsertPlatform = $bdd->prepare("INSERT INTO Platforms (name) VALUES (:name)");
          $queryInsertPlatform->bindValue(":name", utf8_decode($consoleName), PDO::PARAM_STR);
          $queryInsertPlatform->execute();
          $platform_id = $bdd->lastinsertid();
        }
        else
        {
          $querySelectPlatform = $bdd->prepare("SELECT * FROM Platforms WHERE name = :name");
          $querySelectPlatform->bindValue(":name", utf8_decode($consoleName), PDO::PARAM_STR);
          $querySelectPlatform->execute();
          $platform_id = $querySelectPlatform->fetch();
          $platform_id = $platform_id['id'];
        }

        $queryInsertAssociation = $bdd->prepare("INSERT INTO Association_platforms (platform_id, game_id) VALUES (:platform_id, :game_id)");
        $queryInsertAssociation->bindValue(":platform_id", $platform_id);
        $queryInsertAssociation->bindValue(":game_id", $game_id);
        $queryInsertAssociation->execute();
      }

      // On met un nouveau genre en bdd si il n'ex
      foreach($genreArray as $categoryName)
      {
        $queryVerif = $bdd->prepare("SELECT COUNT(*) AS nbr FROM Categories WHERE name = :name");
        $queryVerif->bindValue(":name", utf8_decode($categoryName), PDO::PARAM_STR);
        $queryVerif->execute();
        $req  = $queryVerif->fetch(PDO::FETCH_ASSOC);

        if($req['nbr']==0)
        {
          $queryInsertCategory = $bdd->prepare("INSERT INTO Categories (name) VALUES (:name)");
          $queryInsertCategory->bindValue(":name", utf8_decode($categoryName), PDO::PARAM_STR);
          $queryInsertCategory->execute();
          $category_id = $bdd->lastInsertId();
        }
        else
        {
          $querySelectCategory = $bdd->prepare("SELECT * FROM Categories WHERE name = :name");
          $querySelectCategory->bindValue(":name", utf8_decode($categoryName), PDO::PARAM_STR);
          $querySelectCategory->execute();
          $category_id = $querySelectCategory->fetch();
          $category_id = $category_id['id'];
        }

        $queryInsertAssociation = $bdd->prepare("INSERT INTO Association_Category (category_id, game_id) VALUES (:categorie_id, :game_id)");
        $queryInsertAssociation->bindValue(":categorie_id", $category_id);
        $queryInsertAssociation->bindValue(":game_id", $game_id);
        $queryInsertAssociation->execute();

      }



      // On enregistre la description
      if($descriptionJVC != NULL)
      {
        $queryDescription = $bdd->prepare("INSERT INTO Descriptions (game_id, text, gamesite_id) VALUES (:game_id, :text, 1)");
        $queryDescription->bindValue(":game_id", $game_id);
        $queryDescription->bindValue(":text", utf8_decode($descriptionJVC), PDO::PARAM_STR);
        $queryDescription->execute();



      }

      echo "<br><b>On ajoute ce jeu en BDD : </b> ".$titreJeu."<br>";
    }


  }


  updateUrlDoneGame($donnees['id'], $bdd);

  $consoleArray = Array();
  $genreArray = Array();
  $developpeurArray = Array();

}
?>
<p>Ajout des jeux videos fini</p>

<?php
  redirectPage($currentUrl);
?>
