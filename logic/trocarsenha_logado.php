<?php
session_start();
print_r($_POST);

$valid = true;

//senha não colidem
if ($_POST['newPass'] !== $_POST['confirmNewPass']){
    $valid = false;
    echo "senha não colidem <br>";
}

//A senha deve ter 8 caracteres
if (strlen($_POST['newPass']) < 8){
    $valid = false;
    echo "A senha deve ter 8 caracteres <br>";
}

//A senha deve ter números
if (filter_var($_POST['newPass'], FILTER_SANITIZE_NUMBER_INT) == null){
    $valid = false;
    echo "A senha deve ter números <br>";
}

//senha atual incorreta
if ($_POST['oldPass'] !== $_SESSION['senha']){
    $valid = false;
    echo "senha atual incorreta <br>";
}

//senha igual a atual
if ($_POST['oldPass'] === $_POST['newPass']){
    $valid = false;
    echo "senha atual igual a antiga <br>";
}

//Campos vazios
if ($_POST['oldPass'] === "" || $_POST['newPass'] === "" || $_POST['confirmNewPass'] === ""){
    $valid = false;
    echo "Campos vazios <br>";
}

if ($valid){
    require "DbConnection.php";
    $con = new DbConnection();
    $con = $con->connect();

//atualizar novo email no banco de dados
    $query = "UPDATE usuarios SET senha_usuario = :senha where id_usuario = " . $_SESSION['idUsuario'];
    $stmt = $con->prepare($query);
    $stmt->bindValue(':senha', $_POST['newPass']);
    $stmt->execute();

//atualizar novo email na session
    $_SESSION['senha'] = $_POST['newPass'];

//atualizar novo email nos cookies
    if (isset($_COOKIE['senha'])){
        setcookie('senha', $_POST['newPass'], time() + (60*60*24*30), '/');
    }

    header('location:../public/Perfil/meu_perfil.php?status=senha%20alterada%20com%20sucesso');
} else {
    header('location:../public/TrocarSenha/trocarSenha.php?erro=1');
}