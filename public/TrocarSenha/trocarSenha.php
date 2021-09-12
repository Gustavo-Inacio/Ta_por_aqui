<?php
//erro ao trocar de senha
if (isset($_GET['erro']) && $_GET['erro'] === "1") {
    echo "Ocorreu um erro ao trocar sua senha. <a href='../Perfil/meu_perfil.php'>Volte para página de perfil</a> e tente novamente";
}

//Essa página só será carregada se o usuário tiver passado pela p=agina perfil_allowChangePass.php
if (!isset($_COOKIE['allowChangePass'])){
    die("Essa página expirou <a href='../Perfil/meu_perfil.php'> volte para página de perfil</a>");
}

session_start();
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
    <link rel="stylesheet" href="trocarSenha.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="../../assets/bootstrap/popper.min.js" defer></script>
    <script src="../../assets/bootstrap/bootstrap-4.5.3-dist/js/bootstrap.min.js" defer></script>

    <script src="../../assets/global/globalScripts.js" defer></script>
    <script src="trocarSenha.js" defer></script>
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
                <a href="../EncontrarProfissional/Listagem/listagem.php" class="nav-link">Encontre um pofissional</a>
            </li>
            <li class="nav-item">
                <a href="../Artigos/artigos.html" class="nav-link">Artigos</a>
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
            <?php if( empty($_SESSION) ){ ?>
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
                <div id="alertError" class="alert alert-danger d-none" role="alert" style="margin-top: -30px">
                    <span id="msgErro"></span>
                </div>

                <div id="changePass" class="border p-4">
                    <p class="text-info mb-4">
                        Crie uma nova senha com pelo menos 8 caracteres, contendo letras e números
                    </p>

                    <form id="changePassForm" action="../../logic/trocarsenha_logado.php" method="POST">
                        <input type="password" class="form-control mb-2" id="oldPass" name="oldPass" placeholder="Senha antiga" required>
                        <input type="password" class="form-control mb-2" id="newPass" name="newPass" placeholder="Nova senha" required>
                        <input type="password" class="form-control mb-2" id="confirmNewPass" name="confirmNewPass" placeholder="Confirme a nova senha" required>

                        <button type="button" class="mybtn mybtn-conversion" onclick="validateNewPass('<?=$_SESSION['senha']?>')">Alterar senha</button>
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