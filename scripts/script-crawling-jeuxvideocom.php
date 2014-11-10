<?php
include('../plugins/simple_html_dom.php');



 
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

<!DOCTYPE html>

<html>

  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf8">
    <title></title>
  </head>

  <body>
  

<?php

foreach($html->find('td#nom_jeu h1 b') as $e) //Trouve tous les <b> dans les <td id="nom_jeu"> 
    $titreJeu = $e->innertext;
    
    echo "<b>Titre du jeu:</b> <br> ".$titreJeu . '<br><br><br>';
    
	
	echo "<b>Plateformes : </b><br>";
	$altValue = $html->find('td#nom_mc img', 0)->getAttribute('alt');
	echo $altValue .'<br>';
	
	
	for($i = 0; $i < count($html->find('li a img')); $i++)
	{
		
		$altValue = $html->find('li a img', $i)->getAttribute('alt');
		if (preg_match("/".$titreJeu." - [a-zA-Z0-9_]+/", $altValue)) 
		{
			echo $altValue." <br />";
		}
	}
	
	
	//Petite description du jeu, debut du test
	
	echo "<br><br><br><b>Description :</b> <br>";
	
	$chapo = $html->find('p#chapo', 0);
	echo $chapo->innertext;
	
	
	echo "<br><br><br><b>Article :</b> ";
	
	# search for all h2 elements and all p elements that do not have the class 'one_class'
$interest = $xp->query('//h2 | //p[not(@class="test_encart")]');

# iterate through the array of search results (h2 and p elements), printing out node
# names and values
foreach ($interest as $i) {
	if(utf8_decode($i->nodeValue) == "Si rien ne s'affiche après plusieurs secondes d'attente :")
	{
		break;
	}
	
	
	if($i->nodeValue != "")
	{
		$isQuoteValue = isQuoteBalise($html, $i->nodeValue);
		if($isQuoteValue == false)
		{
    		echo "<".$i->nodeName.">". $i->nodeValue . PHP_EOL ."</".$i->nodeName."><br><br>";
    	}
    }
}


$note = $xp->query('//ul/li/div[@itemprop="rating"]/strong');

foreach($note as $n)
{
	echo "Note jeuxvideo.c". $n->nodeValue;
}
















	/*


	$nombreBaliseP = 0;
	foreach($html->find('article#test_txt p') as $baliseP)
	{

		$balisePIsTestEncart = balisePIsTestEncart($html, $baliseP);
		
		
		if($baliseP != $chapo && $baliseP != $html->find('p#logo', 0)  && $baliseP != $html->find('p#chapo_img', 0) && $balisePIsTestEncart == false)
		{	
			if(utf8_decode($baliseP->plaintext) == "Si rien ne s'affiche après plusieurs secondes d'attente :")
			{
	          	break;
	        }
          
	        foreach($html->find('article#test_txt a') as $href)
	        {
          		$img = $html->find('article#test_txt a img', 0);
          		if(isset($img))
          		{
          			$href->outertext = "";
          		}
          	}    
          
          	foreach($html->find('p q') as $quote)
          	{
               	$quote->outertext = '' ;
            }

            	echo $baliseP->outertext;
            	$h2 = $html->find("article#test_txt h2", $nombreBaliseP);
            	echo $h2->outertext;
            	$nombreBaliseP++;  
         }
		
	}


*/



	




	
/*
	$nombreBaliseP = 0;
	$nombreTestEncart = 0;
	$boolTestEncart = false;
	foreach($html->find('p') as $baliseP)
     {
     	if($baliseP != $html->find('p.test_encart', $nombreTestEncart) && $baliseP != $chapo && $baliseP != $html->find('p#logo', 0)  && $baliseP != $html->find('p#chapo_img', 0))
     	{
     		$h2 = $html->find("article#test_txt h2", $nombreBaliseP);
     		echo $h2->outertext;
     		
     		
     		
          if(utf8_decode($baliseP->plaintext) == "Si rien ne s'affiche après plusieurs secondes d'attente :")
          {
	          break;
          }
          
          foreach($html->find('p img') as $img)
          {
               $img->outertext = '';
          }
          
          foreach($html->find('p q') as $quote)
          {
               $quote->outertext = '' ;
          }
          
          echo $baliseP->outertext;
          
          $nombreBaliseP++;
         }
        else
        {
        	if($baliseP == $html->find('p.test_encart', $nombreTestEncart))
        	{
	        	if($boolTestEncart == true)
	        	{
	       			$nombreTestEncart++;
	       			$boolTestEncart = false;
	       		}
	       		else
	       		{
		       		$boolTestEncart = true;
	       		}
	       	}
        }
        
     }
*/





	
	/*
foreach($html->find('h2') as $e)
	{
		echo $e->outertext .'<br>';
	}
*/
	
	
// Retrieve all images and print their SRCs
/*
foreach($html->find('img') as $e)
    echo $e->src . '<br>';

// Find all images, print their text with the "<>" included
foreach($html->find('img') as $e)
    echo $e->outertext . '<br>';

// Find the DIV tag with an id of "myId"


// Find all SPAN tags that have a class of "myClass"
foreach($html->find('p') as $e)
    echo "outertext : ".$e->outertext . '<br>';
*/


    
// Extract all text from a given cell

// Find all "A" tags and print their HREFs
//foreach($html->find('a') as $e) 
//    echo $e->href . '<br>';
?>

  </body>
</html>
