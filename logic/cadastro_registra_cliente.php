<?php
require 'DbConnection.php';
require './unaccent.php'; // retira os acentos e caracteres especiais de uma string
$con = new DbConnection();
$con = $con->connect();

function getCoordinates($data) // recebe um array de dados para a pesquisa [q]. Retorna a lat e a long do endereco
{
    $apiKey = '2BHqTlrrRZyJOYbFEl47yRbagjjwSaY-Eu3iriuEgvY';
	foreach ($data as $key => $elem) {
		$data[$key] = trim($data[$key]);
		$data[$key] = unaccent(preg_replace('/ /', '+', $data[$key]));
	}
	$q = $data['rua'] . '%2C+' . $data['cep'] .'+' . $data['cidade'] . '%2C+'. $data['estado'] . '+Brasil' ;

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'https://geocode.search.hereapi.com/v1/geocode?q='. $q. '&apiKey=' . $apiKey,
    ));
    $rep = curl_exec($curl);
    curl_close($curl);

    $obj = json_decode($rep);
    return array('lat' => $obj->items[0]->position->lat, 'lng' => $obj->items[0]->position->lng);
}

//definindo classificação do usuário 0 = cliente | 1 = prestador | 2 = pequena empresa
$classification = 0;
if( isset($_POST['smallBusiness']) ){
    $classification = 2;
} else if( isset($_POST['serviceProvider']) ){
    $classification = 1;
} else {
    $classification = 0;
}

$adressData = array( // dados usados para capurar a posicao em lat e long
    'estado' => $_POST['userAdressState'],
    'cidade' => $_POST['userAdressCity'],
    'bairro' => $_POST['userAdressNeighborhood'],
    'rua' => $_POST['userAdressStreet'],
    'numero' => $_POST['userAdressNumber'],
    'cep' => $_POST['userAdressCEP']
);

$coordinates = getCoordinates($adressData);

//salvando o cadastro no banco de dados
$query = "";
if( $_POST['userAdressComplement'] !== "" ){
    $query = "INSERT INTO usuarios(nome_usuario, sobrenome_usuario, fone_usuario, email_usuario, senha_usuario, data_nasc_usuario, sexo_usuario, classif_usuario, cep_usuario, uf_usuario, cidade_usuario, bairro_usuario, rua_usuario, numero_usuario, posicao_usuario, comple_usuario) VALUES (:nome, :sobrenome, :telefone, :email, :senha, :data_nascimento, :sexo, :classificacao, :cep, :estado, :cidade, :bairro, :rua, :numero, POINT(".$coordinates['lat'] . " " . $coordinates['lng']."), :complemento);";
} else {
    $query = "INSERT INTO usuarios(nome_usuario, sobrenome_usuario, fone_usuario, email_usuario, senha_usuario, data_nasc_usuario, sexo_usuario, classif_usuario, cep_usuario, uf_usuario, cidade_usuario, bairro_usuario, rua_usuario, numero_usuario, posicao_usuario) VALUES (:nome, :sobrenome, :telefone, :email, :senha, :data_nascimento, :sexo, :classificacao, :cep, :estado, :cidade, :bairro, :rua, :numero,  POINT(".$coordinates['lat'] . ", " . $coordinates['lng']."));";
}

$stmt = $con->prepare($query);
$stmt->bindValue(':nome', $_POST['userName']);
$stmt->bindValue(':sobrenome', $_POST['userLastName']);
$stmt->bindValue(':telefone', $_POST['userPhone']);
$stmt->bindValue(':email', $_POST['userEmail']);
$stmt->bindValue(':senha', $_POST['userPass']);
$stmt->bindValue(':data_nascimento', $_POST['userBirthDate']);
$stmt->bindValue(':sexo', $_POST['userSex']);
$stmt->bindValue(':classificacao', $classification);
$stmt->bindValue(':cep', $_POST['userAdressCEP']);
$stmt->bindValue(':estado', $_POST['userAdressState']);
$stmt->bindValue(':cidade', $_POST['userAdressCity']);
$stmt->bindValue(':bairro', $_POST['userAdressNeighborhood']);
$stmt->bindValue(':rua', $_POST['userAdressStreet']);
$stmt->bindValue(':numero', $_POST['userAdressNumber']);
if( $_POST['userAdressComplement'] !== "" ){
    $stmt->bindValue(':complemento', $_POST['userAdressComplement']);
}
$stmt->execute();

//Definindo as redes sociais do usuário
$query2 = "INSERT INTO usuario_redes_sociais(id_usuario, rede_social) values (:ultimo_id_usuario, 'instagram'), (:ultimo_id_usuario, 'facebook'), (:ultimo_id_usuario, 'twitter'), (:ultimo_id_usuario, 'linkedin')";
$stmt = $con->prepare($query2);
$stmt->bindValue(":ultimo_id_usuario", $con->lastInsertId());
$stmt->execute();

//apagando session do código de confirmação
session_start();
unset($_SESSION['confirmCode']);

//redirecionando / mensagem de sucesso
header('Location:../public/cadastrar/cadastro.php?status=1');