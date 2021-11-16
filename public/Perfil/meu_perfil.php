<?php
session_start();

//caso haja cookies salvos no pc do usuário, ele vai logar com os cookies salvos
require "../../logic/entrar_cookie.php";

if(!isset($_SESSION['idUsuario']) || $_SESSION['idUsuario'] == "" ){
    header('Location: ../Entrar/login.php');
}

require "../../logic/DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

//Puxando os dados do meu perfil do banco de dados
$query = "SELECT * FROM usuarios where id_usuario = " . $_SESSION['idUsuario'];
$stmt = $con->query($query);
$user = $stmt->fetch(PDO::FETCH_OBJ);

$showLocation = $user->mostrar_local_usuario == 1;

//puxando as redes sociais do banco de dados
$query = "SELECT rede_social, nick_rede_social, link_rede_social FROM usuario_redes_sociais WHERE id_usuario = " . $_SESSION['idUsuario'];
$stmt = $con->query($query);
$userSocialMedia = $stmt->fetchAll(PDO::FETCH_OBJ);

$isProvider = false;

if(isset($_SESSION['classificacao']) && $_SESSION['classificacao'] >= 1){
    $isProvider = true;
}

//puxando os serviços relacionados ao prestador
if($_SESSION['classificacao'] !== 0){
    //serviços disponibilizados
    $query = "SELECT id_servico, nome_servico, tipo_servico, crit_orcamento_servico, orcamento_servico, data_public_servico FROM servicos WHERE id_prestador_servico = " . $_SESSION['idUsuario'] . " AND status_servico != 0 AND status_servico != 2 ORDER BY id_servico DESC LIMIT 0,4";
    $stmt = $con->query($query);
    $userServices = $stmt->fetchAll(PDO::FETCH_OBJ);

    //serviços requisitados para esse prestador
    $query = "SELECT * FROM contratos as c join servicos as s on c.id_servico = s.id_servico WHERE c.id_prestador = " . $_SESSION['idUsuario']  . " AND s.status_servico = 1 AND c.status_contrato = 0 ORDER BY c.data_contrato DESC LIMIT 0,4";
    $stmt = $con->query($query);
    $asProviderRequestedServices = $stmt->fetchAll(PDO::FETCH_OBJ);

    //serviços rejeitados ou aceitos por esse prestador
    $query = "SELECT c.id_contrato, c.id_servico, c.id_cliente, c.status_contrato, c.data_contrato, s.nome_servico, s.orcamento_servico, s.crit_orcamento_servico, cli.nome_usuario FROM contratos as c join servicos as s on c.id_servico = s.id_servico join usuarios cli on c.id_cliente = cli.id_usuario WHERE c.id_prestador = " . $_SESSION['idUsuario']  . " AND s.status_servico = 1 AND c.status_contrato in(1,2) ORDER BY c.data_contrato DESC LIMIT 0,4";
    $stmt = $con->query($query);
    $asProviderAcceptReject = $stmt->fetchAll(PDO::FETCH_OBJ);
}
//serviços que você requisitou como cliente
$query = "SELECT * FROM contratos as c join servicos as s on c.id_servico = s.id_servico WHERE c.id_cliente = " . $_SESSION['idUsuario']  . " AND s.status_servico = 1 ORDER BY c.status_contrato DESC, c.data_contrato DESC LIMIT 0,4";
$stmt = $con->query($query);
$asClientRequestedServices = $stmt->fetchAll(PDO::FETCH_OBJ);

//serviços que você contratou e foram aceitos
$query = "SELECT * FROM contratos as c join servicos as s on c.id_servico = s.id_servico WHERE c.id_cliente = " . $_SESSION['idUsuario']  . " AND s.status_servico = 1 AND c.status_contrato = 1 ORDER BY c.data_contrato DESC LIMIT 0,4";
$stmt = $con->query($query);
$contractedServicesHistory = $stmt->fetchAll(PDO::FETCH_OBJ);

//puxando os serviços salvos
$query = "SELECT * FROM servicos_salvos as ss join servicos as s on ss.id_servico = s.id_servico WHERE id_usuario = " . $_SESSION['idUsuario'] . " AND s.status_servico = 1 LIMIT 0,4";
$stmt = $con->query($query);
$userSavedServices = $stmt->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tá por aqui - Meu perfil</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/global/globalStyles.css">
    <link rel="stylesheet" href="perfil.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="../../assets/jQueyMask/jquery.mask.js" defer></script>
    <script src="https://kit.fontawesome.com/2a19bde8ca.js" crossorigin="anonymous" defer></script>
    <script src="../../assets/global/globalScripts.js" defer></script>
    <script src="meu_perfil.js" defer></script>
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
    <section id="myProfileSection" class="row">
        <div id="profilePictureArea" class="col-md-4">
            <h1>Foto de perfil</h1>
            <br>
            <img src="../../assets/images/users/<?=$user->imagem_usuario?>" alt="Imagem de perfil" class="rounded-image"
                 id="profileImage">
            <br>

            <!-- Alerta fechável de erro -->
            <?php if(isset($_GET['erro'])) {?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <strong>Erro!</strong> <?= $_GET['erro'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php }?>

            <!-- Botão menu de alterar foto -->
            <button type="button" id="profilePicMenu" data-bs-toggle="modal" data-bs-target="#profilePicMenuModal"> <i class="fas fa-pen"></i> Editar foto </button>

            <!-- Menu de alterar foto -->
            <div class="modal fade" id="profilePicMenuModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edite sua foto de perfil</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                        <button type="submit" class="mybtn mybtn-conversion mt-2" id="saveNewProfileImage"> Salvar imagem </button>
                                        <button type="button" class="mybtn mybtn-danger mt-2" id="cancelNewProfileImage" onclick="location.reload()"> Cancelar mudanças </button>
                                    </div>
                                </div>
                            </form>

                            <hr class="removeImageItem">

                            <button id="removeProfilePic" class="removeImageItem w-100" onclick="confirmRemoveImage('../../logic/perfil_remover_imagem.php')"> <i class="fas fa-trash"></i> Remover foto atual</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php if($_SESSION['classificacao'] != 0) { ?>
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
            <?php } ?>
        </div>

        <div id="editProfileInformation" class="col-md-8">
            <h1 class="formTitle d-inline">Edição de perfil</h1>

            <?php if (isset($_GET['status'])) {?>
                <!-- alerta de troca bem sucedida -->
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span><?=$_GET['status']?></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php }?>

            <form action="../../logic/perfil_alterar_informacoes.php" method="POST">
                <div id="myForms" class="row">

                    <div class="col-md-6">
                        <label for="userName">Nome</label> <br>
                        <input type="text" class="form-control" name="userName" id="userName" readonly required maxlength="15"
                            value="<?=$user->nome_usuario?>">

                        <br>

                        <label for="userLastName">Sobrenome</label> <br>
                        <input type="text" class="form-control" name="userLastName" id="userLastName" required maxlength="15"
                            readonly value="<?=$user->sobrenome_usuario?>">

                        <br>

                        <label for="userCell">Celular</label> <br>
                        <input type="text" class="form-control" name="userCell" id="userCell" readonly
                            value="<?=$user->fone_usuario?>" placeholder="você não adicionou um número de telefone">

                        <br>

                        <label for="userConfig">Configurações da conta</label> <br>
                        <button type="button" class="btn" id="accountConfigBtn" data-bs-toggle="modal" data-bs-target="#accountConfigModal">Outras configurações</button>

                    </div>

                    <div class="col-md-6 mt-3 mt-md-0">
                        <?php
                        //censurar email
                        $censorStart = substr($user->email_usuario, 0, 4);
                        $censorEnd = substr($user->email_usuario, -3);
                        $userCensoredMail = "$censorStart*****$censorEnd";
                        ?>
                        <label for="userEmail">Email de login</label> <br>
                        <input type="text" class="form-control" id="userEmail" readonly maxlength="40"
                            value="<?=$userCensoredMail?>">

                        <br>

                        <label for="userContactEmail">Email de contato</label> <br>
                        <input type="text" class="form-control" id="userContactEmail" name="userContactEmail" readonly maxlength="40"
                               value="<?=$user->email_contato_usuario?>" placeholder="você não adicionou um email de contato">

                        <br>

                        <label for="userDescription">Descrição</label> <br>
                        <textarea name="userDescription" class="form-control" id="userDescription" placeholder="Adicione uma breve descrição sobre você e como trabalha" maxlength="65535"
                            readonly><?=$user->desc_usuario?></textarea>
                    </div>

                </div>

                <div class="row">
                    <div class="col-lg-6 mb-3" id="divButtonEdit">
                        <button type="button" id="buttonEdit" onclick="changeButtonColor()"> Editar </button>
                    </div>

                    <div class="col-lg-6 mb-3 d-lg-flex flex-row-reverse" id="divButtonSave">
                        <button type="submit" id="buttonSave" class="myDisabled" disabled>Salvar</button> &nbsp;
                        <button type="button" id="buttonCancel" class="myDisabled mt-2 mt-md-0" disabled onclick="location.reload()">Cancelar</button>
                    </div>
                </div>
            </form>

        </div>
    </section>
    <!-- Cartão do perfil fim -->

    <!-- modal de confirgurações de conta -->

    <div class="modal fade" id="accountConfigModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Configurações da conta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="divConfig row">
                        <div class="col-sm-8">
                            <h6>Altere sua senha</h6>
                            <p>Mude sua senha caso você ache que alguém a sabe, ou se ela está muito fraca. mantenha sua conta protegida</p>
                        </div>
                        <div class="col-sm-4 d-flex align-items-center">
                            <button type="button" class="mybtn mybtn-conversion closeConfigModal" id="changePass" data-bs-toggle="modal" data-bs-target="#changePassModal">Alterar senha</button>
                        </div>
                    </div>

                    <hr>

                    <div class="divConfig row">
                        <div class="col-sm-8">
                            <h6>Altere seu email</h6>
                            <p>Mude seu email caso você tenha trocado para um novo.</p>
                        </div>
                        <div class="col-sm-4 d-flex align-items-center">
                            <button type="button" class="mybtn mybtn-complement closeConfigModal" id="changeEmail" data-bs-toggle="modal" data-bs-target="#changeEmailModal">Alterar email</button>
                        </div>
                    </div>

                    <hr>

                    <?php if($_SESSION['classificacao'] == "0") { ?>
                    <div class="divConfig row">
                        <div class="col-sm-8">
                            <h6>Trabalhe em nossa plataforma</h6>
                            <p>Mude sua classificação para virar um prestador em nossa plataforma e publicar seus serviços</p>
                        </div>
                        <div class="col-sm-4 d-flex align-items-center">
                            <button type="button" class="mybtn mybtn-outline-complement closeConfigModal" id="becomeProvider" onclick="becomeProvider('clientToProvider')">Ser prestador</button>
                        </div>
                    </div>

                    <hr>

                    <?php }else { ?>
                    <div class="divConfig row">
                        <div class="col-sm-8">
                            <h6>Não quer mais prestar serviços?</h6>
                            <p>Não tem problema! Continue usando nossa plataforma como apenas um cliente. Seus serviços continuarão em nosso servidores, porém não aparecerão para mais ninguém</p>
                        </div>
                        <div class="col-sm-4 d-flex align-items-center">
                            <button type="button" class="mybtn mybtn-outline-complement closeConfigModal" id="becomeProvider" onclick="becomeProvider('providerToClient')">Ser cliente</button>
                        </div>
                    </div>

                    <hr>
                    <?php } ?>

                    <div class="divConfig row">
                        <div class="col-sm-8">
                            <h6>Mude sua localização</h6>
                            <p>Trocou de moradia e/ou quer marcar para prestar serviços em outro lugar? Vamos ajeitar sua nova localização!</p>
                        </div>
                        <div class="col-sm-4 d-flex align-items-center">
                            <button type="button" class="mybtn mybtn-outline-conversion closeConfigModal" id="changeLocation" onclick="$('#accountConfigModal').modal('hide') ;$('#addressModal').modal('show')">Trocar localização</button>
                        </div>
                    </div>

                    <hr>

                    <div class="divConfig row">
                        <div class="col-sm-8">
                            <h6>Exiba/oculte sua localização</h6>
                            <p>Caso você queira uma maior privacidade no site, deixe sua localização oculta.</p>
                            <p>Caso você seja prestador de serviços e precise mostrar sua localização para as pessoas te encontrarem, deixe a localização exibida.</p>
                        </div>
                        <div class="col-sm-4 d-flex flex-column justify-content-center align-items-center">
                            <label class="switch">
                                <input type="checkbox" <?=$showLocation ? 'checked' : ''?> id="allowShowLocation">
                                <span class="slider round"></span>
                            </label>
                            <?=$showLocation ? '<strong id="allowShowLocationStatus" class="text-success mt-2 text-center">Localização exibida</strong>' : '<strong id="allowShowLocationStatus" class="text-secondary mt-2 text-center">Localização oculta</strong>'?>
                        </div>
                    </div>

                    <hr>

                    <div class="divConfig row">
                        <div class="col-sm-8">
                            <h6 class="text-danger">Excluir conta</h6>
                            <p class="text-danger"><strong>Você tem certeza?</strong> Sua conta será suspensa de nossa plataforma, tornando seu usuário e serviços inacessíveis</p>
                        </div>
                        <div class="col-sm-4 d-flex align-items-center">
                            <button type="button" class="mybtn mybtn-outline-danger closeConfigModal" id="deleteAccount" onclick="deleteAccount()">Excluir conta</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="mybtn mybtn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- modal de confirgurações de conta fim -->

    <!-- modal trocar senha -->

    <div class="modal fade" id="changePassModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Mudar senha</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Você tem certeza que deseja trocar a sua senha?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="location.href='../../logic/perfil_allowChangePass.php'" class="mybtn mybtn-conversion">Tenho!</button>
                    <button type="button" class="mybtn mybtn-secondary" data-bs-dismiss="modal">Deixa pra lá</button>
                </div>
            </div>
        </div>
    </div>

    <!-- modal trocar senha fim -->

    <!-- modal trocar email -->

    <div class="modal fade" id="changeEmailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Trocar de email</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="" id="emailChangeForm">
                    <div class="modal-body">
                        <label for="newEmail" class="mb-2">Insira o seu novo email</label>
                        <input type="text" class="form-control" name="email" id="newEmail">

                        <small class="text-danger" id="msgErro"></small>
                    </div>

                    <div class="modal-footer">
                        <button type="button" id="btnConfirmaTroca" class="mybtn mybtn-conversion" onclick="recebeEmail()">Confirmar troca</button>
                        <button type="reset" class="mybtn mybtn-secondary" data-bs-dismiss="modal">Deixa pra lá</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- modal trocar email fim -->

    <!-- modal confirmar novo email (código) -->

    <div class="modal fade" id="confirmEmailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Trocar de email</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-3">Precisamos ter certeza que você tem acesso ao email que será trocado. Por isso enviamos um código de confirmação para o novo email.</p>
                    <form action="" method="" id="confirmEmailChangeForm">
                        <label for="confirmEmailChangeCode" class="mb-2">Insira o código enviado para o email <strong id="emailSentCode">teste@teste.com</strong> </label>
                        <div class="row">
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="confirmEmailChangeCode" id="confirmEmailChangeCode">
                            </div>

                            <div class="col-sm-3">
                                <button type="button" class="mybtn mybtn-conversion" onclick="confirmEmailChange()">Confirmar</button>
                            </div>
                        </div>
                    </form>

                    <small class="text-danger" id="incorrectCode"></small>
                </div>
            </div>
        </div>
    </div>

    <!-- modal confirmar novo email (código) fim -->

    <!-- modal de trocar de endereço -->

    <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Informações do novo endereço</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- inputs com informações do endereço -->
                <form action="../../logic/perfil_trocar_localizacao.php" method="post" id="changeLocationForm">
                    <div class="modal-body">
                        <button type="button" id="getCurrentLocationBtn" class="btn btn-info text-light w-100 mb-3">Pegar minha localização atual</button>
                        <label for="userAdressCEP" class="myLabel">CEP</label> <br>
                        <input type="text" class="form-control required" name="userAdressCEP" id="userAdressCEP" placeholder="ex.: 01234567" onkeyup="callGetAdress(this)" onchange="callGetAdress(this)" required value="<?=$user->cep_usuario?>">
                        <small id="cepError" class="text-danger"></small>

                        <div class="row mt-3">
                            <div class="col-3">
                                <label for="userAdressState" class="myLabel">Estado</label> <br>
                                <input type="text" class="form-control required mb-3" name="userAdressState" id="userAdressState" readonly data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="autocompletado com o CEP" data-bs-placement="top" required value="<?=$user->uf_usuario?>">
                            </div>
                            <div class="col-9">
                                <label for="userAdressCity" class="myLabel">Cidade</label> <br>
                                <input type="text" class="form-control required mb-3" name="userAdressCity" id="userAdressCity" placeholder="autocompletado com o CEP" readonly required value="<?=$user->cidade_usuario?>">
                            </div>
                        </div>

                        <label for="userAdressNeighborhood" class="myLabel">Bairro</label> <br>
                        <input type="text" class="form-control required mb-3" name="userAdressNeighborhood" id="userAdressNeighborhood" placeholder="Digite seu bairro" required value="<?=$user->bairro_usuario?>">

                        <div class="row">
                            <div class="col-9">
                                <label for="userAdressStreet" class="myLabel">Rua</label> <br>
                                <input type="text" class="form-control required mb-3" name="userAdressStreet" id="userAdressStreet" placeholder="Digite sua rua" required value="<?=$user->rua_usuario?>">
                            </div>
                            <div class="col-3">
                                <label for="userAdressNumber" class="myLabel">Número</label> <br>
                                <input type="number" class="form-control required mb-3" name="userAdressNumber" id="userAdressNumber" maxlength="5" required value="<?=$user->numero_usuario?>">
                            </div>
                        </div>

                        <label for="userAdressComplement" class="myLabel">Complemento</label> <br>
                        <input type="text" class="form-control mb-3" name="userAdressComplement" id="userAdressComplement" placeholder="Digite o complemento (caso tenha)" data-bs-toggle="popover" data-bs-trigger="hover" title="Exemplo" data-bs-content="apto. 24 BL A" data-bs-placement="top" maxlength="20" value="<?=$user->comple_usuario?>">

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="mybtn mybtn-complement">Salvar endereço</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- modal de trocar de endereço fim -->

    <!-- Div de redes sociais -->

    <section id="socialMedia">
        <div class="container">

            <div class="myContent">
                <h1>Redes sociais</h1>

                <form action="../../logic/perfil_alterar_redeSocial.php" method="POST" id="socialMediaForm">
                    <div class="row">
                        <?php foreach ($userSocialMedia as $media) {?>
                            <div class="col-6 col-md-3 mt-3 d-flex flex-column align-items-center">
                                <a target="_blank" <?= $media->link_rede_social !== null ? "href='$media->link_rede_social'" : ""; ?>><i class="mb-3 fab fa-<?=$media->rede_social?> <?= $media->link_rede_social !== null ? "ativa" : "inativa"; ?>"></i></a>
                                <a target="_blank" <?= $media->link_rede_social !== null ? "href='$media->link_rede_social'" : ""; ?> class="mediaLink <?=$media->nick_rede_social !== null ? "ativa" : "inativa"?>"><?=$media->nick_rede_social !== null ? $media->nick_rede_social : "seu nome" ?></a>

                                <input type="text" name="<?=$media->rede_social?>[]" id="<?=$media->rede_social?>Name" class="d-none form-control socialInput <?=$media->rede_social?>" value="<?=$media->nick_rede_social?>" placeholder="seu nome" maxlength="30">
                                <input type="text" name="<?=$media->rede_social?>[]" id="<?=$media->rede_social?>Link" class="d-none form-control socialInput <?=$media->rede_social?> mt-2" value="<?=$media->link_rede_social?>" placeholder="link do perfil" maxlength="60">
                            </div>
                        <?php }?>
                    </div>
                    <button type="button" class="mybtn mybtn-conversion mt-3 d-none" id="btnSalvarRedes" onclick="verifySocialMedia()" style="color: black;">Salvar</button>
                    <button type="button" class="mybtn mybtn-outline-danger mt-3 d-none" id="btnCancelarRedes"
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

    <?php if($_SESSION['classificacao'] == 1 || $_SESSION['classificacao'] == 2) { ?>

    <!-- div serviços solicitados -->
    <section id="requestedServices">
        <div class="container">

            <div class="myContent">
                <h1>Serviços Solicitados</h1>

                <div class="row d-flex justify-content-center" id="requestedCards">

                    <?php if( count($asProviderRequestedServices) > 0 ) {
                        foreach ($asProviderRequestedServices as $key => $service) {
                            if ($key == 3){
                                break;
                            }
                            //nome do cliente que solicitou
                            $query = "SELECT nome_usuario FROM usuarios WHERE id_usuario = $service->id_cliente";
                            $stmt = $con->query($query);
                            $client_name = $stmt->fetch(PDO::FETCH_OBJ);

                            //detalhes do serviço que foi solicitado
                            $query = "SELECT nome_servico, crit_orcamento_servico, orcamento_servico FROM servicos WHERE id_servico = $service->id_servico";
                            $stmt = $con->query($query);
                            $service_details = $stmt->fetch(PDO::FETCH_OBJ);

                            //data do serviço
                            $date = new DateTime($service->data_contrato);
                            ?>
                            <div class="col-lg-4 col-md-6 mt-3">
                                <div class="card myCard2 mx-3">
                                    <div class="card-header myCardHeader2">
                                        Seu serviço foi solicitado por <a href="perfil.php?id=<?=$service->id_cliente?>"><?=$client_name->nome_usuario?></a>
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title"><?=$service_details->nome_servico?></h3>
                                        <p class="card-text">
                                            <strong>Informações básicas:</strong> <br>
                                            <strong>Orçamento:</strong> R$ <?=$service_details->orcamento_servico?> <?=$service_details->crit_orcamento_servico?> <br>
                                            <strong>Data da solicitação:</strong> <?=$date->format('d/m/Y')?>
                                        </p>

                                        <a href="../EncontrarProfissional/VisualizarServico/visuaizarServico.php?serviceID=<?=$service->id_servico?>" class="text-primary">Mais detalhes</a>

                                    </div>
                                    <div class="card-footer">
                                        <?php if($service->status_contrato == 0) {?>
                                            <button class="mybtn mybtn-conversion my-1" onclick="acceptRejectService('accept', <?=$service->id_contrato?>, '<?=$client_name->nome_usuario?>')">Aceitar</button>
                                            <button class="mybtn mybtn-danger my-1" onclick="acceptRejectService('reject', <?=$service->id_contrato?>, '<?=$client_name->nome_usuario?>')">Rejeitar</button>
                                        <?php } else if($service->status_contrato == 1) {?>
                                            <div class="alert alert-success" role="alert">Serviço aceito</div>
                                        <?php } else if($service->status_contrato == 2) {?>
                                            <div class="alert alert-danger" role="alert">Serviço rejeitado</div>
                                        <?php
                                        }?>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                    } else {?>
                        <div class="col-12 mt-3">
                            <p class="text-info text-center">
                                Por enquanto nenhum serviço seu foi solicitado. Fique atendo às notificações que lhe informaremos quando alguem te contratar!
                            </p>
                        </div>
                    <?php }?>
                </div>
            </div>

            <?php if(count($asProviderRequestedServices) > 3) {?>
                <button type="button" class="showServicesButtons mt-3" id="showAllAvailableServices" onclick="showAllServices('requestedServices', <?=$_SESSION['idUsuario']?>)">Todos os serviços</button>
            <?php }?>
        </div>
    </section>
    <!-- Fim serviços solicitados -->

    <!-- Div serviços disponibilizados -->
    <section id="availableServices">
        <div class="container">

            <div class="myContent mb-3">
                <h1>Serviços disponibilizados</h1>

                <div class="row d-flex justify-content-center" id="serviceCards">

                    <?php if( count($userServices) > 0 ) {
                        foreach ($userServices as $key => $service) {
                            if ($key == 3){
                                break;
                            }
                    ?>
                            <div class="col-lg-4 col-md-6 mt-3">
                                <div class="card myCard mx-3 availableServiceCards">
                                    <div class="card-header myCardHeader">
                                        Serviço <?= $service->tipo_servico == 0 ? "remoto" : "presencial" ?>
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title"><?=$service->nome_servico?></h3>
                                        <p class="card-text">
                                            <strong>Informações básicas:</strong> <br>
                                            <strong>Orçamento:</strong> R$ <?=$service->orcamento_servico?> <?=$service->crit_orcamento_servico?> <br>
                                            <?php if($service->tipo_servico == 1) {?>
                                                <strong>Localização: </strong><?=$showLocation ? $user->cidade_usuario . ', ' . $user->uf_usuario : 'você optou por ocultar localização'?>
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
                                Monetize seus conhecimentos e habilidades agora mesmo. Crie um serviço clicando no botão abaixo
                            </p>
                        </div>
                    <?php }?>

                </div>
            </div>

            <?php if(count($userServices) > 3) {?>
                <button type="button" class="showServicesButtons mr-4 mb-4" id="showAllAvailableServices" onclick="showAllServices('availableServices', <?=$_SESSION['idUsuario']?>)">Todos os serviços</button>
            <?php }?>
            <button id="addService" onclick="location.href='CriacaoServico/criar_servico.php'">Adicionar serviço <i class="fas fa-plus"></i></button>
        </div>
    </section>

    <!-- Fim serviços disponibilizados -->
    <?php } ?>

    <!-- div serviços que você solicitou -->
    <section id="servicesRequestedByYou">
        <div class="container">

            <div class="myContent">
                <h1>Serviços que você solicitou</h1>

                <div class="row d-flex justify-content-center" id="servicesRequestedByYouCards">

                    <?php if( count($asClientRequestedServices) > 0 ) {
                        foreach ($asClientRequestedServices as $key => $service) {
                            if ($key == 3){
                                break;
                            }
                            //nome do cliente que solicitou
                            $query = "SELECT nome_usuario FROM usuarios WHERE id_usuario = $service->id_prestador";
                            $stmt = $con->query($query);
                            $provider_name = $stmt->fetch(PDO::FETCH_OBJ);

                            //detalhes do serviço que foi solicitado
                            $query = "SELECT nome_servico, crit_orcamento_servico, orcamento_servico FROM servicos WHERE id_servico = $service->id_servico";
                            $stmt = $con->query($query);
                            $service_details = $stmt->fetch(PDO::FETCH_OBJ);

                            //data do contrato
                            $date = new DateTime($service->data_contrato);
                            ?>
                            <div class="col-lg-4 col-md-6 mt-3">
                                <div class="card myCard2 mx-3">
                                    <div class="card-header myCardHeader2">
                                        Você solicitou o serviço de <a href="perfil.php?id=<?=$service->id_prestador?>"><?=$provider_name->nome_usuario?></a>
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title"><?=$service_details->nome_servico?></h3>
                                        <p class="card-text">
                                            <strong>Informações básicas:</strong> <br>
                                            <strong>Orçamento:</strong> R$ <?=$service_details->orcamento_servico?> <?=$service_details->crit_orcamento_servico?><br>
                                            <strong>Data da solicitação:</strong> <?=$date->format('d/m/Y')?>
                                        </p>

                                        <a href="../EncontrarProfissional/VisualizarServico/visuaizarServico.php?serviceID=<?=$service->id_servico?>" class="text-primary">Mais detalhes</a>

                                    </div>
                                    <div class="card-footer">
                                        <?php if($service->status_contrato == 0) {?>
                                            <div class="alert alert-secondary" role="alert">Serviço pendente</div>
                                        <?php } else if($service->status_contrato == 1) {?>
                                            <div class="alert alert-success" role="alert">Serviço aceito</div>
                                        <?php } else if($service->status_contrato == 2) {?>
                                            <div class="alert alert-danger" role="alert">Serviço rejeitado</div>
                                        <?php
                                        }?>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                    } else {?>
                        <div class="col-12 mt-3">
                            <p class="text-info text-center">
                                Você ainda não contratou nenhum serviço. Encontre o melhor serviço para você <a class="text-primary" href="../EncontrarProfissional/Listagem/listagem.php">aqui</a>.
                            </p>
                        </div>
                    <?php }?>
                </div>
            </div>
            <?php if(count($asClientRequestedServices) > 3) {?>
                <button type="button" class="showServicesButtons mt-3" id="showAllAvailableServices" onclick="showAllServices('servicesRequestedByYou', <?=$_SESSION['idUsuario']?>)">Todos os serviços</button>
            <?php }?>
        </div>
    </section>
    <!-- FIM div serviços que você solicitou -->

    <?php if($_SESSION['classificacao'] != 0) {?>
        <!-- Div serviços aceitos ou rejeitados -->
        <section id="acceptedRejectedServices">
            <div class="container">

                <div class="myContent mb-3">
                    <h1>Serviços aceitos ou rejeitados</h1>

                    <div class="row d-flex justify-content-center">

                        <?php if( count($asProviderAcceptReject) > 0 ) {
                            foreach ($asProviderAcceptReject as $key => $service) {
                                if ($key == 3){
                                    break;
                                }

                                $date = new DateTime($service->data_contrato);
                                ?>
                                <div class="col-lg-4 col-md-6 mt-3">
                                    <div class="card myCard2 mx-3">
                                        <div class="card-header myCardHeader2">
                                            Seu serviço foi solicitado por <a class="text-white font-weight-bold" href="perfil.php?id=<?=$service->id_cliente?>"><?=$service->nome_usuario?></a>
                                        </div>
                                        <div class="card-body">
                                            <h3 class="card-title"><?=$service->nome_servico?></h3>
                                            <p class="card-text">
                                                <strong>Informações básicas:</strong> <br>
                                                <strong>Orçamento:</strong> R$ <?=$service->orcamento_servico?> <?=$service->crit_orcamento_servico?><br>
                                                <strong>Data da solicitação:</strong> <?=$date->format('d/m/y')?>
                                            </p>

                                            <a href="../EncontrarProfissional/VisualizarServico/visuaizarServico.php?serviceID=<?=$service->id_servico?>" class="text-primary">Mais detalhes</a>

                                        </div>
                                        <div class="card-footer">
                                            <?php if($service->status_contrato == 1) {?>
                                                <div class="alert alert-success" role="alert">Serviço aceito</div>
                                            <?php } else if($service->status_contrato == 2) {?>
                                                <div class="alert alert-danger" role="alert">Serviço rejeitado</div>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {?>
                            <div class="col-12 mt-3">
                                <p class="text-info text-center">
                                    Você não aceitou ou rejeitou nenhum serviço até agora.
                                </p>
                            </div>
                        <?php }?>

                    </div>
                </div>

                <?php if(count($asProviderAcceptReject) > 3) {?>
                    <button type="button" class="showServicesButtons mr-4 mb-4" id="showAllAvailableServices" onclick="showAllServices('acceptRejectServices', <?=$_SESSION['idUsuario']?>)">Todos os serviços</button>
                <?php }?>
            </div>
        </section>

        <!-- Fim serviços disponibilizados -->
    <?php }?>

    <!-- Div de histórico de serviços contrtados -->
    <section id="recentServices">
        <div class="container">

            <div class="myContent">
                <h1>Histórico de serviços contratados</h1>

                <div class="row d-flex justify-content-center" id="recentServicesCards">

                    <?php if( count($contractedServicesHistory) > 0 ) {
                        foreach ($contractedServicesHistory as $key => $service) {
                            if ($key == 3){
                                break;
                            }
                            //nome, número e foto do prestador que solicitou
                            $query = "SELECT nome_usuario, fone_usuario, imagem_usuario, uf_usuario, cidade_usuario FROM usuarios WHERE id_usuario = $service->id_prestador";
                            $stmt = $con->query($query);
                            $provider_info = $stmt->fetch(PDO::FETCH_OBJ);

                            //detalhes do serviço que foi solicitado
                            $query = "SELECT nome_servico, crit_orcamento_servico, orcamento_servico, tipo_servico FROM servicos WHERE id_servico = $service->id_servico";
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
                                            <strong>Orçamento:</strong> R$ <?=$service_details->orcamento_servico?> <?=$service_details->crit_orcamento_servico?><br>
                                            <strong>Localização:</strong> <?=$service_details->tipo_servico == 0 ? "Serviço remoto" : $provider_info->uf_usuario . ', ' . $provider_info->cidade_usuario?>
                                        </p>

                                        <a href="../EncontrarProfissional/VisualizarServico/visuaizarServico.php?serviceID=<?=$service->id_servico?>" class="text-primary">Mais detalhes</a>
                                        <hr>
                                        <div class="row">
                                            <div class="col-12 col-sm-8">
                                                <a href="perfil.php?id=<?=$service->id_prestador?>" class="font-weight-bold text-dark"><?=$provider_info->nome_usuario?></a> <br>
                                                <?=$provider_info->fone_usuario?>
                                            </div>
                                            <div class="d-none d-sm-block col-sm-4 ">
                                                <img src="../../assets/images/users/<?=$provider_info->imagem_usuario?>" alt="foto de perfil"
                                                     class="recentServicesPic">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                    } else {?>
                        <div class="col-12 mt-3">
                            <p class="text-info text-center">
                                Você ainda não contratou nenhum serviço. Encontre o melhor serviço para você <a class="text-primary" href="../EncontrarProfissional/Listagem/listagem.php">aqui</a>.
                            </p>
                        </div>
                    <?php }?>
                </div>
            </div>
            <?php if(count($contractedServicesHistory) > 3) {?>
                <button type="button" class="showServicesButtons mt-3" id="showAllAvailableServices" onclick="showAllServices('recentServices', <?=$_SESSION['idUsuario']?>)">Todos os serviços</button>
            <?php }?>
        </div>
    </section>
    <!-- Div de histórico de serviços contrtados-->

    <!-- Div serviços salvos -->
    <section id="savedServices">
        <div class="container">

            <div class="myContent">
                <h1>Serviços Salvos</h1>

                <div class="row d-flex justify-content-center" id="savedCards">

                    <?php if( count($userSavedServices) > 0 ) {
                        foreach ($userSavedServices as $key => $service) {
                            if ($key == 3){
                                break;
                            }
                            //detalhes do serviço
                            $query = "SELECT nome_servico, tipo_servico, crit_orcamento_servico, orcamento_servico, data_public_servico FROM servicos WHERE id_servico = " . $service->id_servico;
                            $stmt = $con->query($query);
                            $savedService = $stmt->fetch(PDO::FETCH_OBJ);

                            //data do serviço
                            $date = new DateTime($savedService->data_public_servico);
                            ?>

                            <div class="col-lg-4 col-md-6 mt-3">
                                <div class="card myCard mx-3">
                                    <div class="card-header myCardHeader">
                                        Serviço <?= $savedService->tipo_servico == 0 ? "remoto" : "presencial" ?>
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title"><?= $savedService->nome_servico ?></h3>
                                        <p class="card-text">
                                            <strong>Informações básicas:</strong> <br>
                                            <strong>Orçamento:</strong> R$ <?=$savedService->orcamento_servico?> <?=$savedService->crit_orcamento_servico?><br>
                                            <strong>Data de publicação:</strong> <?=$date->format('d/m/Y')?>
                                        </p>
                                        <a href="../EncontrarProfissional/VisualizarServico/visuaizarServico.php?serviceID=<?=$service->id_servico?>" class="text-primary">Mais detalhes</a> <br>
                                    </div>
                                    <div class="card-footer">
                                        <button onclick="location.href = '../../logic/perfil_remover_servicosalvo.php?id=<?=$service->id_servico_salvo?>'" class="mybtn mybtn-danger">Remover</button>
                                    </div>
                                </div>
                            </div>

                        <?php
                        }
                    } else {?>
                        <div class="col-12 mt-3">
                            <p class="text-info text-center">
                                Você ainda não salvou nenhum serviço
                            </p>
                        </div>
                    <?php }?>
                </div>
            </div>
            <?php if(count($userSavedServices) > 3) {?>
                <button type="button" class="showServicesButtons mr-4 mt-2" id="showAllAvailableServices" onclick="showAllServices('savedServices', <?=$_SESSION['idUsuario']?>)">Todos os serviços</button>
            <?php }?>
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-justify">
                    <p id="confirmModalMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="mybtn mybtn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button id="confirmModalConfirmChoice"></button>
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