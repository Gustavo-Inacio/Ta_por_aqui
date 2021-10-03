<?php
require "../DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

if ($_FILES['midiaInput']['name'] == ""){
    echo "erro";
    exit();
}
if ($_FILES['midiaInput']['size'] > 40000000){
    echo "erro";
    exit();
}

//Salvando o arquivo e adicionando ao banco de dados
#pegando extensão
$extension = pathinfo($_FILES['midiaInput']['name'], PATHINFO_EXTENSION);
$extension = strtolower($extension);

#criando novo nome unico
$newName = uniqid( time() ) . "." . $extension;

#referenciando diretório
$dir = "../../assets/chatSharedFiles/contato{$_POST['id_chat_contato']}/";

#criar pasta do usuário caso não exista
if(!file_exists($dir)){
    mkdir($dir, 0777, true);
}

#movendo imagem
if ( @move_uploaded_file($_FILES['midiaInput']['tmp_name'], $dir.$newName) ){
    #caso movido com sucesso --> salvar no banco de dados
    $query = "INSERT INTO chat_mensagens(id_chat_contato, id_remetente_usuario, id_destinatario_usuario, mensagem_chat, diretorio_arquivo_chat, apelido_arquivo_chat) VALUE (:id_chat_contato, :id_remetente_usuario, :id_destinatario_usuario, :mensagem_chat, :arquivo_chat, :apelido_arquivo_chat)";
    $stmt = $con->prepare($query);
    $stmt->bindValue(':id_chat_contato', $_POST['id_chat_contato']);
    $stmt->bindValue(':id_remetente_usuario', $_POST['id_remetente']);
    $stmt->bindValue(':id_destinatario_usuario', $_POST['id_destinatario']);
    $stmt->bindValue(':mensagem_chat', 'arquivo');
    $stmt->bindValue(':arquivo_chat', "contato{$_POST['id_chat_contato']}/$newName");
    $stmt->bindValue(':apelido_arquivo_chat', $_FILES['midiaInput']['name']);
    $stmt->execute();
}