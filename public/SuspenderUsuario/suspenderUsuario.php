<?php
session_start();

//caso haja cookies salvos no pc do usuário, ele vai logar com os cookies salvos
require "../../logic/entrar_cookie.php";

if( empty($_SESSION['idUsuario']) ){
    header('Location: ../Home/home.php');
}

require "../../logic/DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

//buscando motivos para exclusão de conta
$query = "SELECT * FROM deletar_conta_motivos ORDER BY id_del_motivo DESC";
$stmt = $con->query($query);
$motivos = $stmt->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://kit.fontawesome.com/2a19bde8ca.js" crossorigin="anonymous" defer></script>

    <title>Trocar senha</title>

    <link rel="stylesheet" href="../../assets/bootstrap/bootstrap-4.5.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/global/globalStyles.css">
    <link rel="stylesheet" href="suspenderUsuario.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="../../assets/bootstrap/popper.min.js" defer></script>
    <script src="../../assets/bootstrap/bootstrap-4.5.3-dist/js/bootstrap.min.js" defer></script>

    <script src="../../assets/global/globalScripts.js" defer></script>
    <script src="suspenderUsuario.js" defer></script>
</head>
<body>
<!--NavBar Comeco-->
<div id="myMainTopNavbarNavBackdrop" class=""></div>
<nav id="myMainTopNavbar" class="navbar navbar-expand-md">
    <a href="#" id="myMainTopNavbarBrand" class="navbar-brand">
        <img src="../../assets/images/dumb-brand.png" alt="Tá por aqui" class="my-brand-img">
    </a>

    <button id="myMainTopNavbarToggler" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#myMainTopNavbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="my-navbar-toggler-icon">
                <div></div>
                <div></div>
                <div></div>
            </span>
    </button>

    <div id="myMainTopNavbarNav" class="collapse navbar-collapse">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="../Home/home.php" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
                <a href="../EncontrarProfissional/Listagem/listagem.php" class="nav-link">Encontre um profissional</a>
            </li>
            <li class="nav-item">
                <a href="../Artigos/artigos.php" class="nav-link">Artigos</a>
            </li>
            <li class="nav-item">
                <a href="../Contato/contato.php" class="nav-link">Fale conosco</a>
            </li>
            <li class="nav-item">
                <a href="../SobreNos/sobreNos.php" class="nav-link">Sobre</a>
            </li>
            <li class="nav-item">
                <a href="../Chat/chat.php" class="nav-link">Chat</a>
            </li>
            <?php if( empty($_SESSION['idUsuario']) ){ ?>
                <li class="nav-item">
                    <a href="../Entrar/login.php" class="nav-link">Entrar/cadastrar</a>
                </li>
            <?php }?>
        </ul>

        <?php if( isset($_SESSION['idUsuario']) && isset($_SESSION['email']) && isset($_SESSION['senha']) && isset($_SESSION['classificacao']) ) {?>
            <div class="dropdown">
                <img src="../../assets/images/users/<?=$_SESSION['imagemPerfil']?>" alt="imagem de perfil" id="profileMenu" class="img-fluid" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <div class="dropdown-menu" aria-labelledby="profileMenu">
                    <a class="dropdown-item" href="../Perfil/meu_perfil.php">Perfil</a>
                    <a class="dropdown-item text-danger" href="../../logic/entrar_logoff.php">Sair</a>
                </div>
            </div>
        <?php } ?>

    </div>

</nav>
<!--NavBar Fim-->

<div id="page">
    <section id="masterDiv">
        <div>
            <div id="content">
                <div id="changePass" class="border p-4">
                    <div class="text-info mb-4">
                        <p>É realmente uma pena que você tenha decidido sair de nossa plataforma <i class="fas fa-sad-tear" style="font-size: 19px"></i></p>
                        <p>Marque os motivos pelo qual você fez essa decisão para que possamos melhora-la.</p>
                    </div>

                    <form id="changePassForm" action="../../logic/suspender_usuario.php" method="POST">
                        <?php foreach ($motivos as $motivo) {?>
                            <div><label for="<?=$motivo->id_del_motivo?>"><input type="checkbox" name="<?=$motivo->id_del_motivo?>" id="<?=$motivo->id_del_motivo?>"> <?=$motivo->del_motivo?></label></div>
                        <?php } ?>
                        <div id="outroMotivoDiv">
                            <!-- 8.checked -->
                        </div>
                        <br>
                        <button type="submit" class="mybtn mybtn-outline-danger">Excluir conta</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<footer id="myMainFooter">
    <div id="myMainFooterContainer" class="container-fluid">
        <div class="my-main-footer-logo">
            <img src="../../assets/images/dumb-footer.png" alt="Tá por Aqui" class="my-footer-img">
        </div>
        <div class="my-main-footer-institutional">
            <p>INSTITUCIONAL</p>
            <a href="sobreNos.php">Quem Somos</a> <br>
            <a href="#">Faça uma doação</a> <br>
            <a href="#">Trabalhe conosco</a> <br>
        </div>
        <div class="my-main-footer-socialMedia">
            <p>Redes Sociais</p>
            <div class="my-footer-social-medias-div">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>
    </div>
</footer>
</body>
</html>

