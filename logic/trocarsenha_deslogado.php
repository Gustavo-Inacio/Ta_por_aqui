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

//Campos vazios
if ($_POST['newPass'] === "" || $_POST['confirmNewPass'] === ""){
    $valid = false;
    echo "Campos vazios <br>";
}

if ($valid){
    require "DbConnection.php";
    $con = new DbConnection();
    $con = $con->connect();

    //atualizar novo email no banco de dados
    $email = $_SESSION['emailRecSenha'];
    $query = "UPDATE usuarios SET senha_usuario = :senha where email_usuario = '$email'";
    $stmt = $con->prepare($query);
    $stmt->bindValue(':senha', sha1($_POST['newPass']));
    $stmt->execute();

    header('location:../public/Entrar/login.php?status=senha%20alterada%20com%20sucesso&class=success');
} else {
    header('location:../public/Entrar/login.php?status=senha%20alterada%20com%20sucesso&class=danger');
}

#criando uma sessão temporária para troca de senha. Isso fará com que o link tenha uma válidade
$_SESSION['expireTime'] = time() + 3600;
unset($_SESSION['emailRecSenha']);
unset($_SESSION['currentTime']);