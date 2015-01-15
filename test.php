<?php
include('./plugins/simple_html_dom.php');
include('./views/include/cnx.php');




// Retrieve the DOM from a given URL
$html = file_get_html('http://www.jeuxvideo.com/articles/0002/00020009-terra-battle-test.htm#infos');
$dom = new DOMDocument;
libxml_use_internal_errors(true);
$dom->loadHTML($html);
libxml_clear_errors();
# create a new DOMXPath object
$xp = new DOMXPath($dom);

function isQuoteBalise($html, $testValue)
{
  foreach($html->find('article#test_txt p.test_encart q') as $quote)
  {

    if($quote->innertext == $testValue)
    {
      return true;
    }

  }
  return false;
}
?>



  <?php

  foreach($html->find('article .titre-alltype-article') as $e) //Trouve tous les <b> dans les <td id="nom_jeu">
  $titreJeu = $e->innertext; //Titre du jeu

  // $consoles = Array();                                              // Consoles possibles
  // $altValue = $html->find('td#nom_mc img', 0)->getAttribute('alt');
  // for($i = 0; $i < count($html->find('li a img')); $i++)
  // {
  //
  //   $altValue = $html->find('li a img', $i)->getAttribute('alt');
  //   if (preg_match("/".$titreJeu." - [a-zA-Z0-9_]+/", $altValue))
  //   {
  //     $consoles[] = $altValue;
  //   }
  // }


  //Petite description du jeu, debut du test
  $chapo = $html->find('.intro-article', 0);
  $chapo =  $chapo->innertext;

  //Article
  # search for all h2 elements and all p elements that do not have the class 'one_class'
  $interest = $xp->query('//h2 | //p[not(@class="test_encart")]');

  # iterate through the array of search results (h2 and p elements), printing out node
  # names and values
  $contentArticleHTML = '';




  //
  // $query = $bdd->prepare('INSERT INTO Pictures_test (alt) VALUES(:alt)');
  // $query->bindValue(':alt', $alt, PDO::PARAM_STR);
  // $query->execute();
  // $query->CloseCursor();
  // $lastid = $bdd->lastinsertid();
  // $nom_photo = $lastid;
  //
  // $upload = file_put_contents("./assets/img/img-bdd/".$nom_photo.".jpg",file_get_contents($image));
  // $contentArticleHTML .= "<div class='img-block-test floatright'>
  // <img class='imgleft' src='./assets/img/Edward.jpg' >
  // <q> Edward est un héros charismatique. </q>
  // </div>
  // <h2>". $i->nodeValue ."</h2>";




  foreach ($interest as $i) {
    if($i->nodeValue == "Si rien ne s'affiche après plusieurs secondes d'attente :")
    {
      break;
    }



    if($i->nodeValue != "")
    {
      $isQuoteValue = isQuoteBalise($html, $i->nodeValue);
      if($isQuoteValue == false)
      {
        if($i->nodeName == "h2")
        {


          $contentArticleHTML .= " MSGZ98A7Z6
          <h2>". $i->nodeValue ."</h2>";
        }
        if($i->nodeName == "p")
        {
          $contentArticleHTML .= "<p>". $i->nodeValue ."</p>";
        }
      }
    }
  }
  $div_img = $html->find('.encart-article');

  $position_leftright = 1;
  foreach($div_img as $div)
  {
      $quote = $div->find('figcaption', 0);
      $img = $div->find('img', 0);

        $errormsg = "MSGZ98A7Z6";
        $alt = $img->getAttribute('alt');
        $src = $img->getAttribute('src');
        $src = "http:".$src;
        $query = $bdd->prepare('INSERT INTO Pictures_test (alt) VALUES(:alt)');
        $query->bindValue(':alt', $alt, PDO::PARAM_STR);
        $query->execute();
        $query->CloseCursor();
        $lastid = $bdd->lastinsertid();
        $nom_photo = $lastid;

        $upload = file_put_contents("./assets/img/img-bdd/".$nom_photo.".jpg",file_get_contents($src));

        if($position_leftright == 1)
        {
          $codeImg = "<div class='img-block-test floatright'>
          <img class='imgleft' src='./assets/img/img-bdd/". $nom_photo .".jpg' >
          <q> ".$quote->plaintext." </q>
          </div>";
          $position_leftright = 0;
        }
        else
        {
          $codeImg = "<div class='img-block-test floatleft'>
          <img class='imgleft' src='./assets/img/img-bdd/". $nom_photo .".jpg' >
          <q> ".$quote->plaintext." </q>
          </div>";
          $position_leftright = 1;
        }

        $pos = strpos($contentArticleHTML,$errormsg);
        if ($pos !== false) {
          $contentArticleHTML = substr_replace($contentArticleHTML,$codeImg ,$pos,strlen($errormsg));
        }

  }



  $note = $html->find(".note strong", 0);

  $notejvc = $note->plaintext;




  $avis_auteur = $html->find(".bloc-avis-testeur", 0);

  $avis_de = $avis_auteur->find(".auteur span", 0);
  $avis_de = $avis_de->plaintext;

  $statut = $avis_auteur->find(".statut", 0);
  $statut = $statut->plaintext;

  $resume = $html->find(".bloc-critique .resume-critique ", 0);
  $resume = $resume->plaintext;

  $positive_ul = '<ul class="positive">';
  $negative_ul = '<ul class="negative">';

  $positive_script = $html->find(".col-md-6", 0);
  $positive_comments = $positive_script->find(".liste-argument li");
  foreach($positive_comments as $e)
  {
    $positive_ul .= "<li><span class='li-position'>".$e->innertext."</span></li>";
  }
  $positive_ul .= '</ul>';

  $negative_script = $html->find(".col-md-6", 1);
  $negative_comments = $negative_script->find(".liste-argument li");
  foreach($negative_comments as $e)
  {
    $negative_ul .= "<li><span class='li-position'>".$e->innertext."</span></li>";
  }
  $negative_ul .= '</ul>';

  // <ul class="positive">
  //
  // <li><span class="li-position">Un univers extrêmement riche</span></li>
  // <li><span class="li-position">On se prend vraiment pour un pirate</span></li>
  // <li><span class="li-position">Map très vaste</span></li>
  // <li><span class="li-position">Beaucoup d'activités possibles</span></li>
  // <li><span class="li-position">La liberté offerte au joueur</span></li>
  // <li><span class="li-position">Bonne durée de vie (comptez une vingtaine d'heures en ligne droite et plus du double pour tout faire)</span></li>
  // </ul>
  // <ul class="negative">
  // <li><span class="li-position">Missions répétitives et pas très inspirées</span></li>
  // <li><span class="li-position">Pas mal de clipping, encore</span></li>
  // <li><span class="li-position">IA plus que perfectible</span></li>
  // <li><span class="li-position">Système de free run peu pratique sur les bateaux</span></li>
  // <li><span class="li-position">Scénario anecdotique</span></li>
  // <li><span class="li-position">Animations douteuses</span></li>
  // <li><span class="li-position">Des phases dans le présent sans intérêt</span></li>
  // </ul>




$titreJeu = htmlspecialchars($titreJeu);
?>


<!DOCTYPE html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title> GamerZ </title>
  <link rel="stylesheet" media="screen" type="text/css" href="./assets/css/styles.css">
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script type="text/javascript" src=" ./assets/js/jquery.autocomplete.min.js"></script>
  <script type="text/javascript" src=" ./assets/js/search.js"></script>
  <script type="text/javascript" src=" ./assets/js/AjaxPageGame.js"></script>
  <link rel="stylesheet" media="screen" type="text/css" href="./assets/css/stylesGamePageLi.css">
  <link rel="stylesheet" media="screen" type="text/css" href="./assets/css/jquery.bxslider.css">
  <script type="text/javascript" src="./assets/js/jssor/jssor.js"></script>
  <script type="text/javascript" src="./assets/js/jssor/jssor.slider.js"></script>
  <script type="text/javascript" src="./assets/js/jssor_param.js"></script>
</head>


<body>
  <div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
  </script>

  <div id="header">
    <div id="content_header">
      <div id="connection"> <img src=" ./assets/img/connection.png"> </div>
      <div id="top_barre">
        <div id="logo"> <a href="./"><img src=" ./assets/img/gamerz.png"></a> </div>
        <div id="space_1"> </div>
        <div id="search_">
          <form class="form-wrapper" method="post">
            <div class="btn-left-loupe"></div>
            <input class="search_data" name="saisie" type="text" id="search" placeholder="Mots-Clefs..." />
            <button type="submit">Search</button>
          </form>
        </div>
        <div id="menu">
          <ul>
            <li>
              <a href="#">Discovers</a>
            </li>
          </ul>
          <div id="space_3"> </div>
          <ul>
            <li>
              <a href="#">Plateforms</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>


  <div id="corps-game">
    <div id="corps-game-block-left">
      <img src=" ./assets/img/assasins.png" class="corps-game-img">
      <div id="content-block-left">
        <div id="block-left-block-title">
          <h1> Assassin's Creed IV - Black Flag </h1>
          <p class="liste-consoles"><strong>Consoles :</strong> PC, PS4, PS3, Xbox One, Xbox 360, Wii, Wii U, Nintendo 3DS</p> <br>
          <p class="note-block-title"> Note : 18/20</p>
        </div>
      </div>

    </div>
    <div id="corps-game-block-right">
      <div id="AjaxContent">
        <ul id="onglets">
          <li class="actif"><img src="./assets/img/description-menu.png">Description <span class="border-menu">|</span></li>
          <li><img src="./assets/img/actualites-menu.png">Actualités </a><span class="border-menu">|</span></li>
          <li><img src="./assets/img/test-menu.png">Tests </a><span class="border-menu">|</span></li>
          <li><img src="./assets/img/image-menu.png"> Images </a><span class="border-menu">|</span></li>
          <li><img src="./assets/img/avis-menu.png"> Avis </a> <span class="border-menu">|</span></li>
          <li class="buy-menu"><img src="./assets/img/acheter-menu.png"> Acheter </a></li>
        </ul>

        <div id="Ajax">

          <div class="item">
            <?php include('./views/ContentAjax/description.php'); ?>
          </div>

          <div class="item">
            <?php include('./views/ContentAjax/actualites.php'); ?>
          </div>

          <div class="item">

            <div id="game-content">



              <div id="test-selected">
                <div id="test-selected-left">
                  <div class="header-test-selected">
                    <img src="./assets/img/jeuxvideocomlogo.png" alt="Logo jeuxvideo.com">
                    <h1 class="h1-header-test-selected"><?php echo $titreJeu;?></h1>
                  </div>

                  <div id="content-test-selected">
                    <p class="chapo"><?php echo $chapo ;?> </p>
                    <!-- <div class="img-block-test floatright">
                      <img class="imgleft" src="./assets/img/Edward.jpg" >
                      <q> Edward est un héros charismatique. </q>
                    </div> -->

                    <!-- <div class="img-block-test floatleft">
                      <img class="imgleft" src="./assets/img/balaine.jpg" >
                      <q> Edward est un héros charismatique. </q>
                    </div> -->
                    <?php
                      echo $contentArticleHTML;
                    ?>

                  </div>

                </div>
                <div id="test-selected-right">
                  <p class="title-review"><b> <?php echo $avis_de; ?> </b>- <?php echo $statut; ?></p>
                  <div class="test-selected-note">
                    <span class="note-actu"><?php echo $notejvc; ?></span>
                    <span class="note-max"> / 20 </span>
                  </div>
                  <p class="test-selected-review"><?php echo $resume;?></p>
                  <div id="positive-negative">
                    <h3> Les plus </h3>
                    <?php echo $positive_ul;?>
                    <h3> Les moins </h3>
                    <?php echo $negative_ul;?>

                  </div>

                </div>

              </div>
            </div>
          </div>

          <div class="item">
            <?php include('./views/ContentAjax/images.php'); ?>
          </div>

          <div class="item">
            <?php include('./views/ContentAjax/avis.php'); ?>
          </div>

          <div class="item">
            <?php include('./views/ContentAjax/acheter.php'); ?>
          </div>
        </div>
      </div>

    </div>


  </div>




</div>


</body>
