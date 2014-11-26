<?php

include('../plugins/simple_html_dom.php');
include('../views/include/cnx.php');
 $type = 0;
 // (0:Undefined, 1:URL, 2: Test, 3: Images, 4: Jacquette, 5:Other)

$query = $bdd->prepare("SELECT * FROM URL_Gameblog WHERE done = 0 LIMIT 0,2");
$query->execute();
while($donnees = $query->fetch())
{
  $url = $donnes['url'];
  $html = file_get_html($url);
  foreach($html->find('a') as $a)
  {
    $href = $a->getAttribute("href");
    if(preg_match("#^http:\/\/www.gameblog.fr#", $href))
    {
      echo "Type 1 :". $href ."<br>";
    }
    else if(preg_match("#^www.gameblog.fr#", $href))
    {
      $href =  "http://".$href ;
      echo  "Type 2 :". $href;
    }
    else if(preg_match("#^http:\/\/#", $href) OR preg_match("#^https:\/\/#", $href) )
    {
      echo "Type 3 : <br>". $href ."<br>";
      $type = 5;
    }
    else
    {

      $href = "http://www.gameblog.fr".$href;
      echo "Type 4 :".$href ."<br>";
    }

    if($type != 5)
    {
      $anchor = $a->plaintext;
      $queryVerif = $bdd->prepare("SELECT COUNT(*) AS nbr FROM URL_Gameblog WHERE url = :url");
      $queryVerif->bindValue(":url", $href, PDO::PARAM_STR);
      $queryVerif->execute();
      $req  = $queryVerif->fetch(PDO::FETCH_ASSOC);

      if($req['nbr']==0)
      {
        $queryInsert = $bdd->prepare("INSERT INTO URL_Gameblog (url, crawl_type, anchor) VALUES(:url, :type, :anchor)");
        $queryInsert->bindValue(":url", $href, PDO::PARAM_STR);
        $queryInsert->bindValue(":type", 1, PDO::PARAM_INT);
        $queryInsert->bindValue(":anchor", $anchor, PDO::PARAM_STR);
        $queryInsert->execute();
        echo "Done.<br><br>";
      }

    }
    $type = 0;
    // if (preg_match("#^http:\/\/www.jeuxvideo.com\/articles\/#", $href))
    // {
    //   if(preg_match("#^((?!/listes/tests-).)*$#", $href))
    //   {
    //
    //
    //
    //
    //   }
    // }

  }
   $queryUpdate = $bdd->prepare("UPDATE URL_Gameblog SET done = 1 WHERE id = :id");
   $queryUpdate->bindValue(":id", $donnees['id'], PDO::PARAM_INT);
   $queryUpdate->execute();


  $currentUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

}
?>
<p>Ajout des urls pour Gameblog fini</p>
<script LANGUAGE="JavaScript">
document.location.href="<?php echo $currentUrl; ?>"
</script>
