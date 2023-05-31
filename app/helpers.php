<?php

function normalize_date_data($date_data)
{
    $date_data = (int)$date_data;
    if($date_data < 10) {
        return '0' . $date_data;
    } else {
        return $date_data;
}
}

?>
