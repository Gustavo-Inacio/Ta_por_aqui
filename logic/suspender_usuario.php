<?php
session_start();

require 'DbConnection.php';
$con = new DbConnection();
$con = $con->connect();

$idUsuario = $_SESSION['idUsuario'];

//inserir os motivos do usuário deixar nossa plataforma
foreach ($_POST as $key => $checkbox) {
    if ($key !== "outroMotivo" && $key !== 1){
        $query = "INSERT INTO motivos_saida_usuario(id_usuario, id_del_motivo) value ($idUsuario, :key)";
        $stmt = $con->prepare($query);
        $stmt->bindValue(":key", $key);
        $stmt->execute();
    }
}

//inserir outro motivo (caso id_del_motivo = 1)
if (isset($_POST['1']) && $_POST['1'] === "on" && isset($_POST['outroMotivo'])){
    $query = "INSERT INTO motivos_saida_usuario(id_usuario, id_del_motivo, outro_del_motivo) value ($idUsuario, 1, :outroDelMotivo)";
    $stmt = $con->prepare($query);
    $stmt->bindValue(":outroDelMotivo", $_POST['outroMotivo']);
    $stmt->execute();
}

//colocar conta como suspensa no banco de dados
$query = "UPDATE usuarios set status_usuario = 0 WHERE id_usuario = $idUsuario";
$con->query($query);

//suspender serviços do usuário
$query = "UPDATE servicos set status_servico = 0 WHERE id_prestador_servico = $idUsuario AND status_servico = 1";
$con->query($query);

//ocultar comentários feitos
$query = "UPDATE comentarios set status_comentario = 2 WHERE id_usuario = $idUsuario AND status_comentario = 1";
$con->query($query);

//Exluir sessão e cookies do usuário
//Colocar o status do usuário como offline
$query = "UPDATE usuarios SET online_usuario = false WHERE id_usuario = {$_SESSION['idUsuario']}";
$con->query($query);

//destruindo session
session_destroy();

//destruindo cookies
setcookie('idUsuario', null, -1, '/'); //expira em 30 dias
setcookie('email', null, -1, '/');
setcookie('senha', null, -1, '/');
setcookie('classificacao', null, -1, '/');
setcookie('imagemPerfil', null, -1, '/');

//redirecionando
header('Location: ../public/Entrar/login.php');