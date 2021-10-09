<?php
session_start();

//procurando login do usuário no banco de dados
require "DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

$query = "SELECT id_usuario, email_usuario, senha_usuario, classif_usuario, imagem_usuario, status_usuario FROM usuarios WHERE email_usuario = :email AND senha_usuario = :senha";
$stmt = $con->prepare($query);
$stmt->bindValue(":email", $_POST['recoverEmail']);
$stmt->bindValue(":senha", sha1($_POST['recoverPass']));
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_OBJ);

if( empty($user) ){
    //redirecionando para página de login pois está inválido
    header('Location: ../public/Entrar/login.php?status_usuario=suspenso&rec_erro=email%20ou%20senha%20incorretos%recovermail='.$_POST['recoverEmail']);
} else {
    if ($user->status_usuario == 0){
        #desexcluindo conta do usuário
        //ativando usuário
        $query = "UPDATE usuarios set status_usuario = 1 where status_usuario = 0 AND id_usuario = " . $user->id_usuario;
        $con->query($query);

        //Ativando serviços
        $query = "UPDATE servicos set status_servico = 1 where status_servico = 0 AND id_prestador_servico = " . $user->id_usuario;
        $con->query($query);

        //Exibindo comentários
        $query = "UPDATE comentarios set status_comentario = 1 where status_comentario = 2 AND id_usuario = " . $user->id_usuario;
        $con->query($query);

        #logando usuário
        //criando a session do usuário
        $_SESSION['idUsuario'] = $user->id_usuario;
        $_SESSION['email'] = $user->email_usuario;
        $_SESSION['senha'] = $user->senha_usuario;
        $_SESSION['classificacao'] = $user->classif_usuario;
        $_SESSION['imagemPerfil'] = $user->imagem_usuario;

        //mantendo o usuário logado com cookies (caso desejado)
        if( isset($_POST['stayLogged']) ){
            setcookie('idUsuario', $user->id_usuario, time() + (60*60*24*30), '/'); //expira em 30 dias
            setcookie('email', $user->email_usuario, time() + (60*60*24*30), '/');
            setcookie('senha', $user->senha_usuario, time() + (60*60*24*30), '/');
            setcookie('classificacao', $user->classif_usuario, time() + (60*60*24*30), '/');
            setcookie('imagemPerfil', $user->imagem_usuario, time() + (60*60*24*30), '/');
        }

        header('Location: ../public/Home/home.php?conta=reativada');
    } else if($user->status_usuario == 2) {
        header('Location: ../public/Entrar/login.php?status_usuario=banido');
    } else {
        header('Location: ../public/Entrar/login.php?status_usuario=suspenso&rec_erro=o%20usu%C3%A1rio%20digitado%20n%C3%A3o%20est%C3%A1%20suspenso.%20Tente%20logar%20normalmente');
    }
}