<?php
require 'DbConnection.php';
$con = new DbConnection();
$con = $con->connect();

//definindo classificação do usuário 0 = cliente | 1 = prestador | 2 = pequena empresa
$classification = 0;
if( isset($_POST['smallBusiness']) ){
    $classification = 2;
} else if( isset($_POST['serviceProvider']) ){
    $classification = 1;
} else {
    $classification = 0;
}

//salvando o cadastro no banco de dados
$query = "";
if( $_POST['userAdressComplement'] !== "" ){
    $query = "INSERT INTO usuarios(nome, sobrenome, telefone, email, senha, data_nascimento, sexo, classificacao, cep, estado, cidade, bairro, rua, numero, complemento) VALUES (:nome, :sobrenome, :telefone, :email, :senha, :data_nascimento, :sexo, :classificacao, :cep, :estado, :cidade, :bairro, :rua, :numero, :complemento)";
} else {
    $query = "INSERT INTO usuarios(nome, sobrenome, telefone, email, senha, data_nascimento, sexo, classificacao, cep, estado, cidade, bairro, rua, numero) VALUES (:nome, :sobrenome, :telefone, :email, :senha, :data_nascimento, :sexo, :classificacao, :cep, :estado, :cidade, :bairro, :rua, :numero)";
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

//apagando session do código de confirmação
session_start();
unset($_SESSION['confirmCode']);

//redirecionando / mensagem de sucesso
header('Location:../public/cadastrar/cadastro.php?status=1');