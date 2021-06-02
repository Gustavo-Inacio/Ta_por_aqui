<?php
session_start();

//caso haja cookies salvos no pc do usuário, ele vai logar com os cookies salvos
require "../../logic/entrar_cookie.php";

//caso haja session(logado), o usuário não pode acessar essa página
if( isset($_SESSION['idUsuario']) && isset($_SESSION['email']) && isset($_SESSION['senha']) && isset($_SESSION['classificacao']) ){
    header('Location: ../Home/home.php');
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://kit.fontawesome.com/2a19bde8ca.js" crossorigin="anonymous" defer></script>

    <title>Tá por aqui</title>

    <link rel="stylesheet" href="../../assets/bootstrap/bootstrap-4.5.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/global/globalStyles.css">
    <link rel="stylesheet" href="login.css">

    <script src="../../assets/bootstrap/jquery-3.5.1.slim.min.js" defer></script>
    <script src="../../assets/bootstrap/popper.min.js" defer></script>
    <script src="../../assets/bootstrap/bootstrap-4.5.3-dist/js/bootstrap.min.js" defer></script>

    <script src="../../assets/global/globalScripts.js" defer></script>
    <script src="login.js" defer></script>
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
                    <a href="../EncontrarProfissional/Listagem/dumb.txt" class="nav-link">Encontre um pofissional</a> 
                </li>
                <li class="nav-item">
                    <a href="../Artigos/artigos.html" class="nav-link">Artigos</a>      
                </li>
                <li class="nav-item">
                    <a href="../Contato/contato.html" class="nav-link">Fale conosco</a>
                </li>
                <li class="nav-item">
                    <a href="../SobreNos/sobreNos.php" class="nav-link">Sobre</a>
                </li>
                <li class="nav-item">
                    <a href="../Chat/chat.html" class="nav-link">Chat</a>
                </li>
                <li class="nav-item">
                    <a href="login.php" class="nav-link">Entrar/cadastrar</a>
                </li>
            </ul>

        </div>
        
    </nav>
    <!--NavBar Fim-->

    <div id="page">
        <section id="loginDiv" class="row container">
            <div class="col-md-5 colorComplement"></div>
            <div class="col-md-7">
                <div id="loginContent">
                    <h1> Entre </h1>

                    <?if( isset($_GET['erro']) && $_GET['erro'] == "login_invalido" ) {?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            Email ou senha Inválidas
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?}?>

                    <form action="../../logic/entrar_login.php" method="POST" id="loginForm">
                        <label for="loginEmail" class="myLabel">Email</label> <br>
                        <input type="text" class="form-control" name="loginEmail" id="loginEmail" class="mb-4" placeholder="Insira o seu e-mail" required>

                        <br>

                        <label for="loginPass" class="myLabel">Senha</label> <br>
                        <div class="input-group mb-2">
                            <input type="password" class="form-control" name="loginPass" id="loginPass" class="mb-4" placeholder="Insira a sua senha" aria-describedby="viewPass" required>
                            <div class="input-group-append">
                                <button type="button" class="input-group-text" id="viewPass" onclick="showPass()"> <i class="fas fa-eye" id="eye"></i> </button>
                            </div>
                        </div>
                        <a href="#" class="text-secondary">Esqueci a senha</a>
                        <br><br>
                        <input type="checkbox" name="stayLogged" id="stayLogged" class="mb-4"> <label for="stayLogged"> Manter-se logado </label>
                        <br>
                        <button type="submit" class="btn btn-block btn-success py-3"> Entrar <i class="fas fa-sign-in-alt"></i> </button>
                    </form>
                    <br>

                    <div class="row">
                        <div class="col-5">
                            <hr class="border border-secondary">
                        </div>
                        <div class="col-2 text-center">
                            ou
                        </div>
                        <div class="col-5">
                            <hr class="border border-secondary">
                        </div>
                    </div>
                    <br>

                    <a href="../Cadastrar/cadastro.php" class="btn btn-block btn-outline-success py-3"> Cadastre-se </a>
                </div>
            </div>
        </section>
    </div>

    <svg width="761" height="567" viewBox="0 0 761 567" fill="none" xmlns="http://www.w3.org/2000/svg" class="d-none d-md-block">
        <path opacity="0.8" d="M258.947 218.405C188.4 61.0687 31.9052 7.24484 -37.5238 0L-57 625H761C746.032 565.804 682.771 442.218 549.467 421.438C382.837 395.462 347.131 415.076 258.947 218.405Z" fill="#45E586"/>
    </svg>
</body>
</html>