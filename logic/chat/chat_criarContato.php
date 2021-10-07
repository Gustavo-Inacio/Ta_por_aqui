<?php
session_start();

require "../DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

//prestador do serviço
$query = "SELECT id_prestador_servico as prestador from servicos where id_servico = " . $_GET['idServico'];
$prestador = $con->query($query)->fetch(PDO::FETCH_OBJ)->prestador;

//cliente do serviço
$cliente = $_SESSION['idUsuario'];

echo $prestador . ' e ' . $cliente;

//Verificar se o contato solicitado já não existe
$query = "SELECT * FROM chat_contatos where id_servico = :id_servico AND id_prestador = :prestador AND id_cliente = :cliente";
$stmt = $con->prepare($query);
$stmt->bindValue(':id_servico', $_GET['idServico']);
$stmt->bindValue(':prestador', $prestador);
$stmt->bindValue(':cliente', $cliente);
$stmt->execute();
$contact = $stmt->fetch(PDO::FETCH_OBJ);

if (isset($contact->id_chat_contato)){
    //Já existe um contato entre esse prestador e cliente referenciando esse mesmo serviço. Redirecionando para a página chat para eles conversarem.
    echo "Contato anterior encontrado... redirecionando";
    //redirecionando para a página de chat
    header('location: ../../public/Chat/chat.php?directChat=' . $contact->id_chat_contato);
} else {
    echo "Criando novo contato... redirecionando...";

    //Criar novo contato entre prestador e cliente referenciando esse serviço
    $query = "INSERT INTO chat_contatos(id_servico, id_prestador, id_cliente, ultima_att_contato) VALUE (:id_servico, :prestador, :cliente, :ultima_att_contato)";
    $stmt = $con->prepare($query);
    $stmt->bindValue(':id_servico', $_GET['idServico']);
    $stmt->bindValue(':prestador', $prestador);
    $stmt->bindValue(':cliente', $cliente);
    $stmt->bindValue(':ultima_att_contato', date('Y-m-d H:i:s'));
    $stmt->execute();

    header('location: ../../public/Chat/chat.php?directChat=' . $con->lastInsertId());
}