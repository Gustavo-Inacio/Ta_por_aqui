<?php
    $lat = -23.695289;
    $lng = -46.549626;
    $apiKey = '2BHqTlrrRZyJOYbFEl47yRbagjjwSaY-Eu3iriuEgvY';

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'https://revgeocode.search.hereapi.com/v1/revgeocode?at='. $lat .','. $lng . '&apiKey=' . $apiKey,
    ));
    $rep = curl_exec($curl);
    curl_close($curl);

    $rep = json_decode($rep);
    echo "<pre>";
    print_r($rep);
    echo "</pre>";

?>