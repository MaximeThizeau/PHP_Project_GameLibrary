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
?>