<?php
session_start();

require "DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

//Verifica se há arquivo enviado
if ( count($_FILES) > 0 ){
    //Verifica se o arquivo passado é uma imagem
    $tipo = $_FILES['newProfilePic']['type'];
    if( $tipo === "image/jpeg" || $tipo === "image/png" || $tipo === "image/png" ){
        //verifica se o arquivo não é maior de 2MB
        if($_FILES['newProfilePic']['size'] < 2097152){
            //Criar arquivo de nome único e diretório
            $extension = pathinfo($_FILES['newProfilePic']['name'], PATHINFO_EXTENSION);
            $extension = strtolower($extension);
            $newName = uniqid(time()) . "." . $extension;
            $dir = "../assets/images/users/user".$_SESSION['idUsuario']."/profile_image/";

            //criar pasta do usuário caso não exista
            if(!file_exists($dir)){
                mkdir($dir, 0777, true);
            }

            //enviar arquivo para pasta de imagens de usuário
            if ( @move_uploaded_file($_FILES['newProfilePic']['tmp_name'], $dir.$newName) ){
                //salvar o nome do arquivo no banco de dados
                $query = "UPDATE usuarios SET imagem_perfil = :newName WHERE id_usuario = :id_usuario";
                $stmt = $con->prepare($query);
                $stmt->bindValue(":newName", "user".$_SESSION['idUsuario']."/profile_image/".$newName);
                $stmt->bindValue(":id_usuario", $_SESSION['idUsuario']);
                $stmt->execute();

                //deletar foto de perfil atual do banco caso ela não seja a no_picture.jpg
                if($_SESSION['imagemPerfil'] !== "no_picture.jpg"){
                    unlink("../assets/images/users/".$_SESSION['imagemPerfil']);
                }

                //atualizar foto na session e no cookie
                $_SESSION['imagemPerfil'] = "user".$_SESSION['idUsuario']."/profile_image/".$newName;
                if (isset($_COOKIE['imagemPerfil'])){
                    setcookie('imagemPerfil', "user".$_SESSION['idUsuario']."/profile_image/".$newName, time() + (60*60*24*30), '/');
                }

                //redirecionando
                header('Location: ../public/Perfil/meu_perfil.php');
            } else {
                //falha em salvar o arquivo
                header('Location: ../public/Perfil/meu_perfil.php?erro=falha%20ao%20salvar%20o%20arquivo');
            }
        } else {
            //arquivo é maior que 2 megas
            header('Location: ../public/Perfil/meu_perfil.php?erro=envie%20arquivos%20de%20no%20maximo%202MB');
        }
    } else {
        //arquivo não é do tipo imagem
        header('Location: ../public/Perfil/meu_perfil.php?erro=tipo%20de%20arquivo%20nao%20suportado');
    }
} else {
    //não há arquivo selecionado
    header('Location: ../public/Perfil/meu_perfil.php?erro=nenhuma%20imagem%20enviada');
}