<!DOCTYPE html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title> GamerZ </title>
  <link rel="stylesheet" media="screen" type="text/css" href="../assets/css/styles.css">
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script type="text/javascript" src=" ../assets/js/jquery.autocomplete.min.js"></script>
  <script type="text/javascript" src=" ../assets/js/search.js"></script>
  <script type="text/javascript" src=" ../assets/js/AjaxPageGame.js"></script>
  <link rel="stylesheet" media="screen" type="text/css" href="../assets/css/stylesGamePageLi.css">
  <link rel="stylesheet" media="screen" type="text/css" href="../assets/css/jquery.bxslider.css">
  <link rel="stylesheet" media="screen" type="text/css" href="../assets/css/commentaire.css">
  <script type="text/javascript" src="../assets/js/scriptAvis.js"></script>
  <script type="text/javascript" src="../assets/js/resise.js"></script>
  <link rel="stylesheet" href="../assets/css/slider.css">
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
      <div id="connection"> <img src=" ../assets/img/connection.png"> </div>
      <div id="top_barre">
        <div id="logo"> <a href="../"><img src=" ../assets/img/gamerz.png"></a> </div>
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
      <h1 id="h1"> Assassin's Creed IV - Black Flag </h1>
      <img src=" ../assets/img/jaquettes/<?php echo $this->data['jaquette'] ;?>" class="corps-game-img">
      <input type="image" value="agrandir"  id="buttonGrow" src="../assets/img/shrink.png"/>
      <input type="image" value="retrecir" id="buttonShrink" src="../assets/img/grow.png" />
      <div id="content-block-left">
        <div id="block-left-block-title">

          <h1> <?php echo $this->data['game']['name']; ?> </h1>
          <p class="liste-consoles"><strong>Consoles :</strong> PC, PS4, PS3, Xbox One, Xbox 360, Wii, Wii U, Nintendo 3DS</p> <br>
          <?php echo $this->data['jaquette'] ;?>
          <p class="note-block-title"> Note : 18/20</p>
        </div>
      </div>

    </div>
    <div id="corps-game-block-right">
      <?php include('include/gameLI.php'); ?>
    </div>


  </div>




</div>
<script type="text/javascript" src="../assets/js/scripts/WallopSlider.js"></script>
<script type="text/javascript" src="../assets/js/scripts/script.js"></script>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-45410808-1', 'pedroduarte.me');
ga('send', 'pageview');

</script>

</body>
