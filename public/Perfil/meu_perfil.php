<?php
session_start();

if( empty($_SESSION) ){
    header('Location: ../Home/home.php');
}

require "../../logic/DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

//Puxando os dados do meu perfil do banco de dados
$query = "SELECT * FROM usuarios where id_usuario = " . $_SESSION['idUsuario'];
$stmt = $con->query($query);
$user = $stmt->fetch(PDO::FETCH_OBJ);

//puxando as redes sociais do banco de dados
$query2 = "SELECT rede_social, nome_usuario, link_perfil FROM usuario_redes_sociais WHERE id_usuario = " . $_SESSION['idUsuario'];
$stmt = $con->query($query2);
$userSocialMedia = $stmt->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://kit.fontawesome.com/2a19bde8ca.js" crossorigin="anonymous" defer></script>

    <title>Tá por aqui - Meu perfil</title>

    <link rel="stylesheet" href="../../assets/bootstrap/bootstrap-4.5.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/global/globalStyles.css">
    <link rel="stylesheet" href="perfil.css">

    <script src="../../assets/bootstrap/jquery-3.5.1.slim.min.js" defer></script>
    <script src="../../assets/bootstrap/popper.min.js" defer></script>
    <script src="../../assets/bootstrap/bootstrap-4.5.3-dist/js/bootstrap.min.js" defer></script>
    <script src="../../assets/jQueyMask/jquery.mask.js" defer></script>

    <script src="../../assets/global/globalScripts.js" defer></script>

    <script src="perfil_prestador.js" defer></script>
</head>

<body>
    <!--NavBar Comeco-->
    <div id="myMainTopNavbarNavBackdrop" class=""></div>
    <nav id="myMainTopNavbar" class="navbar navbar-expand-md">
        <a href="../Home/home.php" class="navbar-brand">
            <img src="../../assets/images/dumb-brand.png" alt="Tá por aqui" class="my-brand-img">
        </a>

        <button id="myMainTopNavbarToggler" class="navbar-toggler" type="button" data-toggle="collapse"
            data-target="#myMainTopNavbarNav" aria-controls="navbarNav" aria-expanded="false"
            aria-label="Toggle navigation">
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
                    <a href="../EncontrarProfissional/Listagem/listagem.php" class="nav-link">Encontre um
                        pofissional</a>
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
            </ul>

            <div class="dropdown">
                <img src="../../assets/images/profile_images/<?=$_SESSION['imagemPerfil']?>" alt="imagem de perfil" id="profileMenu"
                    class="img-fluid" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <div class="dropdown-menu" aria-labelledby="profileMenu">
                    <a class="dropdown-item" href="meu_perfil.php">Perfil</a>
                    <a class="dropdown-item text-danger" href="../../logic/entrar_logoff.php">Sair</a>
                </div>
            </div>
        </div>
    </nav>
    <!--NavBar Fim-->

    <!-- Cartão do perfil comeco-->
    <section id="myProfileSection" class="row">
        <div id="profilePictureArea" class="col-md-4">
            <h1>Foto de perfil</h1>
            <br>
            <img src="../../assets/images/profile_images/<?=$user->imagem_perfil?>" alt="Imagem de perfil" class="rounded-image"
                 id="profileImage">
            <br>

            <!-- Alerta fechável de erro -->
            <? if(isset($_GET['erro'])) {?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <strong>Erro!</strong> <?= $_GET['erro'] ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?}?>

            <!-- Botão menu de alterar foto -->
            <button type="button" id="profilePicMenu" data-toggle="modal" data-target="#profilePicMenuModal"> <i class="fas fa-pen"></i> Editar foto </button>

            <!-- Menu de alterar foto -->
            <div class="modal fade" id="profilePicMenuModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edite sua foto de perfil</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <form id="changeProfilePic" action="../../logic/perfil_alterar_imagem.php" method="POST" enctype="multipart/form-data">
                                <label for="newProfilePic" id="newProfilePicLabel"> <i class="fas fa-upload"></i> Enviar uma nova foto</label>
                                <input type="file" class="d-none" name="newProfilePic" id="newProfilePic" onchange="editprofileImage(this)" accept="image/png, image/jpeg, image/jpg">

                                <div id="postSelectedImageInformation" class="d-none">
                                    <!-- exibir preview das imagens -->
                                    <small id="obsImgPreview"></small>
                                    <div id="divImgPreview">

                                        <!-- preview de imagem aki -->

                                    </div>

                                    <div id="NewProfileImageButtons">
                                        <button type="submit" class="btn btn-primary mt-2" id="saveNewProfileImage"> Salvar imagem </button>
                                        <button type="button" class="btn btn-danger mt-2" id="cancelNewProfileImage" onclick="location.reload()"> Cancelar mudanças </button>
                                    </div>
                                </div>
                            </form>

                            <hr class="removeImageItem">

                            <button id="removeProfilePic" class="removeImageItem btn-block" onclick="confirmRemoveImage('../../logic/perfil_remover_imagem.php')"> <i class="fas fa-trash"></i> Remover foto atual</button>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <h3>Avaliação</h3>
            <p> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i
                    class="fas fa-star"></i> <i class="fas fa-star"></i> </p>
        </div>

        <div id="editProfileInformation" class="col-md-8">
            <h1 class="formTitle d-inline">Edição de perfil</h1>
            <form action="../../logic/perfil_alterar_informacoes.php" method="POST">
                <div id="myForms" class="row">

                    <div class="col-md-6">
                        <label for="userName">Nome</label> <br>
                        <input type="text" class="form-control" name="userName" id="userName" class="mb-4" readonly required
                            value="<?=$user->nome?>">

                        <br>

                        <label for="userLastName">Sobrenome</label> <br>
                        <input type="text" class="form-control" name="userLastName" id="userLastName" class="mb-4" required
                            readonly value="<?=$user->sobrenome?>">

                        <br>

                        <label for="userCell">Celular</label> <br>
                        <input type="text" class="form-control" name="userCell" id="userCell" class="mb-4" readonly required
                            value="<?=$user->telefone?>">

                        <br>

                        <label for="userPass">Senha</label> <br>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="userPass" readonly
                                value="******">
                            <div class="input-group-append">
                                <button class="input-group-text" id="changePass" data-toggle="modal"
                                    data-target="#changePassModal" onclick="alteraSenha()">Alterar senha</button>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6 mt-3 mt-md-0">
                        <label for="userEmail">Email</label> <br>
                        <input type="text" class="form-control" name="userEmail" id="userEmail" class="mb-4" readonly
                            value="<?=$user->email?>">

                        <br>

                        <label for="userSite">Site</label> <br>
                        <input type="url" class="form-control d-none" name="userSite" id="userSite" class="mb-4" readonly placeholder="Caso tenha, insira seu site ou porfólio online"
                            value="<?=$user->site?>">
                        <div id="showUserSite"><a href="<?=$user->site?>" target="_blank"><?=$user->site?></a></div>

                        <br>

                        <label for="userDescription">Descrição</label> <br>
                        <textarea name="userDescription" class="form-control" id="userDescription" class="mb-4" placeholder="Adicione uma breve descrição sobre você e como trabalha"
                            readonly><?=$user->descricao?></textarea>
                    </div>

                </div>

                <div class="row">
                    <div class="col-lg-6 mb-3" id="divButtonEdit">
                        <button type="button" id="buttonEdit" onclick="changeButtonColor()"> Editar </button>
                    </div>

                    <div class="col-lg-6 mb-3 d-lg-flex flex-row-reverse" id="divButtonSave">
                        <button type="submit" id="buttonSave" class="myDisabled" disabled> Salvar </button> &nbsp;
                        <button type="button" id="buttonCancel" class="myDisabled mt-2 mt-md-0" disabled onclick="location.reload()">
                            Cancelar </button>
                    </div>
                </div>
            </form>

        </div>
    </section>
    <!-- Cartão do perfil fim -->

    <!-- modal esqueci senha -->

    <div class="modal fade" id="changePassModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Mudar senha</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p> Um link para uma  nova senha será enviado para seu email</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- modal esqueci senha fim -->

    <!-- Div de redes sociais -->

    <section id="socialMedia">
        <div class="container">

            <div class="myContent">
                <h1>Redes sociais</h1>

                <form action="../../logic/perfil_alterar_redeSocial.php" method="POST" id="socialMediaForm">
                    <div class="row">
                        <?foreach ($userSocialMedia as $media) {?>
                            <div class="col-6 col-md-3 mt-3 d-flex flex-column align-items-center">
                                <a target="_blank" <?= $media->link_perfil !== null ? "href='$media->link_perfil'" : ""; ?>><i class="mb-3 fab fa-<?=$media->rede_social?> <?= $media->link_perfil !== null ? "ativa" : "inativa"; ?>"></i></a>
                                <a target="_blank" <?= $media->link_perfil !== null ? "href='$media->link_perfil'" : ""; ?> class="mediaLink <?=$media->nome_usuario !== null ? "ativa" : "inativa"?>"><?=$media->nome_usuario !== null ? $media->nome_usuario : "seu nome" ?></a>

                                <input type="text" name="<?=$media->rede_social?>[]" id="<?=$media->rede_social?>Name" class="d-none form-control socialInput <?=$media->rede_social?>" value="<?=$media->nome_usuario?>" placeholder="seu nome">
                                <input type="text" name="<?=$media->rede_social?>[]" id="<?=$media->rede_social?>Link" class="d-none form-control socialInput <?=$media->rede_social?> mt-2" value="<?=$media->link_perfil?>" placeholder="link do perfil">
                            </div>
                        <?}?>
                    </div>
                    <button type="button" class="btn btn-success mt-3 d-none" id="btnSalvarRedes" onclick="verifySocialMedia()">Salvar</button>
                    <button type="button" class="btn btn-outline-danger mt-3 d-none" id="btnCancelarRedes"
                        onclick="location.reload()">Cancelar</button>
                    <small id="socialMediaMsgError" class="d-none text-danger mt-1"></small>
                </form>

            </div>
            <br>
            <button id="socialMediaEdit" onclick="editaRedes()"> Editar as Redes </button>
            <small class="text-info d-none" id="obsRedeSocias">
                As redes sociais que você deixar em branco não aparecerão para quem vizualizar seu perfil.
                <br>
                Caso deseje excluir uma rede social, deixe os campos de nome e link nulos.
            </small>

        </div>
    </section>

    <!-- Div de redes sociais fim-->

<? if($_SESSION['classificacao'] == 1 || $_SESSION['classificacao'] == 2) { ?>

    <!-- div serviços solicitados -->
    <section id="requestedServices">
        <div class="container">

            <div class="myContent">
                <h1>Serviços Solicitados</h1>

                <div class="row" id="requestedCards">
                    <div class="col-lg-4 col-md-6 mt-3">
                        <div class="card myCard2 mx-3">
                            <div class="card-header myCardHeader2">
                                Seu serviço foi solicitado por <a href="#">Roberto</a>
                            </div>
                            <div class="card-body">
                                <h3 class="card-title">Encanamento</h3>
                                <p class="card-text">
                                    Informações básicas: <br>
                                    Orçamento médio: R$80,00 <br>
                                    Localização: Campanário
                                </p>

                                <a href="#" class="text-primary">Mais detalhes</a>

                            </div>
                            <div class="card-footer">
                                <a href="#" class="btn myCardAccept my-1">Aceitar</a>
                                <a href="#" class="btn myCardReject my-1">Rejeitar</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mt-3">
                        <div class="card myCard2 mx-3">
                            <div class="card-header myCardHeader2">
                                Seu serviço foi solicitado por <a href="#">Roberto</a>
                            </div>
                            <div class="card-body">
                                <h3 class="card-title">Encanamento</h3>
                                <p class="card-text">
                                    Informações básicas: <br>
                                    Orçamento médio: R$80,00 <br>
                                    Localização: Campanário
                                </p>

                                <a href="#" class="text-primary">Mais detalhes</a>

                            </div>
                            <div class="card-footer">
                                <a href="#" class="btn myCardAccept my-1">Aceitar</a>
                                <a href="#" class="btn myCardReject my-1">Rejeitar</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mt-3">
                        <div class="card myCard2 mx-3">
                            <div class="card-header myCardHeader2">
                                Seu serviço foi solicitado por <a href="#">Roberto</a>
                            </div>
                            <div class="card-body">
                                <h3 class="card-title"> Encanamento </h3>
                                <p class="card-text">
                                    Informações básicas: <br>
                                    Orçamento médio: R$80,00 <br>
                                    Localização: Campanário <br>
                                </p>
                                <a href="#" class="text-primary">Mais detalhes</a>

                            </div>
                            <div class="card-footer">
                                <div class="alert alert-success" role="alert">
                                    Serviço aceito
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section>
    <!-- Fim serviços solicitados -->

    <!-- Div serviços disponibilizados -->
    <section id="availableServices">
        <div class="container">

            <div class="myContent">
                <h1>Serviços disponibilizados</h1>

                <div class="row" id="serviceCards">
                    <div class="col-lg-4 col-md-6 mt-3">
                        <div class="card myCard mx-3">
                            <div class="card-header myCardHeader">
                                Serviço
                            </div>
                            <div class="card-body">
                                <h3 class="card-title">Encanamento</h3>
                                <p class="card-text">
                                    Informações básicas: <br>
                                    Orçamento médio: R$80,00 <br>
                                    Localização: Campanário
                                </p>
                                <a href="#" class="btn myCardButton">Editar</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mt-3">
                        <div class="card myCard mx-3">
                            <div class="card-header myCardHeader">
                                Serviço
                            </div>
                            <div class="card-body">
                                <h3 class="card-title">Encanamento</h3>
                                <p class="card-text">
                                    Informações básicas: <br>
                                    Orçamento médio: R$80,00 <br>
                                    Localização: Campanário
                                </p>
                                <a href="#" class="btn myCardButton">Editar</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mt-3">
                        <div class="card myCard mx-3">
                            <div class="card-header myCardHeader">
                                Serviço
                            </div>
                            <div class="card-body">
                                <h3 class="card-title">Encanamento</h3>
                                <p class="card-text">
                                    Informações básicas: <br>
                                    Orçamento médio: R$80,00 <br>
                                    Localização: Campanário
                                </p>
                                <a href="#" class="btn myCardButton">Editar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <br><br>

            <a href="CriacaoServico/criar_servico.php" id="addService"> Adicionar serviço <i class="fas fa-plus"></i>
            </a>

        </div>
    </section>

    <!-- Fim serviços disponibilizados -->
<? } ?>

    <!-- div serviços que você solicitou -->
    <section id="servicesRequestedByYou">
        <div class="container">

            <div class="myContent">
                <h1>Serviços que você solicitou</h1>

                <div class="row" id="servicesRequestedByYouCards">
                    <div class="col-lg-4 col-md-6 mt-3">
                        <div class="card myCard2 mx-3">
                            <div class="card-header myCardHeader2">
                                Você solicitou o serviço de <a href="#">Roberto</a>
                            </div>
                            <div class="card-body">
                                <h3 class="card-title">Encanamento</h3>
                                <p class="card-text">
                                    Informações básicas: <br>
                                    Orçamento médio: R$80,00 <br>
                                    Localização: Campanário
                                </p>

                                <a href="#" class="text-primary">Mais detalhes</a>

                            </div>

                            <div class="card-footer">
                                <div class="alert alert-danger" role="alert">
                                    Serviço rejeitado
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mt-3">
                        <div class="card myCard2 mx-3">
                            <div class="card-header myCardHeader2">
                                Você solicitou o serviço de <a href="#">Roberto</a>
                            </div>
                            <div class="card-body">
                                <h3 class="card-title">Encanamento</h3>
                                <p class="card-text">
                                    Informações básicas: <br>
                                    Orçamento médio: R$80,00 <br>
                                    Localização: Campanário
                                </p>

                                <a href="#" class="text-primary">Mais detalhes</a>

                            </div>
                            <div class="card-footer">
                                <div class="alert alert-secondary" role="alert">
                                    Solicitação pendente
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mt-3">
                        <div class="card myCard2 mx-3">
                            <div class="card-header myCardHeader2">
                                Você solicitou o serviço de <a href="#">Roberto</a>
                            </div>
                            <div class="card-body">
                                <h3 class="card-title"> Encanamento </h3>
                                <p class="card-text">
                                    Informações básicas: <br>
                                    Orçamento médio: R$80,00 <br>
                                    Localização: Campanário <br>
                                </p>
                                <a href="#" class="text-primary">Mais detalhes</a>

                            </div>
                            <div class="card-footer">
                                <div class="alert alert-success" role="alert">
                                    Serviço aceito
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section>
    <!-- FIM div serviços que você solicitou -->

    <!-- Div de Serviços contratados recentemente -->
    <section id="recentServices">
        <div class="container">

            <div class="myContent">
                <h1>Histórico de serviços contratados</h1>

                <div class="row" id="recentServicesCards">
                    <div class="col-lg-4 col-md-6 mt-3">
                        <div class="card myCard3 mx-3">
                            <div class="card-header myCardHeader3">
                                Serviço ocorrido em: <strong> 01/05/2020 </strong>
                            </div>
                            <div class="card-body">
                                <h3 class="card-title">Encanamento</h3>
                                <p class="card-text">
                                    Informações básicas: <br>
                                    Orçamento médio: R$80,00 <br>
                                    Localização: Campanário
                                </p>

                                <a href="#" class="text-primary">Mais detalhes</a>
                                <hr>
                                <div class="row">
                                    <div class="col-8">
                                        <a href="#" class="font-weight-bold text-dark"> Natan Silva</a> <br>
                                        (11)912345678
                                    </div>
                                    <div class="col-4">
                                        <img src="../../assets/images/profile_images/teste.jpeg" alt="foto de perfil"
                                             class="recentServicesPic">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mt-3">
                        <div class="card myCard3 mx-3">
                            <div class="card-header myCardHeader3">
                                Serviço ocorrido em: <strong> 01/05/2020 </strong>
                            </div>
                            <div class="card-body">
                                <h3 class="card-title">Encanamento</h3>
                                <p class="card-text">
                                    Informações básicas: <br>
                                    Orçamento médio: R$80,00 <br>
                                    Localização: Campanário
                                </p>

                                <a href="#" class="text-primary">Mais detalhes</a>
                                <hr>
                                <div class="row">
                                    <div class="col-8">
                                        <a href="#" class="font-weight-bold text-dark"> Natan Silva</a> <br>
                                        (11)912345678
                                    </div>
                                    <div class="col-4">
                                        <img src="../../assets/images/profile_images/teste.jpeg" alt="foto de perfil"
                                             class="recentServicesPic">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mt-3">
                        <div class="card myCard3 mx-3">
                            <div class="card-header myCardHeader3">
                                Serviço ocorrido em: <strong> 01/05/2020 </strong>
                            </div>
                            <div class="card-body">
                                <h3 class="card-title">Encanamento</h3>
                                <p class="card-text">
                                    Informações básicas: <br>
                                    Orçamento médio: R$80,00 <br>
                                    Localização: Campanário
                                </p>

                                <a href="#" class="text-primary">Mais detalhes</a>
                                <hr>
                                <div class="row">
                                    <div class="col-8">
                                        <a href="#" class="font-weight-bold text-dark"> Natan Silva</a> <br>
                                        (11)912345678
                                    </div>
                                    <div class="col-4">
                                        <img src="../../assets/images/profile_images/teste.jpeg" alt="foto de perfil"
                                             class="recentServicesPic">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section>
    <!-- Div de Serviços contratados recentemente fim-->

    <!-- Div serviços salvos -->
    <section id="savedServices">
        <div class="container">

            <div class="myContent">
                <h1>Serviços Salvos</h1>

                <div class="row" id="savedCards">
                    <div class="col-lg-4 col-md-6 mt-3">
                        <div class="card myCard mx-3">
                            <div class="card-header myCardHeader">
                                Serviço
                            </div>
                            <div class="card-body">
                                <h3 class="card-title">Encanamento</h3>
                                <p class="card-text">
                                    Informações básicas: <br>
                                    Orçamento médio: R$80,00 <br>
                                    Localização: Campanário
                                </p>
                                <a href="#" class="text-primary">Mais detalhes</a> <br>
                            </div>
                            <div class="card-footer">
                                <a href="#" class="btn myCardReject">Remover</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mt-3">
                        <div class="card myCard mx-3">
                            <div class="card-header myCardHeader">
                                Serviço
                            </div>
                            <div class="card-body">
                                <h3 class="card-title">Encanamento</h3>
                                <p class="card-text">
                                    Informações básicas: <br>
                                    Orçamento médio: R$80,00 <br>
                                    Localização: Campanário
                                </p>
                                <a href="#" class="text-primary">Mais detalhes</a> <br>
                            </div>
                            <div class="card-footer">
                                <a href="#" class="btn myCardReject">Remover</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mt-3">
                        <div class="card myCard mx-3">
                            <div class="card-header myCardHeader">
                                Serviço
                            </div>
                            <div class="card-body">
                                <h3 class="card-title">Encanamento</h3>
                                <p class="card-text">
                                    Informações básicas: <br>
                                    Orçamento médio: R$80,00 <br>
                                    Localização: Campanário
                                </p>
                                <a href="#" class="text-primary">Mais detalhes</a> <br>
                            </div>
                            <div class="card-footer">
                                <a href="#" class="btn myCardReject">Remover</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
    <!-- Div salvos disponibilizados fim -->

    <!-- footer -->
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
        </div>
    </footer>
    <!-- /footer -->
</body>

</html>