<?php
set_time_limit(0);
include('../plugins/simple_html_dom.php');
include('../views/include/cnx.php');
$type = 0;
// (0:Undefined, 1:URL, 2: Test, 3: Images, 4: Jacquette, 5:Other)
function updateUrl($id, $bdd)
{
  $queryUpdate = $bdd->prepare("UPDATE Url SET done = 1 WHERE id = :id");
  $queryUpdate->bindValue(":id", $id, PDO::PARAM_INT);
  $queryUpdate->execute();
}

$query = $bdd->prepare("SELECT * FROM Url WHERE done = 0 AND Gamesite_id = 1 LIMIT 150");
$query->execute();
while($donnees = $query->fetch())
{

  $url = $donnees['url'];



  if (file_get_html($url) === false OR file_get_contents($url) === false)
  {
    // updateUrl($donnees['id'], $bdd);
    continue;
  }

  echo "<h2>Url crawled : ". $donnees['url'].'</h2>' ;
  $html = file_get_html($url);
  foreach($html->find('a') as $a)
  {
    $href = $a->getAttribute("href");
    if(preg_match("#\/\/image\.jeuxvideo#", $href))
    {
      echo "Type 1 :". $href ."<br>";
      $type = 0;
      continue;
    }
    else if(preg_match("#^http\:\/\/www\.jeuxvideo\.com#", $href))
    {
      echo "Type 3 :". $href ."<br>";
    }
    else if(preg_match("#^http:\/\/#", $href) OR preg_match("#^https:\/\/#", $href))
    {
      echo "Type 4 :". $href ."<br>";
      $type = 5;
    }
    else
    {
      $href = "http://www.jeuxvideo.com". $href;
      echo "Type 4 :". $href."<br>";

    }


    if($type != 5)
    {
      $anchor = $a->plaintext;
      $queryVerif = $bdd->prepare("SELECT COUNT(*) AS nbr FROM Url WHERE url = :url");
      $queryVerif->bindValue(":url", $href, PDO::PARAM_STR);
      $queryVerif->execute();
      $req  = $queryVerif->fetch(PDO::FETCH_ASSOC);

      if($req['nbr']==0)
      {
        $queryInsert = $bdd->prepare("INSERT INTO Url (url, crawl_type, anchor, Gamesite_id) VALUES(:url, :type, :anchor, 1)");
        $queryInsert->bindValue(":url", $href, PDO::PARAM_STR);
        $queryInsert->bindValue(":type", 1, PDO::PARAM_INT);
        $queryInsert->bindValue(":anchor", $anchor, PDO::PARAM_STR);
        $queryInsert->execute();
        echo "Done.<br><br>";
      }

    }


    $type = 0;
  }

  $type = 0;
  updateUrl($donnees['id'], $bdd);

}
$currentUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
?>
<p>Ajout des urls pour Jeuxvideo.com fini</p>

<SCRIPT LANGUAGE="JavaScript">
  document.location.href="<?php echo $currentUrl; ?>"
</SCRIPT>
