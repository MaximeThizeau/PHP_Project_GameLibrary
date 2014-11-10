<?php

include('../plugins/simple_html_dom.php');

try
{
	$bdd = new PDO('mysql:host=localhost;dbname=php_project', 'root', 'root');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}



$query = $bdd->prepare("SELECT * FROM Url WHERE Gamesite_id = 1 AND crawl_type = 1 AND done = 0 LIMIT 0,2");
$query->execute();
while($donnees = $query->fetch())
{
	$html = file_get_html($donnees['url']);
	foreach($html->find('a') as $a)
	{
		$href = $a->getAttribute("href");
		if (preg_match("#^http:\/\/www.jeuxvideo.com\/articles\/#", $href)) 	
		{
			if(preg_match("#^((?!/listes/tests-).)*$#", $href))
			{
				$queryVerif = $bdd->prepare("SELECT COUNT(*) AS nbr FROM Url WHERE Gamesite_id = 1 AND url = :url");
				$queryVerif->bindValue(":url", $href, PDO::PARAM_STR);
				$queryVerif->execute();
				$req  = $queryVerif->fetch(PDO::FETCH_ASSOC);

				if($req['nbr']==0) 
				{
					$queryInsert = $bdd->prepare("INSERT INTO Url (url, crawl_type, Gamesite_id) VALUES(:url, :type, :gamesite_id)");
					$queryInsert->bindValue(":url", $href, PDO::PARAM_STR);
					$queryInsert->bindValue(":type", 0, PDO::PARAM_INT);	
					$queryInsert->bindValue(":gamesite_id", 1, PDO::PARAM_INT);		
					$queryInsert->execute();	
				}
			}
		}
						
	}
	$queryUpdate = $bdd->prepare("UPDATE Url SET done = 1 WHERE id = :id");
	$queryUpdate->bindValue(":id", $donnees['id'], PDO::PARAM_INT);
	$queryUpdate->execute();
	
	 
	$currentUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 

}
?>
<p>Ajout des urls fini <?php echo $donnees['id'];?></p>
<script LANGUAGE="JavaScript"> 
document.location.href="<?php echo $currentUrl; ?>" 
</script> 