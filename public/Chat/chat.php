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

    <script src="../../assets/bootstrap/jquery-3.5.1.slim.min.js" defer></script>
    <script src="../../assets/bootstrap/popper.min.js" defer></script>
    <script src="../../assets/bootstrap/bootstrap-4.5.3-dist/js/bootstrap.min.js" defer></script>
    <script src="../../assets/jQueyMask/jquery.mask.js" defer></script>

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
                <a href="../EncontrarProfissional/Listagem/listagem.php" class="nav-link">Encontre um pofissional</a>
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
                <a href="../Chat/chat.html" class="nav-link">Chat</a>
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
            <div class="userDiv row active">
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

            <div class="userDiv row">
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
            <div class="userDiv row">
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

            <div class="userDiv row">
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
    <div class="col-md-6" id="chatSecondColumn">
        <div class="userInfo row" id="userInfo">
            <div class="col-2 d-flex">
                <img src="../../assets/images/users/no_picture.jpg" alt="Imagem do usuário" class="userImg">
            </div>

            <div class="col-8">
                <div class="userName">Nome do usuário</div>
                <div class="userService">Serviço da conversa</div>
            </div>

            <div class="col-2 d-flex justify-content-end align-items-center">
                <div class="dropleft" id="dropdownContent">
                    <button type="button" class="formatBtn" id="moreActions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                    <div class="dropdown-menu" aria-labelledby="moreActions">
                        <a class="dropdown-item" href="#"><i class="fas fa-star"></i> Adicionar aos favoritos</a>
                        <a class="dropdown-item text-danger" href="#"><i class="fas fa-user-slash"></i> Bloquear</a>
                        <a class="dropdown-item text-danger" href="#"><i class="fas fa-ban"></i> Denunciar Serviço</a>
                        <a class="dropdown-item text-danger" href="#"><i class="fas fa-trash"></i> Apagar conversa</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="chatMessages">
            <div class="chatDate">Ontem</div>

            <div class="message myMessage">
                <div class="messageText">Lorem ipsum dolor sit amet, consectetur adipisicing elit. At eveniet ipsam laborum nam nobis perferendis rerum ullam, velit. Aut dicta ducimus incidunt itaque nihil, officia placeat praesentium quisquam sint voluptatum.</div>
                <div class="messageTime">16:00</div>
            </div>

            <div class="message itsMessage">
                <div class="messageText">Lorem ipsum dolor sit amet, consectetur adipisicing elit. At eveniet ipsam laborum nam nobis perferendis rerum ullam, velit. Aut dicta ducimus incidunt itaque nihil, officia placeat praesentium quisquam sint voluptatum.</div>
                <div class="messageTime">16:00</div>
            </div>

            <div class="message myMessage">
                <div class="messageText">Lorem ipsum dolor sit amet, consectetur adipisicing elit. At eveniet ipsam laborum nam nobis perferendis rerum ullam, velit. Aut dicta ducimus incidunt itaque nihil, officia placeat praesentium quisquam sint voluptatum.</div>
                <div class="messageTime">16:00</div>
            </div>

            <div class="message itsMessage">
                <div class="messageText">Lorem ipsum dolor sit amet, consectetur adipisicing elit. At eveniet ipsam laborum nam nobis perferendis rerum ullam, velit. Aut dicta ducimus incidunt itaque nihil, officia placeat praesentium quisquam sint voluptatum.</div>
                <div class="messageTime">16:00</div>
            </div>

            <div class="message myMessage">
                <div class="messageText">Lorem ipsum dolor sit amet, consectetur adipisicing elit. At eveniet ipsam laborum nam nobis perferendis rerum ullam, velit. Aut dicta ducimus incidunt itaque nihil, officia placeat praesentium quisquam sint voluptatum.</div>
                <div class="messageTime">16:00</div>
            </div>

            <div class="message itsMessage">
                <div class="messageText">Lorem ipsum dolor sit amet, consectetur adipisicing elit. At eveniet ipsam laborum nam nobis perferendis rerum ullam, velit. Aut dicta ducimus incidunt itaque nihil, officia placeat praesentium quisquam sint voluptatum.</div>
                <div class="messageTime">16:00</div>
            </div>

            <div class="message myMessage">
                <div class="messageText">Lorem ipsum dolor sit amet, consectetur adipisicing elit. At eveniet ipsam laborum nam nobis perferendis rerum ullam, velit. Aut dicta ducimus incidunt itaque nihil, officia placeat praesentium quisquam sint voluptatum.</div>
                <div class="messageTime">16:00</div>
            </div>

            <div class="message itsMessage">
                <div class="messageText">Lorem ipsum dolor sit amet, consectetur adipisicing elit. At eveniet ipsam laborum nam nobis perferendis rerum ullam, velit. Aut dicta ducimus incidunt itaque nihil, officia placeat praesentium quisquam sint voluptatum.</div>
                <div class="messageTime">16:00</div>
            </div>
        </div>

        <div class="communicationBar row">
            <div class="col-1 d-flex justify-content-center">
                <button type="button" class="formatBtn"> <i class="far fa-laugh chatIcon"></i> </button>
            </div>

            <div class="col-1 d-flex justify-content-center">
                <button type="button" class="formatBtn"> <i class="fas fa-paperclip chatIcon"></i> </button>
            </div>

            <div class="col-9 d-flex">
                <div class="input-group">
                    <textarea class="form-control chatMessageInput" placeholder="Digite uma mensagem" rows="2"></textarea>
                    <div class="input-group-append">
                        <button class="input-group-text chatMessageSend" type="button" id="searchUser"> <i class="fas fa-paper-plane"></i> </button>
                    </div>
                </div>
            </div>

            <div class="col-1 d-flex justify-content-center">
                <button type="button" class="formatBtn"> <i class="fas fa-microphone chatIcon"></i> </button>
            </div>
        </div>
    </div>
    <!-- fim mensagens -->

    <!-- detalhes do contato -->
    <div class="col-md-3" id="chatThirdColumn">
        <div class="userDetailedInfo">
            <img src="../../assets/images/users/no_picture.jpg" alt="Imagem do usuário" class="userImg userImg-lg">
            <div class="userName userName-lg">Nome do usuário</div>
            <div class="userService">Nome do serviço</div>
        </div>

        <div class="chatMidia">
            <button type="button" class="showMidiaBtn" data-toggle="collapse" data-target="#chatMidiaItems" aria-expanded="false" aria-controls="collapseExample">Exibir Mídia <i class="far fa-folder-open"></i> </button>
            <div class="collapse mt-3" id="chatMidiaItems">

                <button type="button" class="btnToggle btnPhotos d-flex justify-content-around align-items-center" data-toggle="collapse" data-target="#chatMidiaList" aria-expanded="false" aria-controls="chatMidiaList">
                    <i class="far fa-file-image"></i> Formatos de mídia (5) <i class="fas fa-sort-down"></i>
                </button>
                <div class="collapse" id="chatMidiaList">
                    <img src="../../assets/images/users/user1/service_images/service4/1629844731612574fb386b6.jpg" alt="" class="chatMidiaItem">
                    <img src="../../assets/images/users/user1/service_images/service4/1629844731612574fb386b6.jpg" alt="" class="chatMidiaItem">
                    <img src="../../assets/images/users/user1/service_images/service4/1629844731612574fb386b6.jpg" alt="" class="chatMidiaItem">
                    <img src="../../assets/images/users/user1/service_images/service4/1629844731612574fb386b6.jpg" alt="" class="chatMidiaItem">
                    <img src="../../assets/images/users/user1/service_images/service4/1629844731612574fb386b6.jpg" alt="" class="chatMidiaItem">
                    <img src="../../assets/images/users/user1/service_images/service4/1629844731612574fb386b6.jpg" alt="" class="chatMidiaItem">

                </div>

                <button type="button" class="btnToggle btnDocs d-flex justify-content-around align-items-center" data-toggle="collapse" data-target="#chatDocList" aria-expanded="false" aria-controls="chatDocList">
                    <i class="far fa-file-pdf"></i> Documentos (17) <i class="fas fa-sort-down"></i>
                </button>
                <div class="collapse" id="chatDocList">
                    <div class="formatBtn chatDocItem">
                        <i class="far fa-file-pdf"></i> <span class="docName">nome do arquivo</span> <i class="fas fa-download"></i>
                    </div>
                    <div class="formatBtn chatDocItem">
                        <i class="far fa-file-pdf"></i> <span class="docName">nome do arquivo</span> <i class="fas fa-download"></i>
                    </div>
                    <div class="formatBtn chatDocItem">
                        <i class="far fa-file-pdf"></i> <span class="docName">nome do arquivo</span> <i class="fas fa-download"></i>
                    </div>
                    <div class="formatBtn chatDocItem">
                        <i class="far fa-file-pdf"></i> <span class="docName">nome do arquivo</span> <i class="fas fa-download"></i>
                    </div>
                    <div class="formatBtn chatDocItem">
                        <i class="far fa-file-pdf"></i> <span class="docName">nome do arquivo</span> <i class="fas fa-download"></i>
                    </div>
                    <div class="formatBtn chatDocItem">
                        <i class="far fa-file-pdf"></i> <span class="docName">nome do arquivo</span> <i class="fas fa-download"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="chatOptions">
            <div class="addFavorite">
                Adicionar aos favoritos
                <label class="switch">
                    <input type="checkbox">
                    <span class="slider round"></span>
                </label>
            </div>
            <hr>
            <div class="dangerOption dangerFakeLine">Bloquear <i class="fas fa-user-slash"></i></div>
            <div class="dangerOption dangerFakeLine">Denunciar serviço <i class="fas fa-ban"></i></div>
            <div class="dangerOption">Apagar conversa <i class="fas fa-trash"></i></div>
        </div>
    </div>
    <!-- fim detalhes do contato -->
</div>

<footer id="myMainFooter">
    <div id="myMainFooterContainer" class="container-fluid">
        <div class="my-main-footer-logo">
            <img src="../../assets/images/dumb-footer.png" alt="Tá por Aqui" class="my-footer-img">
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
    </div>
</footer>
</body>
</html>