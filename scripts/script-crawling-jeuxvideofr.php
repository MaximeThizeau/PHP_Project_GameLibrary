<!DOCTYPE html>
<html lang="fr">
<head>
<title>Crawl JeuxVideo.fr</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" media="screen" type="text/css" href="css/styles.css">
<meta charset=utf-8 />
</head>

<?php 
include('../plugins/simple_html_dom.php');
$html = file_get_html('http://www.jeuxvideo.fr/jeux/assassin-s-creed-unity/preview-test-assassin-s-creed-unity.html');

//Le nom du jeux//
$titre = $html->find('title',0);
$titreJeu = $titre->innertext;
$titreJeu=substr($titreJeu, 5);
$titreJeuFinal = explode("(", $titreJeu);
echo $titreJeuFinal[0].'<br />';

//La note du jeu//
$note = $html->find('span.note-jeux',0);
$note1 = $html->find('span.note-jeux',1);
if ($note != '')
    {
    $noteJeu = $note->innertext;
    echo "note du site: $noteJeu/10";
    }
if ($note =='')
    {
    echo "note du site: 0/10";
    }
if ($note1 != '')
    {
    $noteJeu1 = $note1->innertext;
    echo " | note des internautes: $noteJeu1/10 <br />";
    }
if ($note1 =='')
    {
    echo " | note des internautes: 0/10<br />";
    }


//Le titre de la description//
$titreP = $html->find('p.overview',0);
echo '<strong>'.$titreP.'</strong>';

//La descrition du jeu//
foreach($html->find('div.parsed-text img') as $imgDesc)
    {
        $imgDesc->outertext = '';
            foreach($html->find('a') as $aDesc)
            {
                $aDesc->outertext = '';
            }
    }
    echo $imgDesc.'<br />';

$description = $html->find('div.parsed-text',0);
$descriptionJeu = explode("<br />", $description);
echo $descriptionJeu[0].'<br />';

//Les differents paragraphes//
foreach($html->find('div.parsed-text') as $baliseP)
{ 
    foreach($html->find('div.parsed-text img') as $img)
    {
        $img->outertext = '';
    }
    foreach($html->find('strong') as $strong)
    {
        $strong->outertext = '';
    }
    foreach($html->find('h2') as $h2)
    {
        $h2->outertext = '';
    }
    foreach($html->find('a') as $a)
    {
        $a->outertext = '';
    }
    foreach($html->find('script') as $video)
    {
        $video->outertext = '';
    }
    foreach($html->find('div[style]') as $style)
    {
        $style->outertext = '';
    }
    foreach($html->find('ul.fleche') as $fleche)
    {
        $fleche->outertext = '';
    }
        foreach($html->find('img') as $img)
    {
        $img->outertext = '';
    }
        foreach($html->find('b') as $b)
    {
        $b->outertext = '';
    }

    $paragraphe = str_replace($descriptionJeu[0],'',$baliseP);
    $paragraphe = str_replace('h1', 'h2', $paragraphe);

    echo $paragraphe;
}
?>

