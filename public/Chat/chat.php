<?php
session_start();

//caso haja cookies salvos no pc do usuário, ele vai logar com os cookies salvos
require "../../logic/entrar_cookie.php";

if(!isset($_SESSION['idUsuario'])){
    header('Location: boasVindas.php');
}

require "../../logic/DbConnection.php";
$con = new DbConnection();
$con = $con->connect();
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
    <link rel="stylesheet" href="chat.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="../../assets/bootstrap/popper.min.js" defer></script>
    <script src="../../assets/bootstrap/bootstrap-4.5.3-dist/js/bootstrap.min.js" defer></script>

    <!-- emoji picker -->
    <script src="../../assets/emojiPicker/fgEmojiPicker.js"></script>

    <script src="../../assets/global/globalScripts.js" defer></script>
    <script src="chat.js" defer></script>
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
                <a href="chat.php" class="nav-link">Chat</a>
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

<div class="row" id="page">
    <!-- listagem de contatos -->
    <div class="col-md-3" id="chatFirstColumn">
        <h1 class="chatTitle">CHAT</h1>

        <div class="input-group mb-3">
            <input type="text" class="form-control chatSearchbar" placeholder="Insira o nome do usuário" aria-label="Recipient's username" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="input-group-text chatSearchButton" type="button" id="searchUser"> <i class="fas fa-search"></i> </button>
            </div>
        </div>

        <div class="titleGroup">
            <h3 class="userSeparatorTitle">Favoritos</h3>
            <div class="separatorLine"></div>
        </div>

        <div class="usersGroup">
            <div class="userDiv row" userid="1" onclick="loadConversation(1)">
                <div class="col-3 col-md-12 col-lg-3 d-flex d-md-none d-xl-flex">
                    <img src="../../assets/images/users/no_picture.jpg" alt="Imagem do usuário" class="userImg">
                </div>
                <div class="col-7 col-md-8 col-lg-7">
                    <div class="userName">Nome do usuário</div>
                    <div class="userService">Serviço da conversa</div>
                </div>
                <div class="col-2 col-md-4 col-lg-2 mt-3 mt-lg-0 text-right">
                    <div class="chatTime">16:00</div>
                    <div class="chatQntMsg">3</div>
                </div>
            </div>

            <div class="userDiv row" userid="2" onclick="loadConversation(2)">
                <div class="col-3 col-md-12 col-lg-3 d-flex d-md-none d-xl-flex">
                    <img src="../../assets/images/users/no_picture.jpg" alt="Imagem do usuário" class="userImg">
                </div>
                <div class="col-7 col-md-8 col-lg-7">
                    <div class="userName">Nome do usuário</div>
                    <div class="userService">Serviço da conversa</div>
                </div>
                <div class="col-2 col-md-4 col-lg-2 mt-3 mt-lg-0 text-right">
                    <div class="chatTime">16:00</div>
                    <div class="chatQntMsg">3</div>
                </div>
            </div>
        </div>

        <div class="titleGroup">
            <h3 class="userSeparatorTitle">Recentes</h3>
            <div class="separatorLine"></div>
        </div>

        <div class="usersGroup">
            <div class="userDiv row" userid="3" onclick="loadConversation(3)">
                <div class="col-3 col-md-12 col-lg-3 d-flex d-md-none d-xl-flex">
                    <img src="../../assets/images/users/no_picture.jpg" alt="Imagem do usuário" class="userImg">
                </div>
                <div class="col-7 col-md-8 col-lg-7">
                    <div class="userName">Nome do usuário</div>
                    <div class="userService">Serviço da conversa</div>
                </div>
                <div class="col-2 col-md-4 col-lg-2 mt-3 mt-lg-0 text-right">
                    <div class="chatTime">16:00</div>
                    <div class="chatQntMsg">3</div>
                </div>
            </div>

            <div class="userDiv row" userid="4" onclick="loadConversation(4)">
                <div class="col-3 col-md-12 col-lg-3 d-flex d-md-none d-xl-flex">
                    <img src="../../assets/images/users/no_picture.jpg" alt="Imagem do usuário" class="userImg">
                </div>
                <div class="col-7 col-md-8 col-lg-7">
                    <div class="userName">Nome do usuário</div>
                    <div class="userService">Serviço da conversa</div>
                </div>
                <div class="col-2 col-md-4 col-lg-2 mt-3 mt-lg-0 text-right">
                    <div class="chatTime">16:00</div>
                    <div class="chatQntMsg">3</div>
                </div>
            </div>
        </div>

    </div>
    <!-- fim listagem de contatos -->

    <!-- mensagens -->
    <div class="col-md-9" id="chatSecondColumn">
        <div id="loadAssyncConversation">
            <!-- A conversa será selecionada dinamicamente -->

            <!-- Quando a página carrega sem nenhuma conversa selecionada, exibir mensagem: -->
            <div class="noConversationSelected">
                <div class="d-flex flex-column text-center mt-auto mb-auto">
                    <img src="../../assets/images/user_not_found.png" alt="selecionar um usuário" class="align-self-center">
                    <hr>
                    <h3>Se comunique eficazmente</h3>
                    <p>Use nosso chat para conversar com seu prestador do serviço contratado. Seja educado &#x1F609;</p>
                </div>
            </div>
        </div>
    </div>
    <!-- fim mensagens -->

    <!-- detalhes do contato -->
    <div class="col-md-3" id="chatThirdColumn">
        <div id="loadAssyncUserInfo">
            <!-- As informaçõesdo usuário serão carregadas dinamicamente -->
        </div>
    </div>
    <!-- fim detalhes do contato -->
</div>
</body>
</html>