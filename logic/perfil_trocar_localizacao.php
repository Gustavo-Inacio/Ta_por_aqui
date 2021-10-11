<?php
session_start();

require 'DbConnection.php';
require './unaccent.php'; // retira os acentos e caracteres especiais de uma string

$con = new DbConnection();
$con = $con->connect();

//vefificando se tudo está preenchido
foreach ($_POST as $key => $item){
    if ($key !== 'userAdressComplement'){
        if ($item === ''){
            header('Location: ../public/Perfil/meu_perfil.php?status=erro%20ao%20trocar%20localiza%C3%A7%C3%A3o');
            exit();
        }
    }
}

//configurando coordenadas
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

$adressData = array( // dados usados para capurar a posicao em lat e long
    'estado' => $_POST['userAdressState'],
    'cidade' => $_POST['userAdressCity'],
    'bairro' => $_POST['userAdressNeighborhood'],
    'rua' => $_POST['userAdressStreet'],
    'numero' => $_POST['userAdressNumber'],
    'cep' => $_POST['userAdressCEP']
);

$coordinates = getCoordinates($adressData);

if ($_POST['userAdressComplement'] == ""){
    $_POST['userAdressComplement'] = null;
}

//salvando nova localização no banco de dados
$query = "UPDATE usuarios SET cep_usuario = :cep, uf_usuario = :uf, cidade_usuario = :cidade, bairro_usuario = :bairro, rua_usuario = :rua, numero_usuario = :numero, comple_usuario = :complemento, posicao_usuario = POINT({$coordinates['lat']}, {$coordinates['lng']}) WHERE id_usuario = :user";

$stmt = $con->prepare($query);
$stmt->bindValue(':cep', $_POST['userAdressCEP']);
$stmt->bindValue(':uf', $_POST['userAdressState']);
$stmt->bindValue(':cidade', $_POST['userAdressCity']);
$stmt->bindValue(':bairro', $_POST['userAdressNeighborhood']);
$stmt->bindValue(':rua', $_POST['userAdressStreet']);
$stmt->bindValue(':numero', $_POST['userAdressNumber']);
$stmt->bindValue(':user', $_SESSION['idUsuario']);
$stmt->bindValue(':complemento', $_POST['userAdressComplement']);
$stmt->execute();

header('Location: ../public/Perfil/meu_perfil.php?status=localiza%C3%A7%C3%A3o%20alterada%20com%20sucesso');