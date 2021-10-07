<?php
session_start();

//caso haja cookies salvos no pc do usuário, ele vai logar com os cookies salvos
require "../../logic/entrar_cookie.php";

//pegar algumas informações do site
require "../../logic/DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

$query = "SELECT count(*) as c from servicos";
$qntServicos = $con->query($query)->fetch(PDO::FETCH_OBJ);

$query = "SELECT count(*) as c from usuarios";
$qntUsers = $con->query($query)->fetch(PDO::FETCH_OBJ);

$query = "SELECT count(*) as c from contratos";
$qntContratos = $con->query($query)->fetch(PDO::FETCH_OBJ);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tá por aqui - Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/global/globalStyles.css">
    <link rel="stylesheet" href="home.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/2a19bde8ca.js" crossorigin="anonymous" defer></script>
    <script src="../../assets/global/globalScripts.js" defer></script>
    <script src="home.js" defer></script>
</head>
<body>
    <!--NavBar Comeco-->
    <div id="myMainTopNavbarNavBackdrop" class=""></div>
    <nav id="myMainTopNavbar" class="navbar navbar-expand-md">
        <div class="container-fluid">
            <a href="home.php" id="myMainTopNavbarBrand" class="navbar-brand">
                <img src="../../assets/images/dumb-brand.png" alt="Tá por aqui" class="my-brand-img">
            </a>

            <button type="button" id="myMainTopNavbarToggler" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#myMainTopNavbarNav" aria-controls="myMainTopNavbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="my-navbar-toggler-icon">
                        <div></div>
                        <div></div>
                        <div></div>
                    </span>
            </button>

            <div id="myMainTopNavbarNav" class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="home.php" class="nav-link">Home</a>
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
                        <a href="../Chat/chat.php" class="nav-link" id="navChatLink">Chat</a>
                    </li>
                    <?php if (empty($_SESSION['idUsuario'])) { ?>
                        <li class="nav-item">
                            <a href="../Entrar/login.php" class="nav-link">Entrar/cadastrar</a>
                        </li>
                    <?php } ?>
                </ul>

                <?php if (isset($_SESSION['idUsuario']) && isset($_SESSION['email']) && isset($_SESSION['senha']) && isset($_SESSION['classificacao'])) { ?>
                    <div class="dropdown">
                        <img src="../../assets/images/users/<?= $_SESSION['imagemPerfil'] ?>" alt="imagem de perfil" id="profileMenu" class="img-fluid" data-bs-toggle="dropdown" aria-expanded="false">

                        <div class="dropdown-menu" aria-labelledby="profileMenu">
                            <a class="dropdown-item" href="../Perfil/meu_perfil.php">Perfil</a>
                            <a class="dropdown-item text-danger" href="../../logic/entrar_logoff.php">Sair</a>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
    </nav>
    <!--NavBar Fim-->

    <!--Landing Section Comeco-->
    <section id="myLandingSection">
        <div id="myLandingContentAreaContainer" class="container-fluid order-sm-2">
            <div class="my-landing-conetent-area my-mobile-landing">
                <?php if(isset($_GET['conta']) && $_GET['conta'] == "reativada") {?>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        Conta reativada com sucesso
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php }?>
                <h1 class="my-landing-title">Encontre um prestador de serviços próximo a sua localização</h1>

                <div class="my-landing-text-content ">
                
                    <div class="my-landing-text-content-moblie">
                        <p class="my-landing-text-p">
                            <label class="my-landing-text">Todos nós precisamos de profissionais. Agora ficou fácil !!</label>
                            <br class="d-flex d-sm-none">
                            <label class="my-landing-text">Encontre os melhores prestadores mais próximos de você.</label>
                        </p>
                    </div>
                    
                    <div class="my-landing-img-content">
                        <div class="my-landing-img-div">
                            <img src="../../assets/images/landing-img.png" alt="" class="my-landing-img">
                        </div>
                    </div>
                
                </div>
                <div class="my-landing-search-bar-div">
                    <form class="my-landing-search-bar-form" action="" method="get">
                        <input type="text" class="my-search-bar-mobile minimum" placeholder="Que serviço está procurando?">
                        <input type="text" class="my-search-bar-mobile extra-small" placeholder="Que profissional você gostaria de encontrar? ">
                        <button type="submit">Pesquisar</button>
                    </form>
                </div>
            </div>

            <div class="my-landing-conetent-area my-desk-landing">
                <div class="my-landing-text-content">
                    <?php if(isset($_GET['conta']) && $_GET['conta'] == "reativada") {?>
                        <div class="alert alert-success alert-dismissible" role="alert">
                            Conta reativada com sucesso
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php }?>
                    <h1 class="my-landing-title ">Encontre um prestador de serviços próximo a sua localização</h1>
                    <p class="my-landing-text">Todos nós precisamos de profissionais. Agora ficou fácil !! Encontre os melhores prestadores mais próximos de você.</p>
                    <div class="my-landing-search-bar-div ">
                        <form class="my-landing-search-bar-form" action="" method="get">
                            <input type="text" name="" id="" placeholder="Que profissional você gostaria de encontrar? ">
                            <button type="submit">Pesquisar</button>
                        </form>
                        
                    </div>
                </div>

                <div class="my-landing-img-content">
                    <div class="my-landing-img-div">
                        <img src="../../assets/images/landing-img.png" alt="" class="my-landing-img">
                    </div>
                </div>
            </div>
        </div>
        <!--Suggestion Bar-->
        <div class="container-fluid order-sm-1 p-0">
            <div class="row my-services-suggestion-bar-path">
                <div id="mySuggestionBarControllerLeft">
                    <i class="fas fa-chevron-left"></i>
                </div>
                <div id="mySuggestionBarControllerRight">
                    <i class="fas fa-chevron-right"></i>
                </div>

                <template id="myServiceItemTemplate">
                    <div class="my-service-item">
                        <a href="#" class="my-service-item-a">
                            <i id="myServiceItemIcon" class="fas fa-map-marker-alt"></i>
                            <p id="myServiceItemText" class="my-service-item-text">Erro!!</p>
                        </a>
                    </div>
                </template>

                <div class="my-services-suggestion-bar"></div> <!--Esta e a lista  - dinamica com js-->
                
            </div>
        </div>
    </section>
    <!--Landing Section Fim-->

    <!--Transition comeco-->

    <section id="myLoginSection">
        <div id="myLoginSectionContainer" class="container">
            <div class="row">
                <div id="myLoginSectionCol" class="col">

                    <?php if(!isset($_SESSION['idUsuario'])) {?>
                        <!-- Botão de login para pessoas não logadas -->
                        <h1 class="my-login-section--title">Você tem um negócio local? </h1>
                        <p class="my-login-section--text">Já pensou em possuir uma vitrine digital? Poisé, nossa plataforma é especialisada em vitrines para negócios, faça já a sua! Áh, e não esqueça de adicionar a localização, os clientes precisam te encontrar!</p>
                        <div class="my-login-section--btn-area">
                            <a class="btn-login-a" href="../Entrar/login.php"> <button>Entrar</button> </a>
                            <a class="btn-signup-a" href="../Cadastrar/cadastro.php"> <button>Cadastre-se</button> </a>
                        </div>

                    <?php } else {?>
                        <!-- Botão de login para pessoas não logadas -->
                        <h1 class="my-login-section--title"> Personalize seu perfil </h1>
                        <p class="my-login-section--text"> É muito importante manter seu perfil sempre com as informações atualizadas para quando as pessoas entrarem em contato com você! </p>
                        <div class="my-login-section--btn-area">
                            <a class="btn-signup-a" href="../Perfil/meu_perfil.php"> <button>Meu perfil</button> </a>
                        </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </section>

    <!--Transition Fim-->

    <!--Welcome Section Comeco-->
    <section id="myWelcomeSection">
        <svg id="myLeftYellow" width="310" height="592" viewBox="0 0 310 592" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1.52354 126.015C76.9896 161.522 157.039 199.496 223.219 231.51C298.266 267.813 299.247 347.598 227.051 389.281L7.50712 516.034C-43.6666 545.58 -108.456 535.927 -148.795 492.748L-224.925 411.259C-253.577 380.59 -246.224 331.235 -209.877 310.25C-191.369 299.564 -179.27 280.489 -177.492 259.192L-174.909 228.247C-167.704 141.936 -76.8461 89.1416 1.52354 126.015Z" fill="#F9FFA0"/>
        </svg>     
        
        <svg id="myRightYellow" width="216" height="269" viewBox="0 0 216 269" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M31.7765 65.8393C53.0674 51.0296 75.0796 35.7738 96.4033 21.0768C165.052 -26.2385 234 11.7087 234 95.0837V170.86C234 210.464 206.689 244.836 168.11 253.787L111.227 266.983C86.9453 272.617 63.7413 254.18 63.7413 229.253C63.7413 216.566 57.528 204.683 47.109 197.444L31.9661 186.923C-10.2628 157.583 -10.4365 95.2023 31.7765 65.8393Z" fill="#F9FFA0"/>
        </svg>
            
        
        <div class="container" id="myWelcomeSectionContainer">
            <div class="row my-welcome-section-text-row">
                <div class="col">
                    <h1 class="my-welcome-section--title">Quem é o Tá Por Aqui?</h1>
                    <p class="my-welcome-section--text">
                        Nossa empresa é especialista em ajudar você a encontrar um serviço de qualidade com praticidade, e, especilistas em ajudar o seu pequeno negócio, sua autonomaia ou sua habilidade se tornar rentável e se manter em contato com o público. 
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-sm-6 col-lg-4 my-welcome-item">
                    <i class="far fa-comment-alt"></i>
                    <h2 class="my-welcome-item--subtitle">Acessível</h2>
                    <p class="my-welcome-item--text">Nossa plataforma possibilita um fácil e prático uso para ajudar na sua necessidade</p>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 my-welcome-item">
                    <i class="far fa-comment-alt"></i>
                    <h2 class="my-welcome-item--subtitle">Seguro</h2>
                    <p class="my-welcome-item--text">Nossa plataforma possibilita um fácil e prático uso para ajudar na sua necessidade</p>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 mx-sm-auto mx-lg-none my-welcome-item">
                    <i class="far fa-comment-alt"></i>
                    <h2 class="my-welcome-item--subtitle">Camarada</h2>
                    <p class="my-welcome-item--text">Nossa plataforma possibilita um fácil e prático uso para ajudar na sua necessidade</p>
                </div>
            </div>

        </div>
    </section>
    <!--Welcome Section Fim-->

    <!--Data Section Comeco-->
    <section id="myDataSection">
        <div id="myDataSectionContainer" class="container" >
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-4 my-section-data-item">
                    <p>Serviços disponíveis</p>
                    <h1 id="mySearchAmount"><?=$qntServicos->c?></h1>
                </div>
                <div class="col-12 col-sm-6 col-lg-4 my-section-data-item">
                    <p>Usuários Cadastrados</p>
                    <h1 id="myUserAmount"><?=$qntUsers->c?></h1>
                </div>
                <div class="col-12 col-sm-6 col-lg-4 mx-sm-auto mx-lg-none my-section-data-item ">
                    <p>Contratos realizados</p>
                    <h1 id="myOpportunityAmount"><?=$qntContratos->c?></h1>
                </div>
            </div>
        </div>
    </section>
    <!--Data Section Fim-->

    <!--Final Message Section Comco-->
    <section id="myFinalMessageSection">
        <div id="myFinalMessageContainer" class="container">
            <div class="row">
                <div class="col-12">
                    <p class="my-final-message">AJUDANDO OS PROFISSIONAIS DESDE SEMPRE</p>
                    <p class="my-second-final-message">Força, para o pós pandemia </p>
                </div>
            </div>
        </div>
    </section>
    <!--Final Message Section Fim-->

    <footer id="myMainFooter">
        <div id="myMainFooterContainer" class="container-fluid">
            <div class="my-main-footer-logo">
                <img src="../../assets/images/dumb-footer.png" alt="Tá por Aqui" class="my-footer-img">
            </div>
            <div class="my-main-footer-institutional">
                <p>INSTITUCIONAL</p>
                <a href="../SobreNos/sobreNos.php">Quem Somos</a> <br>
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
    </footer>
<!--
    <div class="test">
        <p class="xs">xs</p>
        <p class="sm">sm</p>
        <p class="md">md</p>
        <p class="lg">lg</p>
        <p class="xl">xl</p>
    </div>-->
</body>
</html>