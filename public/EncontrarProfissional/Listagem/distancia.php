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

	$command = $con->query("select cep_usuario, numero_usuario, uf_usuario, cidade_usuario, bairro_usuario, rua_usuario from usuarios where id_usuario=4");
	$data = $command->fetch(PDO::FETCH_ASSOC);

	$apiKey = '2BHqTlrrRZyJOYbFEl47yRbagjjwSaY-Eu3iriuEgvY';
	foreach ($data as $key => $elem) {
		$data[$key] = trim($data[$key]);
		$data[$key] = unaccent(preg_replace('/ /', '+', $data[$key]));
	}
	$q = $data['rua_usuario'] . '%2C+' . $data['cep_usuario'] .'+' . $data['cidade_usuario'] . '%2C+'. $data['uf_usuario'] . '+Brasil' ;
	//echo 'https://geocode.search.hereapi.com/v1/geocode?q='. $q. '&apiKey=' . $apiKey;
	$qq = "city=". $data['cidade_usuario'] . ";street=". $data['rua_usuario']. ";state=" . $data['cidade_usuario'] . ";county=Brasil" . ";district=" . $data["bairro_usuario"]. ";postalCode=" . $data['cep_usuario'] . ";houseNumber=" . $data['numero_usuario'];
	// print_r($data);
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'https://geocode.search.hereapi.com/v1/geocode?qq='. $qq. '&apiKey=' . $apiKey,
    ));
    $rep = curl_exec($curl);
    curl_close($curl);

	// echo '<pre>';
	// print_r( json_decode($rep));
	// echo '<pre>';
	//echo $rep;

	$json = json_encode($rep);
	$obj = json_decode($rep);
	// echo '<pre>';
    // print_r($obj);
	// echo '<pre>';

	function msqlDistance($con, $initialDistance, $myLat, $myLng, $maxDistance){
		// $query = "
		// select *, 
		// ( 6371 * acos( cos( radians(".$initialDistance.") ) * cos( radians(X(posicao_usuario)  ) ) * cos( radians( Y(posicao_usuario) ) - radians(".$myLng.") ) + sin( radians(".$myLat.") ) * sin(radians(X(posicao_usuario) )) ) ) AS distance 
		// from usuarios 
		// INNER JOIN servicos
		// ON usuarios.id_usuario= servicos.id_prestador_servico 
		// HAVING distance > 0
		// ORDER BY distance 
		// LIMIT 0 , 20;
		// ";

		$query = "
		SELECT usuarios.nome_usuario, usuarios.sobrenome_usuario, usuarios.uf_usuario, usuarios.cidade_usuario, usuarios.bairro_usuario, 
		servicos.id_servico, servicos.nome_servico, servicos.orcamento_servico, servicos.crit_orcamento_servico, servicos.nota_media_servico, servicos.status_servico,
		( 6371 * acos( cos( radians(".$myLat.") ) * cos( radians( X(usuarios.posicao_usuario) ) ) * cos( radians( Y(usuarios.posicao_usuario) ) - radians(".$myLng.") ) + sin( radians(".$myLat.") ) * sin(radians(X(posicao_usuario))) ) ) AS distance ,
		X(usuarios.posicao_usuario) as lat,
		Y(usuarios.posicao_usuario) as lng
		FROM usuarios
		INNER JOIN servicos
		ON usuarios.id_usuario= servicos.id_prestador_servico 
		HAVING distance < ".$maxDistance." and distance > ".$initialDistance." and  servicos.status_servico=1
		ORDER BY distance 
		LIMIT 0 , 20;
		";

		$command = $con->query($query);
		$data = $command->fetchAll(PDO::FETCH_ASSOC);

		echo "<pre>";
		print_r($data);
		echo "<pre/>";
	}

	msqlDistance($con, -1,-23.87669 , -46.77125, 10000000);


	//echo($rep);

	// //print_r($obj->items[0]->position->lat);
	// echo '<pre>';
	// print_r($obj->items[0]->position->lat . ' ,  '. $obj->items[0]->position->lng);
	// echo '<pre>';

	// print_r(twopoints_on_earth(0, 0, $obj->items[0]->position->lat, $obj->items[0]->position->lng).' '.'km');
?>

