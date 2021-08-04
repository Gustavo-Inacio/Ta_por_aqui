<?php
session_start();

//caso haja cookies salvos no pc do usuário, ele vai logar com os cookies salvos
require "../../logic/entrar_cookie.php";

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
$query = "SELECT rede_social, nome_usuario, link_perfil FROM usuario_redes_sociais WHERE id_usuario = " . $_SESSION['idUsuario'];
$stmt = $con->query($query);
$userSocialMedia = $stmt->fetchAll(PDO::FETCH_OBJ);

//puxando os serviços relacionados ao prestador
if($_SESSION['classificacao'] !== 0){
    //serviços disponibilizados
    $query = "SELECT id_servico, nome_servico, tipo, orcamento, data_publicacao FROM servico WHERE prestador = " . $_SESSION['idUsuario'] . " ORDER BY id_servico DESC";
    $stmt = $con->query($query);
    $userServices = $stmt->fetchAll(PDO::FETCH_OBJ);

    //serviços requisitados para esse prestador
    $query = "SELECT * FROM contratos WHERE id_prestador = " . $_SESSION['idUsuario']  . " ORDER BY status_contrato ASC";
    $stmt = $con->query($query);
    $asProviderRequestedServices = $stmt->fetchAll(PDO::FETCH_OBJ);
}
//serviços que você requisitou como cliente
$query = "SELECT * FROM contratos WHERE id_cliente = " . $_SESSION['idUsuario']  . " ORDER BY status_contrato DESC";
$stmt = $con->query($query);
$asClientRequestedServices = $stmt->fetchAll(PDO::FETCH_OBJ);

//serviços que você contratou e foram aceitos
$query = "SELECT * FROM contratos WHERE id_cliente = " . $_SESSION['idUsuario']  . " AND status_contrato = 1 ORDER BY id_contrato DESC";
$stmt = $con->query($query);
$contractedServicesHistory = $stmt->fetchAll(PDO::FETCH_OBJ);

//puxando os serviços salvos
$query = "SELECT * FROM servicos_salvos WHERE id_usuario = " . $_SESSION['idUsuario'];
$stmt = $con->query($query);
$userSavedServices = $stmt->fetchAll(PDO::FETCH_OBJ);
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

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="../../assets/bootstrap/popper.min.js" defer></script>
    <script src="../../assets/bootstrap/bootstrap-4.5.3-dist/js/bootstrap.min.js" defer></script>
    <script src="../../assets/jQueyMask/jquery.mask.js" defer></script>

    <script src="../../assets/global/globalScripts.js" defer></script>

    <script src="perfil_prestador.js" defer></script>
    <script src="show_services.js" defer></script>
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
            <?if($user->nota_media === null) {
                echo "<p class='text-secondary'>O usuário ainda não foi avaliado</p>";
            } else {?>
                <h4 style="color: #309A6D"><?=$user->nota_media?></h4>
                <div>
                    <? for ($i = 1; $i <= 5; $i++) {
                        if ($i <= round($user->nota_media)) {
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
            <?}?>
        </div>

        <div id="editProfileInformation" class="col-md-8">
            <h1 class="formTitle d-inline">Edição de perfil</h1>
            <form action="../../logic/perfil_alterar_informacoes.php" method="POST">
                <div id="myForms" class="row">

                    <div class="col-md-6">
                        <label for="userName">Nome</label> <br>
                        <input type="text" class="form-control" name="userName" id="userName" readonly required
                            value="<?=$user->nome?>">

                        <br>

                        <label for="userLastName">Sobrenome</label> <br>
                        <input type="text" class="form-control" name="userLastName" id="userLastName" required
                            readonly value="<?=$user->sobrenome?>">

                        <br>

                        <label for="userCell">Celular</label> <br>
                        <input type="text" class="form-control" name="userCell" id="userCell" readonly required
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
                        <input type="text" class="form-control" name="userEmail" id="userEmail" readonly
                            value="<?=$user->email?>">

                        <br>

                        <label for="userSite">Site</label> <br>
                        <input type="url" class="form-control d-none" name="userSite" id="userSite" readonly placeholder="Caso tenha, insira seu site ou porfólio online"
                            value="<?=$user->site?>">
                        <div id="showUserSite"><a href="<?=$user->site?>" target="_blank"><?=$user->site?></a></div>

                        <br>

                        <label for="userDescription">Descrição</label> <br>
                        <textarea name="userDescription" class="form-control" id="userDescription" placeholder="Adicione uma breve descrição sobre você e como trabalha"
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

                    <? if( count($asProviderRequestedServices) > 0 ) {
                        foreach ($asProviderRequestedServices as $key => $service) {
                            if ($key == 3){
                                break;
                            }
                            //nome do cliente que solicitou
                            $query = "SELECT nome FROM usuarios WHERE id_usuario = $service->id_cliente";
                            $stmt = $con->query($query);
                            $client_name = $stmt->fetch(PDO::FETCH_OBJ);

                            //detalhes do serviço que foi solicitado
                            $query = "SELECT nome_servico, orcamento FROM servico WHERE id_servico = $service->id_servico";
                            $stmt = $con->query($query);
                            $service_details = $stmt->fetch(PDO::FETCH_OBJ);

                            //data do serviço
                            $date = new DateTime($service->data_contrato);
                            ?>
                            <div class="col-lg-4 col-md-6 mt-3">
                                <div class="card myCard2 mx-3">
                                    <div class="card-header myCardHeader2">
                                        Seu serviço foi solicitado por <a href="perfil.php?id=<?=$service->id_cliente?>"><?=$client_name->nome?></a>
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title"><?=$service_details->nome_servico?></h3>
                                        <p class="card-text">
                                            <strong>Informações básicas:</strong> <br>
                                            <strong>Orçamento:</strong> <?=$service_details->orcamento?><br>
                                            <strong>Data da solicitação:</strong> <?=$date->format('d/m/Y')?>
                                        </p>

                                        <a href="../EncontrarProfissional/VisualizarServico/visuaizarServico.php?serviceID=<?=$service->id_servico?>" class="text-primary">Mais detalhes</a>

                                    </div>
                                    <div class="card-footer">
                                        <?if($service->status_contrato == 0) {?>
                                            <button class="btn myCardAccept my-1" onclick="acceptRejectService('accept', <?=$service->id_contrato?>, '<?=$client_name->nome?>')">Aceitar</button>
                                            <button class="btn myCardReject my-1" onclick="acceptRejectService('reject', <?=$service->id_contrato?>, '<?=$client_name->nome?>')">Rejeitar</button>
                                        <?} else if($service->status_contrato == 1) {?>
                                            <div class="alert alert-success" role="alert">Serviço aceito</div>
                                        <?} else if($service->status_contrato == 2) {?>
                                            <div class="alert alert-danger" role="alert">Serviço rejeitado</div>
                                        <?}?>
                                    </div>
                                </div>
                            </div>
                        <?}
                    } else {?>
                        <div class="col-12 mt-3">
                            <p class="text-info text-center">
                                Por enquanto nenhum serviço seu foi solicitado. Fique atendo às notificações que lhe informaremos quando alguem te contratar!
                            </p>
                        </div>
                    <?}?>
                </div>
            </div>

            <?if(count($asProviderRequestedServices) > 3) {?>
                <button type="button" class="showServicesButtons mt-3" id="showAllAvailableServices" onclick="showAllServices('requestedServices', <?=$_SESSION['idUsuario']?>)">Todos os serviços</button>
            <?}?>
        </div>
    </section>
    <!-- Fim serviços solicitados -->

    <!-- Div serviços disponibilizados -->
    <section id="availableServices">
        <div class="container">

            <div class="myContent mb-3">
                <h1>Serviços disponibilizados</h1>

                <div class="row" id="serviceCards">

                    <? if( count($userServices) > 0 ) {
                        foreach ($userServices as $key => $service) {
                            if ($key == 3){
                                break;
                            }
                    ?>
                            <div class="col-lg-4 col-md-6 mt-3">
                                <div class="card myCard mx-3 availableServiceCards">
                                    <div class="card-header myCardHeader">
                                        Serviço <?= $service->tipo == 0 ? "remoto" : "presencial" ?>
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title"><?=$service->nome_servico?></h3>
                                        <p class="card-text">
                                            <strong>Informações básicas:</strong> <br>
                                            <strong>Orçamento:</strong> <?=$service->orcamento?> <br>
                                            <?if($service->tipo == 1) {?>
                                                <strong>Localização:</strong> <?=$user->cidade?>, <?=$user->estado?>
                                            <?} else {?>
                                                <strong>Serviço remoto</strong>
                                            <?}?>
                                        </p>
                                        <a href="../EncontrarProfissional/VisualizarServico/visuaizarServico.php?serviceID=<?=$service->id_servico?>" class="btn myCardButton">+ detalhes</a>
                                    </div>
                                </div>
                            </div>
                        <?}
                    } else {?>
                        <div class="col-12 mt-3">
                            <p class="text-info text-center">
                                Monetize seus conhecimentos e habilidades agora mesmo. Crie um serviço clicando no botão abaixo
                            </p>
                        </div>
                    <?}?>

                </div>
            </div>

            <?if(count($userServices) > 3) {?>
                <button type="button" class="showServicesButtons mr-4 mb-4" id="showAllAvailableServices" onclick="showAllServices('availableServices', <?=$_SESSION['idUsuario']?>)">Todos os serviços</button>
            <?}?>
            <button id="addService" onclick="location.href='CriacaoServico/criar_servico.php'">Adicionar serviço <i class="fas fa-plus"></i></button>
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

                    <? if( count($asClientRequestedServices) > 0 ) {
                        foreach ($asClientRequestedServices as $key => $service) {
                            if ($key == 3){
                                break;
                            }
                            //nome do cliente que solicitou
                            $query = "SELECT nome FROM usuarios WHERE id_usuario = $service->id_prestador";
                            $stmt = $con->query($query);
                            $provider_name = $stmt->fetch(PDO::FETCH_OBJ);

                            //detalhes do serviço que foi solicitado
                            $query = "SELECT nome_servico, orcamento FROM servico WHERE id_servico = $service->id_servico";
                            $stmt = $con->query($query);
                            $service_details = $stmt->fetch(PDO::FETCH_OBJ);

                            //data do contrato
                            $date = new DateTime($service->data_contrato);
                            ?>
                            <div class="col-lg-4 col-md-6 mt-3">
                                <div class="card myCard2 mx-3">
                                    <div class="card-header myCardHeader2">
                                        Você solicitou o serviço de <a href="perfil.php?id=<?=$service->id_prestador?>"><?=$provider_name->nome?></a>
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title"><?=$service_details->nome_servico?></h3>
                                        <p class="card-text">
                                            <strong>Informações básicas:</strong> <br>
                                            <strong>Orçamento:</strong> <?=$service_details->orcamento?><br>
                                            <strong>Data da solicitação:</strong> <?=$date->format('d/m/Y')?>
                                        </p>

                                        <a href="../EncontrarProfissional/VisualizarServico/visuaizarServico.php?serviceID=<?=$service->id_servico?>" class="text-primary">Mais detalhes</a>

                                    </div>
                                    <div class="card-footer">
                                        <?if($service->status_contrato == 0) {?>
                                            <div class="alert alert-secondary" role="alert">Serviço pendente</div>
                                        <?} else if($service->status_contrato == 1) {?>
                                            <div class="alert alert-success" role="alert">Serviço aceito</div>
                                        <?} else if($service->status_contrato == 2) {?>
                                            <div class="alert alert-danger" role="alert">Serviço rejeitado</div>
                                        <?}?>
                                    </div>
                                </div>
                            </div>
                        <?}
                    } else {?>
                        <div class="col-12 mt-3">
                            <p class="text-info text-center">
                                Você ainda não contratou nenhum serviço. Encontre o melhor serviço para você <a class="text-primary" href="../EncontrarProfissional/Listagem/listagem.php">aqui</a>.
                            </p>
                        </div>
                    <?}?>
                </div>
            </div>
            <?if(count($asClientRequestedServices) > 3) {?>
                <button type="button" class="showServicesButtons mt-3" id="showAllAvailableServices" onclick="showAllServices('servicesRequestedByYou', <?=$_SESSION['idUsuario']?>)">Todos os serviços</button>
            <?}?>
        </div>
    </section>
    <!-- FIM div serviços que você solicitou -->

    <!-- Div de histórico de serviços contrtados -->
    <section id="recentServices">
        <div class="container">

            <div class="myContent">
                <h1>Histórico de serviços contratados</h1>

                <div class="row" id="recentServicesCards">

                    <? if( count($contractedServicesHistory) > 0 ) {
                        foreach ($contractedServicesHistory as $key => $service) {
                            if ($key == 3){
                                break;
                            }
                            //nome, número e foto do prestador que solicitou
                            $query = "SELECT nome, telefone, imagem_perfil, estado, cidade FROM usuarios WHERE id_usuario = $service->id_prestador";
                            $stmt = $con->query($query);
                            $provider_info = $stmt->fetch(PDO::FETCH_OBJ);

                            //detalhes do serviço que foi solicitado
                            $query = "SELECT nome_servico, orcamento, tipo FROM servico WHERE id_servico = $service->id_servico";
                            $stmt = $con->query($query);
                            $service_details = $stmt->fetch(PDO::FETCH_OBJ);

                            //data do contrato
                            $date = new DateTime($service->data_contrato);
                            ?>
                            <div class="col-lg-4 col-md-6 mt-3">
                                <div class="card myCard3 mx-3">
                                    <div class="card-header myCardHeader3">
                                        Serviço contratado em: <strong><?=$date->format('d/m/Y')?></strong>
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title"><?=$service_details->nome_servico?></h3>
                                        <p class="card-text">
                                            <strong>Informações básicas:</strong> <br>
                                            <strong>Orçamento:</strong> <?=$service_details->orcamento?> <br>
                                            <strong>Localização:</strong> <?=$service_details->tipo == 0 ? "Serviço remoto" : $provider_info->estado . ', ' . $provider_info->cidade?>
                                        </p>

                                        <a href="../EncontrarProfissional/VisualizarServico/visuaizarServico.php?serviceID=<?=$service->id_servico?>" class="text-primary">Mais detalhes</a>
                                        <hr>
                                        <div class="row">
                                            <div class="col-12 col-sm-8">
                                                <a href="perfil.php?id=<?=$service->id_prestador?>" class="font-weight-bold text-dark"><?=$provider_info->nome?></a> <br>
                                                <?=$provider_info->telefone?>
                                            </div>
                                            <div class="d-none d-sm-block col-sm-4 ">
                                                <img src="../../assets/images/profile_images/<?=$provider_info->imagem_perfil?>" alt="foto de perfil"
                                                     class="recentServicesPic">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?}
                    } else {?>
                        <div class="col-12 mt-3">
                            <p class="text-info text-center">
                                Você ainda não contratou nenhum serviço. Encontre o melhor serviço para você <a class="text-primary" href="../EncontrarProfissional/Listagem/listagem.php">aqui</a>.
                            </p>
                        </div>
                    <?}?>
                </div>
            </div>
            <?if(count($contractedServicesHistory) > 3) {?>
                <button type="button" class="showServicesButtons mt-3" id="showAllAvailableServices" onclick="showAllServices('recentServices', <?=$_SESSION['idUsuario']?>)">Todos os serviços</button>
            <?}?>
        </div>
    </section>
    <!-- Div de histórico de serviços contrtados-->

    <!-- Div serviços salvos -->
    <section id="savedServices">
        <div class="container">

            <div class="myContent">
                <h1>Serviços Salvos</h1>

                <div class="row" id="savedCards">

                    <? if( count($userSavedServices) > 0 ) {
                        foreach ($userSavedServices as $key => $service) {
                            if ($key == 3){
                                break;
                            }
                            //detalhes do serviço
                            $query = "SELECT nome_servico, tipo, orcamento, data_publicacao FROM servico WHERE id_servico = " . $service->id_servico;
                            $stmt = $con->query($query);
                            $savedService = $stmt->fetch(PDO::FETCH_OBJ);

                            //data do serviço
                            $date = new DateTime($savedService->data_publicacao);
                            ?>

                            <div class="col-lg-4 col-md-6 mt-3">
                                <div class="card myCard mx-3">
                                    <div class="card-header myCardHeader">
                                        Serviço <?= $savedService->tipo == 0 ? "remoto" : "presencial" ?>
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title"><?= $savedService->nome_servico ?></h3>
                                        <p class="card-text">
                                            <strong>Informações básicas:</strong> <br>
                                            <strong>Orçamento:</strong> <?= $savedService->orcamento ?> <br>
                                            <strong>Data de publicação:</strong> <?=$date->format('d/m/Y')?>
                                        </p>
                                        <a href="../EncontrarProfissional/VisualizarServico/visuaizarServico.php?serviceID=<?=$service->id_servico?>" class="text-primary">Mais detalhes</a> <br>
                                    </div>
                                    <div class="card-footer">
                                        <a href="../../logic/perfil_remover_servicosalvo.php?id=<?=$service->id_servico_salvo?>" class="btn myCardReject">Remover</a>
                                    </div>
                                </div>
                            </div>

                        <?}
                    } else {?>
                        <div class="col-12 mt-3">
                            <p class="text-info text-center">
                                Você ainda não salvou nenhum serviço
                            </p>
                        </div>
                    <?}?>
                </div>
            </div>
            <?if(count($userSavedServices) > 3) {?>
                <button type="button" class="showServicesButtons mr-4 mt-2" id="showAllAvailableServices" onclick="showAllServices('savedServices', <?=$_SESSION['idUsuario']?>)">Todos os serviços</button>
            <?}?>
        </div>
    </section>
    <!-- Div salvos salvos fim -->

    <!-- Modal de mostrar todos os serviços -->
    <div class="modal fade" id="showAllServicesModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" id="showAllServicesModalContent">

            <!-- conteúdo inserido dinamicamente -->

        </div>
    </div>

    <!-- modal de confirmar aceitação do serviço -->
    <div class="modal fade" id="confirmAcceptRejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Você tem certeza que deseja <span id="confirmModalChoice"></span> o serviço solicitado por <strong id="confirmModalUserName" class="text-primary"></strong>?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-justify">
                    <p id="confirmModalMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <a id="confirmModalConfirmChoice">Confirmar</a>
                </div>
            </div>
        </div>
    </div>

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