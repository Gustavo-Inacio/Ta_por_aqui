<?php
session_start();

//caso haja cookies salvos no pc do usuário, ele vai logar com os cookies salvos
require "../../logic/entrar_cookie.php";

//pegando as informações do perfil visualizado
require "../../logic/DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

$isProvider = false;

if(isset($_SESSION['classificacao']) && $_SESSION['classificacao'] >= 1){
    $isProvider = true;
}

//Puxando os dados do meu perfil do banco de dados
if(isset($_GET['id'])) {
    $query = "SELECT * FROM usuarios where id_usuario = " . $_GET['id'] . " AND status_usuario = 1";
    $stmt = $con->query($query);
    $user = $stmt->fetch(PDO::FETCH_OBJ);

    if (!empty($user)){
        //puxando as redes sociais do usuário
        $query2 = "SELECT rede_social, nick_rede_social, link_rede_social FROM usuario_redes_sociais WHERE id_usuario = " . $_GET['id'];
        $stmt = $con->query($query2);
        $userSocialMedia = $stmt->fetchAll(PDO::FETCH_OBJ);

        //puxando os serviços do prestador
        if($user->classif_usuario !== 0){
            $query = "SELECT id_servico, nome_servico, tipo_servico, orcamento_servico, crit_orcamento_servico, data_public_servico FROM servicos WHERE id_prestador_servico = " . $_GET['id'] . " AND status_servico = 1 ORDER BY id_servico DESC";
            $stmt = $con->query($query);
            $userServices = $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }
}
if( !isset($_GET['id']) || empty($user) ){
?>

<!-- HTML da mensagem de erro de usuário não encontrado-->

    <!DOCTYPE html>
    <html lang="pt">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Tá por aqui - usuário inexistente</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
        <link rel="stylesheet" href="../../assets/global/globalStyles.css">
        <link rel="stylesheet" href="perfil.css">

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/2a19bde8ca.js" crossorigin="anonymous" defer></script>
        <script src="../../assets/global/globalScripts.js" defer></script>
        <script src="show_services.js" defer></script>
    </head>

    <body>
    <!--NavBar Comeco-->
    <div id="myMainTopNavbarNavBackdrop" class=""></div>
    <nav id="myMainTopNavbar" class="navbar navbar-expand-md">
        <div class="container-fluid">
            <a href="../Home/home.php" id="myMainTopNavbarBrand" class="navbar-brand">
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
                        <a href="../ComoFunciona/comoFunciona.php" class="nav-link">Sobre</a>
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
                            <a class="dropdown-item" href="meu_perfil.php">Perfil</a>
                            <a class="dropdown-item text-danger" href="../../logic/entrar_logoff.php">Sair</a>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
    </nav>
    <!--NavBar Fim-->

        <!-- Cartão usuário inexistente-->
        <section id="myProfileSection" class="row" style="width: 100%">
            <div id="profilePictureArea" class="col-md-4">
                <h1>Usuário inexistente</h1>
                <br>
                <img src="../../assets/images/users/no_picture.jpg" alt="Imagem de perfil" class="rounded-image"
                     id="profileImage">
                <br>
                <h3>Avaliação</h3>
                <p> ??? </p>
            </div>

            <div id="editProfileInformation" class="col-md-8">
                <h1 class="formTitle d-inline">Erro!</h1>
                <div id="myForms" class="row">
                    <div class="d-none d-md-block col-md-4">
                        <img src="../../assets/images/user_not_found.png" alt="Ícone de personagem procurando um usuário" class="img-fluid">
                    </div>

                    <div class="col-12 col-md-8">
                        <div class="container">
                            <h1>Usuário não foi encontrado</h1>
                            <p>Ops! Parece que o usuário que você está procurando não existe, ou você informou a url do usuário errada. Tente novamente com outro link.</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- Cartão usuário inexistente fim -->

        <!-- footer -->
        <footer id="myMainFooter">
            <div id="myMainFooterContainer" class="container-fluid">
                <div class="my-main-footer-logo">
                    <img src="../../assets/images/dumb-footer.png" alt="Tá por Aqui" class="my-footer-img">
                </div>
                <div class="my-main-footer-institutional">
                    <p>INSTITUCIONAL</p>
                    <a href="../ComoFunciona/sobreNos%20old.php">Quem Somos</a> <br>
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
        <!-- /footer -->

    <div id="mobileBottomNavbarSection-spacer"></div>
    <section id="mobileBottomNavbarSection" class="d-fixed d-sm-none">
        <div class="container-fluid">
            <div class="row">
                <div class="col mobile-navbar-item">
                    <a href="../Home/home.php">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M25.333 29.3332H6.66634C5.92996 29.3332 5.33301 28.7363 5.33301 27.9999V15.2186C5.33301 14.865 5.47361 14.5259 5.72367 14.2759L15.057 4.94256C15.3071 4.69219 15.6465 4.55151 16.0003 4.55151C16.3542 4.55151 16.6936 4.69219 16.9437 4.94256L26.277 14.2759C26.5273 14.5256 26.6675 14.865 26.6663 15.2186V27.9999C26.6663 28.7363 26.0694 29.3332 25.333 29.3332ZM13.333 19.9999H18.6663V26.6666H23.9997V15.7706L15.9997 7.77056L7.99967 15.7706V26.6666H13.333V19.9999Z" fill="#888F98"/>
                        </svg>

                        <p>Home</p>
                    </a>
                </div>
                <div class="col mobile-navbar-item ">
                    <a href="../Chat/chat.php">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.7351 23.7713L11.6065 24.2371C12.9568 24.959 14.4648 25.3356 15.996 25.3333L16 25.3333C21.1548 25.3333 25.3333 21.1548 25.3333 16C25.3333 10.8452 21.1548 6.66667 16 6.66667C10.8452 6.66667 6.66668 10.8452 6.66668 16V16.004C6.66437 17.5352 7.04097 19.0432 7.76289 20.3935L8.22873 21.2649L7.51244 24.4876L10.7351 23.7713ZM4.00001 28L5.41121 21.6508C4.48185 19.9125 3.99705 17.9712 4.00001 16C4.00001 9.3724 9.37241 4 16 4C22.6276 4 28 9.3724 28 16C28 22.6276 22.6276 28 16 28C14.0288 28.003 12.0875 27.5181 10.3492 26.5888L4.00001 28Z" fill="#888F98"/>
                        </svg>

                        <p>Chat</p>
                    </a>
                </div>

                <?php if($isProvider){ ?>
                    <div class="col mobile-navbar-item getting-out">
                        <a href="./CriacaoServico/criar_servico.php">

                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20.5714 9.85714H14.1429V3.42857C14.1429 2.63973 13.5031 2 12.7143 2H11.2857C10.4969 2 9.85714 2.63973 9.85714 3.42857V9.85714H3.42857C2.63973 9.85714 2 10.4969 2 11.2857V12.7143C2 13.5031 2.63973 14.1429 3.42857 14.1429H9.85714V20.5714C9.85714 21.3603 10.4969 22 11.2857 22H12.7143C13.5031 22 14.1429 21.3603 14.1429 20.5714V14.1429H20.5714C21.3603 14.1429 22 13.5031 22 12.7143V11.2857C22 10.4969 21.3603 9.85714 20.5714 9.85714Z" fill="white"/>
                            </svg>
                        </a>
                    </div>
                <?php } ?>

                <div class="col mobile-navbar-item">
                    <a href="../EncontrarProfissional/Listagem/listagem.php">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.0005 29.3335C13.9845 29.3391 11.9941 28.883 10.1818 28.0001C9.51852 27.6775 8.88303 27.3006 8.28179 26.8734L8.09912 26.7401C6.44555 25.5196 5.09362 23.9364 4.14713 22.1121C3.16811 20.2239 2.66034 18.127 2.66706 16.0001C2.66706 8.63628 8.63666 2.66675 16.0005 2.66675C23.3643 2.66675 29.3339 8.63628 29.3339 16.0001C29.3405 18.1259 28.8332 20.2219 27.8551 22.1094C26.9099 23.9327 25.5599 25.5153 23.9085 26.7361C23.2855 27.1921 22.6244 27.5936 21.9325 27.9361L21.8258 27.9894C20.0124 28.877 18.0195 29.3368 16.0005 29.3335ZM16.0005 22.6667C14.0024 22.6628 12.1707 23.7788 11.2578 25.5561C14.2463 27.0363 17.7546 27.0363 20.7431 25.5561V25.5494C19.8291 23.7741 17.9973 22.6606 16.0005 22.6667ZM16.0005 20.0001C18.8886 20.0039 21.5517 21.5602 22.9725 24.0747L22.9925 24.0574L23.0111 24.0414L22.9885 24.0614L22.9751 24.0721C26.3471 21.1589 27.5528 16.4565 25.9987 12.2802C24.4445 8.10392 20.4579 5.33384 16.0018 5.33384C11.5457 5.33384 7.55912 8.10392 6.00493 12.2802C4.45074 16.4565 5.65646 21.1589 9.02846 24.0721C10.4501 21.5588 13.1129 20.0036 16.0005 20.0001ZM16.0005 18.6667C13.0549 18.6667 10.6671 16.2789 10.6671 13.3334C10.6671 10.3879 13.0549 8.00008 16.0005 8.00008C18.946 8.00008 21.3338 10.3879 21.3338 13.3334C21.3338 14.7479 20.7719 16.1045 19.7717 17.1047C18.7715 18.1048 17.4149 18.6667 16.0005 18.6667ZM16.0005 10.6667C14.5277 10.6667 13.3338 11.8607 13.3338 13.3334C13.3338 14.8062 14.5277 16.0001 16.0005 16.0001C17.4732 16.0001 18.6671 14.8062 18.6671 13.3334C18.6671 11.8607 17.4732 10.6667 16.0005 10.6667Z" fill="#888F98"/>
                        </svg>


                        <p>Pesquisar</p>
                    </a>
                </div>
                <div class="col mobile-navbar-item active">
                    <a href="./meu_perfil.php">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.33301 10.6667C9.33301 6.98477 12.3178 4 15.9997 4C19.6816 4 22.6663 6.98477 22.6663 10.6667C22.6663 14.3486 19.6816 17.3333 15.9997 17.3333C12.3178 17.3333 9.33301 14.3486 9.33301 10.6667ZM15.9997 14.6667C18.2088 14.6667 19.9997 12.8758 19.9997 10.6667C19.9997 8.45753 18.2088 6.66667 15.9997 6.66667C13.7905 6.66667 11.9997 8.45753 11.9997 10.6667C11.9997 12.8758 13.7905 14.6667 15.9997 14.6667Z" fill="#888F98"/>
                            <path d="M8.4572 21.7909C6.45681 23.7912 5.33301 26.5044 5.33301 29.3333H7.99967C7.99967 27.2116 8.84253 25.1768 10.3428 23.6765C11.8431 22.1762 13.8779 21.3333 15.9997 21.3333C18.1214 21.3333 20.1562 22.1762 21.6565 23.6765C23.1568 25.1768 23.9997 27.2116 23.9997 29.3333H26.6663C26.6663 26.5044 25.5425 23.7912 23.5421 21.7909C21.5418 19.7905 18.8286 18.6667 15.9997 18.6667C13.1707 18.6667 10.4576 19.7905 8.4572 21.7909Z" fill="#888F98"/>
                        </svg>


                        <p>Perfil</p>
                    </a>
                </div>
            </div>
        </div>
    </section>
    </body>
    </html>

<?php } else { ?>

<!-- HTML normal -->
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tá por aqui - <?=$user->nome_usuario?> <?=$user->sobrenome_usuario?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/global/globalStyles.css">
    <link rel="stylesheet" href="perfil.css">
    <style>
        #profilePictureArea{
            padding: 70px 0 150px 0;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/2a19bde8ca.js" crossorigin="anonymous" defer></script>
    <script src="../../assets/global/globalScripts.js" defer></script>
    <script src="show_services.js" defer></script>
</head>

<body>
    <!--NavBar Comeco-->
    <div id="myMainTopNavbarNavBackdrop" class=""></div>
    <nav id="myMainTopNavbar" class="navbar navbar-expand-md">
        <div class="container-fluid">
            <a href="../Home/home.php" id="myMainTopNavbarBrand" class="navbar-brand">
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
                        <a href="../ComoFunciona/comoFunciona.php" class="nav-link">Sobre</a>
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
                            <a class="dropdown-item" href="meu_perfil.php">Perfil</a>
                            <a class="dropdown-item text-danger" href="../../logic/entrar_logoff.php">Sair</a>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
    </nav>
    <!--NavBar Fim-->

    <!-- Cartão do perfil comeco-->
    <section id="myProfileSection" class="row" style="width: 100%">
        <div id="profilePictureArea" class="col-md-4">
            <h1>Foto de perfil</h1>
            <br>
            <img src="../../assets/images/users/<?=$user->imagem_usuario?>" alt="Imagem de perfil" class="rounded-image"
                 id="profileImage">

            <?php if($user->classif_usuario != 0) { ?>
                <br>
                <h3>Avaliação</h3>
                <?php if($user->nota_media_usuario === null) {
                    echo "<p class='text-secondary'>O usuário ainda não foi avaliado</p>";
                } else {?>
                    <h4 style="color: #309A6D"><?=$user->nota_media_usuario?></h4>
                    <div>
                        <?php for ($i = 1; $i <= 5; $i++) {
                            if ($i <= round($user->nota_media_usuario)) {
                                echo '<svg class="provider-rate-star" width="25" height="25" viewBox="0 0 17 14" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8.44497 0.28627L10.3449 5.38246L10.3691 5.44752H10.4386H16.649L11.618 8.56749L11.5484 8.61066L11.577 8.68741L13.4668 13.7566L8.49847 10.6106L8.44497 10.5767L8.39147 10.6106L3.42316 13.7566L5.31298 8.68741L5.34132 8.61139L5.27278 8.56799L0.344844 5.44752H6.45139H6.52083L6.54509 5.38246L8.44497 0.28627Z" fill="#FF9839" stroke="black" stroke-width="0.2"></path>
                                      </svg>';
                            } else {
                                echo '<svg class="provider-rate-star" width="25" height="25" viewBox="0 0 17 14" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8.44497 0.28627L10.3449 5.38246L10.3691 5.44752H10.4386H16.649L11.618 8.56749L11.5484 8.61066L11.577 8.68741L13.4668 13.7566L8.49847 10.6106L8.44497 10.5767L8.39147 10.6106L3.42316 13.7566L5.31298 8.68741L5.34132 8.61139L5.27278 8.56799L0.344844 5.44752H6.45139H6.52083L6.54509 5.38246L8.44497 0.28627Z" fill="#AAAA" stroke="black" stroke-width="0.2"></path>
                                      </svg>';
                            }
                        }?>
                    </div>
                <?php }?>
            <?php } else {
                echo "<p class='text-secondary mt-2'>Esse usuário é um cliente</p>";
            }?>
        </div>

        <div id="editProfileInformation" class="col-md-8">
            <h1 class="formTitle d-inline">Perfil</h1>
                <div id="myForms" class="row">
                    <div class="col-md-6">
                        <label for="userName">Nome</label> <br>
                        <input type="text" class="form-control" name="userName" id="userName" readonly
                            value="<?=$user->nome_usuario?>">

                        <br>

                        <label for="userLastName">Sobrenome</label> <br>
                        <input type="text" class="form-control" name="userLastName" id="userLastName"
                            readonly value="<?=$user->sobrenome_usuario?>">

                        <br>

                        <label for="userCell">Celular</label> <br>
                        <input type="text" class="form-control" name="userCell" id="userCell" readonly
                            value="<?=$user->fone_usuario?>" placeholder="usuário sem telefone de contato">

                    </div>

                    <div class="col-md-6 mt-3 mt-md-0">

                        <label for="userContactEmail">Email de contato</label> <br>
                        <input type="text" class="form-control" id="userContactEmail" name="userContactEmail" readonly maxlength="40"
                               value="<?=$user->email_contato_usuario?>" placeholder="usuário sem email de contato">

                        <br>

                        <label for="userDescription">Descrição</label> <br>
                        <textarea name="userDescription" class="form-control" id="userDescription" placeholder="O usuário não colocou nenhuma descrição"
                            readonly><?=$user->desc_usuario?></textarea>
                    </div>
                </div>
        </div>
    </section>
    <!-- Cartão do perfil fim -->

    <!-- Div de redes sociais -->
    <section id="socialMedia">
        <div class="container">

            <div class="myContent">
                <h1>Redes sociais</h1>

                <form>
                    <div class="row d-flex justify-content-center">
                        <?php
                        if ($userSocialMedia[0]->link_rede_social != "" || $userSocialMedia[1]->link_rede_social != "" || $userSocialMedia[2]->link_rede_social != "" || $userSocialMedia[3]->link_rede_social != ""){
                            foreach ($userSocialMedia as $media) {

                                if($media->nick_rede_social === null){
                                    continue;
                                }
                            ?>
                                <div class="col-md-3 col-6 mt-3 d-flex flex-column align-items-center">
                                    <a target="_blank" href="<?=$media->link_rede_social?>"><i class="mb-3 fab fa-<?=$media->rede_social?> ativa"></i></a>
                                    <a target="_blank" href="<?=$media->link_rede_social?>" class="mediaLink ativa"><?=$media->nick_rede_social?></a>
                                </div>
                            <?php
                            }
                        } else {?>
                            <div class="col-12 mt-3">
                                <p class="text-light">
                                    O usuário não adicionou nenhuma rede social até o momento
                                </p>
                            </div>
                        <?php }?>
                    </div>
                </form>
            </div>

        </div>
    </section>
    <!-- Div de redes sociais fim-->

    <?php if($user->classif_usuario == 1 || $user->classif_usuario == 2) { ?>
    <!-- Div serviços disponibilizados -->
    <section id="availableServices">
        <div class="container">

            <div class="myContent mb-3">
                <h1>Serviços disponibilizados</h1>

                <div class="row d-flex justify-content-center" id="serviceCards">

                    <?php if( count($userServices) !== 0 ) {
                        foreach ($userServices as $key => $service) {
                            if ($key == 3){
                                break;
                            }
                    ?>
                            <div class="col-lg-4 col-sm-6 mt-3">
                                <div class="card myCard mx-3">
                                    <div class="card-header myCardHeader">
                                        Serviço <?= $service->tipo_servico == 0 ? "remoto" : "presencial" ?>
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title"><?=$service->nome_servico?></h3>
                                        <p class="card-text">
                                            <strong>Informações básicas:</strong> <br>
                                            <strong>Orçamento:</strong> R$ <?=$service->orcamento_servico?> <?=$service->crit_orcamento_servico?> <br>
                                            <?php if($service->tipo_servico == 1) {?>
                                                <strong>Localização:</strong> <?=$user->cidade_usuario?>, <?=$user->uf_usuario?>
                                            <?php } else {?>
                                                <strong>Serviço remoto</strong>
                                            <?php
                                            }?>
                                        </p>
                                        <a href="../EncontrarProfissional/VisualizarServico/visuaizarServico.php?serviceID=<?=$service->id_servico?>" class="btn myCardButton">+ detalhes</a>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                    } else {?>
                        <div class="col-12 mt-3">
                            <p class="text-info text-center">
                                O prestador ainda não adicionou nenhum serviço
                            </p>
                        </div>
                    <?php }?>
                </div>
            </div>

            <?php if(count($userServices) > 3) {?>
                <button type="button" class="showServicesButtons mr-4 mb-4" id="showAllAvailableServices" onclick="showAllServices('availableServices', <?=$_GET['id']?>)">Todos os serviços</button>
            <?php }?>
        </div>
    </section>
    <!-- Fim serviços disponibilizados -->

    <!-- Modal de mostrar todos os serviços -->
    <div class="modal fade" id="showAllServicesModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" id="showAllServicesModalContent">

            <!-- conteúdo inserido dinamicamente -->

        </div>
    </div>
    <?php } ?>

    <!-- footer -->
    <footer id="myMainFooter">
        <div id="myMainFooterContainer" class="container-fluid">
            <div class="my-main-footer-logo">
                <img src="../../assets/images/dumb-footer.png" alt="Tá por Aqui" class="my-footer-img">
            </div>
            <div class="my-main-footer-institutional">
                <p>INSTITUCIONAL</p>
                <a href="../ComoFunciona/sobreNos%20old.php">Quem Somos</a> <br>
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
    <!-- /footer -->

    <div id="mobileBottomNavbarSection-spacer"></div>
    <section id="mobileBottomNavbarSection" class="d-fixed d-sm-none">
        <div class="container-fluid">
            <div class="row">
                <div class="col mobile-navbar-item">
                    <a href="../Home/home.php">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M25.333 29.3332H6.66634C5.92996 29.3332 5.33301 28.7363 5.33301 27.9999V15.2186C5.33301 14.865 5.47361 14.5259 5.72367 14.2759L15.057 4.94256C15.3071 4.69219 15.6465 4.55151 16.0003 4.55151C16.3542 4.55151 16.6936 4.69219 16.9437 4.94256L26.277 14.2759C26.5273 14.5256 26.6675 14.865 26.6663 15.2186V27.9999C26.6663 28.7363 26.0694 29.3332 25.333 29.3332ZM13.333 19.9999H18.6663V26.6666H23.9997V15.7706L15.9997 7.77056L7.99967 15.7706V26.6666H13.333V19.9999Z" fill="#888F98"/>
                        </svg>

                        <p>Home</p>
                    </a>
                </div>
                <div class="col mobile-navbar-item ">
                    <a href="../Chat/chat.php">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.7351 23.7713L11.6065 24.2371C12.9568 24.959 14.4648 25.3356 15.996 25.3333L16 25.3333C21.1548 25.3333 25.3333 21.1548 25.3333 16C25.3333 10.8452 21.1548 6.66667 16 6.66667C10.8452 6.66667 6.66668 10.8452 6.66668 16V16.004C6.66437 17.5352 7.04097 19.0432 7.76289 20.3935L8.22873 21.2649L7.51244 24.4876L10.7351 23.7713ZM4.00001 28L5.41121 21.6508C4.48185 19.9125 3.99705 17.9712 4.00001 16C4.00001 9.3724 9.37241 4 16 4C22.6276 4 28 9.3724 28 16C28 22.6276 22.6276 28 16 28C14.0288 28.003 12.0875 27.5181 10.3492 26.5888L4.00001 28Z" fill="#888F98"/>
                        </svg>

                        <p>Chat</p>
                    </a>
                </div>

                <?php if($isProvider){ ?>
                    <div class="col mobile-navbar-item getting-out">
                        <a href="./CriacaoServico/criar_servico.php">

                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20.5714 9.85714H14.1429V3.42857C14.1429 2.63973 13.5031 2 12.7143 2H11.2857C10.4969 2 9.85714 2.63973 9.85714 3.42857V9.85714H3.42857C2.63973 9.85714 2 10.4969 2 11.2857V12.7143C2 13.5031 2.63973 14.1429 3.42857 14.1429H9.85714V20.5714C9.85714 21.3603 10.4969 22 11.2857 22H12.7143C13.5031 22 14.1429 21.3603 14.1429 20.5714V14.1429H20.5714C21.3603 14.1429 22 13.5031 22 12.7143V11.2857C22 10.4969 21.3603 9.85714 20.5714 9.85714Z" fill="white"/>
                            </svg>
                        </a>
                    </div>
                <?php } ?>

                <div class="col mobile-navbar-item">
                    <a href="../EncontrarProfissional/Listagem/listagem.php">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.0005 29.3335C13.9845 29.3391 11.9941 28.883 10.1818 28.0001C9.51852 27.6775 8.88303 27.3006 8.28179 26.8734L8.09912 26.7401C6.44555 25.5196 5.09362 23.9364 4.14713 22.1121C3.16811 20.2239 2.66034 18.127 2.66706 16.0001C2.66706 8.63628 8.63666 2.66675 16.0005 2.66675C23.3643 2.66675 29.3339 8.63628 29.3339 16.0001C29.3405 18.1259 28.8332 20.2219 27.8551 22.1094C26.9099 23.9327 25.5599 25.5153 23.9085 26.7361C23.2855 27.1921 22.6244 27.5936 21.9325 27.9361L21.8258 27.9894C20.0124 28.877 18.0195 29.3368 16.0005 29.3335ZM16.0005 22.6667C14.0024 22.6628 12.1707 23.7788 11.2578 25.5561C14.2463 27.0363 17.7546 27.0363 20.7431 25.5561V25.5494C19.8291 23.7741 17.9973 22.6606 16.0005 22.6667ZM16.0005 20.0001C18.8886 20.0039 21.5517 21.5602 22.9725 24.0747L22.9925 24.0574L23.0111 24.0414L22.9885 24.0614L22.9751 24.0721C26.3471 21.1589 27.5528 16.4565 25.9987 12.2802C24.4445 8.10392 20.4579 5.33384 16.0018 5.33384C11.5457 5.33384 7.55912 8.10392 6.00493 12.2802C4.45074 16.4565 5.65646 21.1589 9.02846 24.0721C10.4501 21.5588 13.1129 20.0036 16.0005 20.0001ZM16.0005 18.6667C13.0549 18.6667 10.6671 16.2789 10.6671 13.3334C10.6671 10.3879 13.0549 8.00008 16.0005 8.00008C18.946 8.00008 21.3338 10.3879 21.3338 13.3334C21.3338 14.7479 20.7719 16.1045 19.7717 17.1047C18.7715 18.1048 17.4149 18.6667 16.0005 18.6667ZM16.0005 10.6667C14.5277 10.6667 13.3338 11.8607 13.3338 13.3334C13.3338 14.8062 14.5277 16.0001 16.0005 16.0001C17.4732 16.0001 18.6671 14.8062 18.6671 13.3334C18.6671 11.8607 17.4732 10.6667 16.0005 10.6667Z" fill="#888F98"/>
                        </svg>


                        <p>Pesquisar</p>
                    </a>
                </div>
                <div class="col mobile-navbar-item active">
                    <a href="./meu_perfil.php">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.33301 10.6667C9.33301 6.98477 12.3178 4 15.9997 4C19.6816 4 22.6663 6.98477 22.6663 10.6667C22.6663 14.3486 19.6816 17.3333 15.9997 17.3333C12.3178 17.3333 9.33301 14.3486 9.33301 10.6667ZM15.9997 14.6667C18.2088 14.6667 19.9997 12.8758 19.9997 10.6667C19.9997 8.45753 18.2088 6.66667 15.9997 6.66667C13.7905 6.66667 11.9997 8.45753 11.9997 10.6667C11.9997 12.8758 13.7905 14.6667 15.9997 14.6667Z" fill="#888F98"/>
                            <path d="M8.4572 21.7909C6.45681 23.7912 5.33301 26.5044 5.33301 29.3333H7.99967C7.99967 27.2116 8.84253 25.1768 10.3428 23.6765C11.8431 22.1762 13.8779 21.3333 15.9997 21.3333C18.1214 21.3333 20.1562 22.1762 21.6565 23.6765C23.1568 25.1768 23.9997 27.2116 23.9997 29.3333H26.6663C26.6663 26.5044 25.5425 23.7912 23.5421 21.7909C21.5418 19.7905 18.8286 18.6667 15.9997 18.6667C13.1707 18.6667 10.4576 19.7905 8.4572 21.7909Z" fill="#888F98"/>
                        </svg>


                        <p>Perfil</p>
                    </a>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
<?php } ?>