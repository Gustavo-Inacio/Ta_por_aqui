<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tá por aqui - Serviço inexistente</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="../../../assets/global/globalStyles.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/2a19bde8ca.js" crossorigin="anonymous" defer></script>
    <script src="../../../assets/global/globalScripts.js" defer></script>

    <style>
        .serviceNotFoundImg{
            width: 100%;
            max-width: 300px;
        }

        .serviceNotFoundText h1{
            font-weight: bold;
            font-size: 42px;
            color: black;
        }

        .whatHappened{
            padding: 15px;
            border-radius: 6px;
            width: 100%;
            max-width: 500px;
            margin: 10px 0;
        }

        .whatHappened h3{
            font-weight: bold;
            font-size: 28px;
            color: #525252;
        }

        .serviceNotFoundText a.mybtn:hover{
            text-decoration: none;
            color: white;
        }
    </style>
</head>

<body>
    <!--NavBar Comeco-->
    <div id="myMainTopNavbarNavBackdrop" class=""></div>
    <nav id="myMainTopNavbar" class="navbar navbar-expand-md">
        <div class="container-fluid">
            <a href="../../Home/home.php" id="myMainTopNavbarBrand" class="navbar-brand">
                <img src="../../../assets/images/dumb-brand.png" alt="Tá por aqui" class="my-brand-img">
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
                        <a href="../../Home/home.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="../Listagem/listagem.php" class="nav-link">Encontre um profissional</a>
                    </li>
                    <li class="nav-item">
                        <a href="../../Artigos/artigos.php" class="nav-link">Artigos</a>
                    </li>
                    <li class="nav-item">
                        <a href="../../Contato/contato.php" class="nav-link">Fale conosco</a>
                    </li>
                    <li class="nav-item">
                        <a href="../../ComoFunciona/comoFunciona.php" class="nav-link">Sobre</a>
                    </li>
                    <li class="nav-item">
                        <a href="../../Chat/chat.php" class="nav-link" id="navChatLink">Chat</a>
                    </li>
                    <?php if (empty($_SESSION['idUsuario'])) { ?>
                        <li class="nav-item">
                            <a href="../../Entrar/login.php" class="nav-link">Entrar/cadastrar</a>
                        </li>
                    <?php } ?>
                </ul>

                <?php if (isset($_SESSION['idUsuario']) && isset($_SESSION['email']) && isset($_SESSION['senha']) && isset($_SESSION['classificacao'])) { ?>
                    <div class="dropdown">
                        <img src="../../../assets/images/users/<?= $_SESSION['imagemPerfil'] ?>" alt="imagem de perfil" id="profileMenu" class="img-fluid" data-bs-toggle="dropdown" aria-expanded="false">

                        <div class="dropdown-menu" aria-labelledby="profileMenu">
                            <a class="dropdown-item" href="../../Perfil/meu_perfil.php">Perfil</a>
                            <a class="dropdown-item text-danger" href="../../../logic/entrar_logoff.php">Sair</a>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
    </nav>
    <!--NavBar Fim-->
    <div class="container mb-5">
        <div class="row">
            <div class="col-md-4 d-flex flex-column justify-content-center mb-3 mb-md-0">
                <img src="../../../assets/images/user_not_found.png" alt="Detetive procurando serviço" class="serviceNotFoundImg mx-auto">
            </div>
            <div class="col-md-8 d-flex flex-column justify-content-center serviceNotFoundText">
                <h1>O serviço procurado não pôde ser carregado</h1>
                <div class="whatHappened">
                    <h3>O que pode ter acontecido: </h3>
                    <ul>
                        <li>Você pode ter digitado a url errada</li>
                        <li>O prestador desse serviço desativou a conta</li>
                        <li>Esse serviço recebeu muitas denúncias e foi banido</li>
                    </ul>
                </div>
                <p>Se tiver alguma dúvida ou reclamação em relação ao ocorrido, entre em contato pelo <a href="../../Contato/contato.php">Fale conosco</a></p>
                <a href="../Listagem/listagem.php" class="mybtn mybtn-complement"> <i class="fas fa-arrow-left"></i> Voltar para a página de listagem</a>
            </div>
        </div>
    </div>

    <footer id="myMainFooter">
        <div id="myMainFooterContainer" class="container-fluid">
            <div class="my-main-footer-logo">
                <img src="../../../assets/images/dumb-footer.png" alt="Tá por Aqui" class="my-footer-img">
            </div>
            <div class="my-main-footer-institutional">
                <p>INSTITUCIONAL</p>
                <a href="../SobreNos/sobreNos.html">Quem Somos</a> <br>
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
</body>
</html>