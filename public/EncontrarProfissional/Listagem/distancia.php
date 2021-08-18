<?php
	function twopoints_on_earth($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
	{
		$long1 = deg2rad($longitudeFrom);
		$long2 = deg2rad($longitudeTo);
		$lat1 = deg2rad($latitudeFrom);
		$lat2 = deg2rad($latitudeTo);
			
		//Haversine Formula
		$dlong = $long2 - $long1;
		$dlati = $lat2 - $lat1;
			
		$val = pow(sin($dlati/2),2)+cos($lat1)*cos($lat2)*pow(sin($dlong/2),2);
			
		$res = 2 * asin(sqrt($val));
			
		$radius = 6371; // km
			
		return ($res*$radius);
	}

	// latitude and longitude of Two Points
	$latitudeFrom = 19.017656 ;
	$longitudeFrom = 72.856178;
	$latitudeTo = 40.7127;
	$longitudeTo = -74.0059;
		
	//print_r(twopoints_on_earth( $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo).' '.'km');


    // $curl = curl_init();
    // curl_setopt_array($curl, array(
    //     CURLOPT_RETURNTRANSFER => 1,
    //     CURLOPT_URL => 'https://geocode.search.hereapi.com/v1/geocode?q=5+Rue+Daunou%2C+75000+Paris%2C+France&apiKey=WFDFeUZx_5Irvq20v_74iA',
    //     CURLOPT_HTTPHEADER => array ('Authorization: Bearer SoD2kvZV5eubpWyTF1LW-WFDFeUZx_5Irvq20v_74iA-HepmMUdFuYmbH4UZ80IizPVfVuoZ1v6kCXPjWk6QwHELwqb6OOK8UhQ2CYWWy1csNcEDMYh3ERftSCFzzRYUoA')
    // ));
    // $rep = curl_exec($curl);
    // curl_close($curl);

    // print_r($rep);

	require '../../../logic/DbConnection.php';
	require './unaccent.php';
	//echo unaccent('');

	$connectClass = new DbConnection();
	$con = $connectClass->connect();

	$command = $con->query("select cep, estado, cidade, bairro, rua from usuarios");
	$data = $command->fetch(PDO::FETCH_ASSOC);

	$apiKey = '2BHqTlrrRZyJOYbFEl47yRbagjjwSaY-Eu3iriuEgvY';
	foreach ($data as $key => $elem) {
		$data[$key] = trim($data[$key]);
		$data[$key] = unaccent(preg_replace('/ /', '+', $data[$key]));
	}
	$q = $data['rua'] . '%2C+' . $data['cep'] .'+' . $data['cidade'] . '%2C+'. $data['estado'] . '+Brasil' ;
	//echo 'https://geocode.search.hereapi.com/v1/geocode?q='. $q. '&apiKey=' . $apiKey;

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'https://geocode.search.hereapi.com/v1/geocode?q='. $q. '&apiKey=' . $apiKey,
    ));
    $rep = curl_exec($curl);
    curl_close($curl);

	echo '<pre>';
	print_r( json_decode($rep));
	echo '<pre>';
	//echo $rep;

	$json = json_encode($rep);
	$obj = json_decode($rep);
	// echo '<pre>';
    // echo($obj);
	// echo '<pre>';


	//echo($rep);

	//print_r($obj->items[0]->position->lat);
	echo '<pre>';
	print_r($obj->items[0]->position->lat . ' ,  '. $obj->items[0]->position->lng);
	echo '<pre>';

	print_r(twopoints_on_earth(43.636719, -79.415195, $obj->items[0]->position->lat, $obj->items[0]->position->lng).' '.'km');
?>

