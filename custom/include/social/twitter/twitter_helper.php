<?php

function replace_urls($db,$array)
{

    $i = 0;
    $count = count($array['entities']['urls']);
    while($i < $count) {

        $text = str_replace($array['entities']['urls'][$i]['url'], "<a href='" . $array['entities']['urls'][$i]['expanded_url'] . "'target='_blank'>" . $array['entities']['urls'][$i]['display_url'] . "</a> ", $array['text']);
        $text = $db->quote($text);
        $i++;
    }

    return $text;


}

function duplicate_check($db,$text,$date){

    $sql_check = "SELECT * FROM sugarfeed WHERE description = '" . $text . "' AND date_entered = '" . $date . "'";
    $results = $db->query($sql_check);

    while ($row = $db->fetchByAssoc($results)) {
        return true;
        break;
    }
}