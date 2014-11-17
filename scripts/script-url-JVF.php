<?php
 
include('../plugins/simple_html_dom.php');


function UrlTestIsset($Url, &$tab)
{
    $Isset = false;
    foreach ($tab as $GoodUrl) 
    {
        if ($GoodUrl == $Url)
        {
            $Isset = true;
            break;
        }
    }
    if ($Isset == false)
    {
        $tab[] = $Url;
    }
}


$tab=array();


$variablePC = true;
for($i=1; $variablePC == true; $i++)
    {
        $adresse = "http://www.jeuxvideo.fr/tests-jeux-video-pc-page-$i.html";
        $html = file_get_html($adresse);
        $header = $html->find('.header', 0);
        $bleu = $html->find('.bleu2',0);
        if($header != "" OR $bleu != "")
        {
        foreach($html->find('a') as $platformPC)
            {
                $UrlPC = $platformPC->getAttribute("href");
                if (preg_match("#^http:\/\/www.jeuxvideo#", $UrlPC) )
                    {
                    if(preg_match("#preview-test-#", $UrlPC))
                        {
                            UrlTestIsset($UrlPC, $tab);
                        }
                    }
            }
        }
        else
        {
        $variablePC = false;
        }
    }

$variablePS3 = true;
for($i=1; $variablePS3 == true; $i++)
    {
        $adresse = "http://www.jeuxvideo.fr/tests-jeux-video-ps3-page-$i.html";
        $html = file_get_html($adresse);
        $header = $html->find('.header', 0);
        $bleu = $html->find('.bleu2',0);
        if($header != "" OR $bleu != "")
        {
        foreach($html->find('a') as $platformPS3)
            {
                $UrlPS3 = $platformPS3->getAttribute("href");
                if (preg_match("#^http:\/\/www.jeuxvideo#", $UrlPS3) )
                    {
                    if(preg_match("#preview-test-#", $UrlPS3))
                        {
                            UrlTestIsset($UrlPS3, $tab).'<br />';
                        }
                    }
            }
        }
        else
        {
        $variablePS3 = false;
        }
    }

$variablePS4 = true;
for($i=1; $variablePS4 == true; $i++)
    {
        $adresse = "http://www.jeuxvideo.fr/tests-jeux-video-ps4-page-$i.html";
        $html = file_get_html($adresse);
        $header = $html->find('.header', 0);
        $bleu = $html->find('.bleu2',0);
        if($header != "" OR $bleu != "")
        {
        foreach($html->find('a') as $platformPS4)
            {
                $UrlPS4 = $platformPS4->getAttribute("href");
                if (preg_match("#^http:\/\/www.jeuxvideo#", $UrlPS4) )
                    {
                    if(preg_match("#preview-test-#", $UrlPS4))
                        {
                            UrlTestIsset($UrlPS4, $tab).'<br />';
                        }
                    }
            }
        }
        else
        {
        $variablePS4 = false;
        }
    }

$variableXbox360 = true;
for($i=1; $variableXbox360 == true; $i++)
    {
        $adresse = "http://www.jeuxvideo.fr/tests-jeux-video-xbox-360-page-$i.html";
        $html = file_get_html($adresse);
        $header = $html->find('.header', 0);
        $bleu = $html->find('.bleu2',0);
        if($header != "" OR $bleu != "")
        {
        foreach($html->find('a') as $platformXbox360)
            {
                $UrlXbox360 = $platformXbox360->getAttribute("href");
                if (preg_match("#^http:\/\/www.jeuxvideo#", $UrlXbox360) )
                    {
                    if(preg_match("#preview-test-#", $UrlXbox360))
                        {
                            UrlTestIsset($UrlXbox360, $tab).'<br />';
                        }
                    }
            }
        }
        else
        {
        $variableXbox360 = false;
        }
    }

$variableXBoxOne = true;
for($i=1; $variableXBoxOne == true; $i++)
    {
        $adresse = "http://www.jeuxvideo.fr/tests-jeux-video-xbox-one-page-$i.html";
        $html = file_get_html($adresse);
        $header = $html->find('.header', 0);
        $bleu = $html->find('.bleu2',0);
        if($header != "" OR $bleu != "")
        {
        foreach($html->find('a') as $platformXboxOne)
            {
                $UrlXboxOne = $platformXboxOne->getAttribute("href");
                if (preg_match("#^http:\/\/www.jeuxvideo#", $UrlXboxOne) )
                    {
                    if(preg_match("#preview-test-#", $UrlXboxOne))
                        {
                            UrlTestIsset($UrlXboxOne, $tab).'<br />';
                        }
                    }
            }
        }
        else
        {
        $variableXBoxOne = false;
        }
    }

$variablePSVita = true;
for($i=1; $variablePSVita == true; $i++)
    {
        $adresse = "http://www.jeuxvideo.fr/tests-jeux-video-psvita-page-$i.html";
        $html = file_get_html($adresse);
        $header = $html->find('.header', 0);
        $bleu = $html->find('.bleu2',0);
        if($header != "" OR $bleu != "")
        {
        foreach($html->find('a') as $platformPSVita)
            {
                $UrlPSVita = $platformPSVita->getAttribute("href");
                if (preg_match("#^http:\/\/www.jeuxvideo#", $UrlPSVita) )
                    {
                    if(preg_match("#preview-test-#", $UrlPSVita))
                        {
                            UrlTestIsset($UrlPSVita, $tab).'<br />';
                        }
                    }
            }
        }
        else
        {
        $variablePSVita = false;
        }
    }

$variableDS = true;
for($i=1; $variableDS == true; $i++)
    {
        $adresse = "http://www.jeuxvideo.fr/tests-jeux-video-nintendo-ds-page-$i.html";
        $html = file_get_html($adresse);
        $header = $html->find('.header', 0);
        $bleu = $html->find('.bleu2',0);
        if($header != "" OR $bleu != "")
        {
        foreach($html->find('a') as $platformDS)
            {
                $UrlDS = $platformDS->getAttribute("href");
                if (preg_match("#^http:\/\/www.jeuxvideo#", $UrlDS) )
                    {
                    if(preg_match("#preview-test-#", $UrlDS))
                        {
                            UrlTestIsset($UrlDS, $tab).'<br />';
                        }
                    }
            }
        }
        else
        {
        $variableDS = false;
        }
    }

$variable3DS = true;
for($i=1; $variable3DS == true; $i++)
    {
        $adresse = "http://www.jeuxvideo.fr/tests-jeux-video-nintendo-3ds-page-$i.html";
        $html = file_get_html($adresse);
        $header = $html->find('.header', 0);
        $bleu = $html->find('.bleu2',0);
        if($header != "" OR $bleu != "")
        {
        foreach($html->find('a') as $platform3DS)
            {
                $Url3DS = $platform3DS->getAttribute("href");
                if (preg_match("#^http:\/\/www.jeuxvideo#", $Url3DS) )
                    {
                    if(preg_match("#preview-test-#", $Url3DS))
                        {
                            UrlTestIsset($Url3DS, $tab).'<br />';
                        }
                    }
            }
        }
        else
        {
        $variable3DS = false;
        }
    }

$variableWii = true;
for($i=1; $variableWii == true; $i++)
    {
        $adresse = "http://www.jeuxvideo.fr/tests-jeux-video-nintendo-wii-page-$i.html";
        $html = file_get_html($adresse);
        $header = $html->find('.header', 0);
        $bleu = $html->find('.bleu2',0);
        if($header != "" OR $bleu != "")
        {
        foreach($html->find('a') as $platformWii)
            {
                $UrlWii = $platformWii->getAttribute("href");
                if (preg_match("#^http:\/\/www.jeuxvideo#", $UrlWii) )
                    {
                    if(preg_match("#preview-test-#", $UrlWii))
                        {
                            UrlTestIsset($UrlWii, $tab).'<br />';
                        }
                    }
            }
        }
        else
        {
        $variableWii = false;
        }
    }

$variableWiiU = true;
for($i=1; $variableWiiU == true; $i++)
    {
        $adresse = "http://www.jeuxvideo.fr/tests-jeux-video-wii-u-page-$i.html";
        $html = file_get_html($adresse);
        $header = $html->find('.header', 0);
        $bleu = $html->find('.bleu2',0);
        if($header != "" OR $bleu != "")
        {
        foreach($html->find('a') as $platformWiiU)
            {
                $UrlWiiU = $platformWiiU->getAttribute("href");
                if (preg_match("#^http:\/\/www.jeuxvideo#", $UrlWiiU) )
                    {
                    if(preg_match("#preview-test-#", $UrlWiiU))
                        {
                            UrlTestIsset($UrlWiiU, $tab).'<br />';
                        }
                    }
            }
        }
        else
        {
        $variableWiiU = false;
        }
    }

    foreach ($tab as $tabUrlPC) 
    {
        echo $tabUrlPC.'<br>';
    }
?>
