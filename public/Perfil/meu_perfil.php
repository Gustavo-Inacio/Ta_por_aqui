<?php
session_start();

//caso haja cookies salvos no pc do usuário, ele vai logar com os cookies salvos
require "../../logic/entrar_cookie.php";

if( empty($_SESSION['idUsuario']) ){
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
$query = "SELECT rede_social, nick_rede_social, link_rede_social FROM usuario_redes_sociais WHERE id_usuario = " . $_SESSION['idUsuario'];
$stmt = $con->query($query);
$userSocialMedia = $stmt->fetchAll(PDO::FETCH_OBJ);

//puxando os serviços relacionados ao prestador
if($_SESSION['classificacao'] !== 0){
    //serviços disponibilizados
    $query = "SELECT id_servico, nome_servico, tipo_servico, crit_orcamento_servico, orcamento_servico, data_public_servico FROM servicos WHERE id_prestador_servico = " . $_SESSION['idUsuario'] . " AND status_servico = 1 ORDER BY id_servico DESC";
    $stmt = $con->query($query);
    $userServices = $stmt->fetchAll(PDO::FETCH_OBJ);

    //serviços requisitados para esse prestador
    $query = "SELECT * FROM contratos as c join servicos as s on c.id_servico = s.id_servico WHERE c.id_prestador = " . $_SESSION['idUsuario']  . " AND s.status_servico = 1 ORDER BY c.status_contrato ASC";
    $stmt = $con->query($query);
    $asProviderRequestedServices = $stmt->fetchAll(PDO::FETCH_OBJ);
}
//serviços que você requisitou como cliente
$query = "SELECT * FROM contratos as c join servicos as s on c.id_servico = s.id_servico WHERE c.id_cliente = " . $_SESSION['idUsuario']  . " AND s.status_servico = 1 ORDER BY c.status_contrato DESC";
$stmt = $con->query($query);
$asClientRequestedServices = $stmt->fetchAll(PDO::FETCH_OBJ);

//serviços que você contratou e foram aceitos
$query = "SELECT * FROM contratos as c join servicos as s on c.id_servico = s.id_servico WHERE c.id_cliente = " . $_SESSION['idUsuario']  . " AND s.status_servico = 1 AND c.status_contrato = 1 ORDER BY c.id_contrato DESC";
$stmt = $con->query($query);
$contractedServicesHistory = $stmt->fetchAll(PDO::FETCH_OBJ);

//puxando os serviços salvos
$query = "SELECT * FROM servicos_salvos as ss join servicos as s on ss.id_servico = s.id_servico WHERE id_usuario = " . $_SESSION['idUsuario'] . " AND s.status_servico = 1";
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
                    <a href="../Contato/contato.php" class="nav-link">Fale conosco</a>
                </li>
                <li class="nav-item">
                    <a href="../SobreNos/sobreNos.php" class="nav-link">Sobre</a>
                </li>
                <li class="nav-item">
                    <a href="../Chat/chat.html" class="nav-link">Chat</a>
                </li>
            </ul>

            <div class="dropdown">
                <img src="../../assets/images/users/<?=$_SESSION['imagemPerfil']?>" alt="imagem de perfil" id="profileMenu"
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
            <img src="../../assets/images/users/<?=$user->imagem_usuario?>" alt="Imagem de perfil" class="rounded-image"
                 id="profileImage">
            <br>

            <!-- Alerta fechável de erro -->
            <?php if(isset($_GET['erro'])) {?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <strong>Erro!</strong> <?= $_GET['erro'] ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php }?>

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
                                        <button type="submit" class="mybtn mybtn-conversion mt-2" id="saveNewProfileImage"> Salvar imagem </button>
                                        <button type="button" class="mybtn mybtn-danger mt-2" id="cancelNewProfileImage" onclick="location.reload()"> Cancelar mudanças </button>
                                    </div>
                                </div>
                            </form>

                            <hr class="removeImageItem">

                            <button id="removeProfilePic" class="removeImageItem btn-block" onclick="confirmRemoveImage('../../logic/perfil_remover_imagem.php')"> <i class="fas fa-trash"></i> Remover foto atual</button>
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
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
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
                        <input type="text" class="form-control" name="userCell" id="userCell" readonly required
                            value="<?=$user->fone_usuario?>">

                        <br>

                        <label for="userConfig">Configurações da conta</label> <br>
                        <button type="button" class="btn" id="accountConfigBtn" data-toggle="modal" data-target="#accountConfigModal">Outras configurações</button>

                    </div>

                    <div class="col-md-6 mt-3 mt-md-0">
                        <label for="userEmail">Email</label> <br>
                        <input type="text" class="form-control" id="userEmail" readonly maxlength="40"
                            value="<?=$user->email_usuario?>">

                        <br>

                        <label for="userSite">Site</label> <br>
                        <input type="url" class="form-control d-none" name="userSite" id="userSite" readonly placeholder="Caso tenha, insira seu site ou porfólio online" maxlength="40"
                            value="<?=$user->site_usuario?>">
                        <div id="showUserSite"><a href="<?=$user->site_usuario?>" target="_blank"><?=$user->site_usuario?></a></div>

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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="divConfig row">
                        <div class="col-sm-8">
                            <h6>Altere sua senha</h6>
                            <p>Mude sua senha caso você ache que alguém a sabe, ou se ela está muito fraca. mantenha sua conta protegida</p>
                        </div>
                        <div class="col-sm-4 d-flex align-items-center">
                            <button type="button" class="mybtn mybtn-conversion closeConfigModal" id="changePass" data-toggle="modal" data-target="#changePassModal">Alterar senha</button>
                        </div>
                    </div>

                    <hr>

                    <div class="divConfig row">
                        <div class="col-sm-8">
                            <h6>Altere seu email</h6>
                            <p>Mude seu email caso você tenha trocado para um novo.</p>
                        </div>
                        <div class="col-sm-4 d-flex align-items-center">
                            <button type="button" class="mybtn mybtn-complement closeConfigModal" id="changeEmail" data-toggle="modal" data-target="#changeEmailModal">Alterar email</button>
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
                            <h6 class="text-danger">Excluir conta</h6>
                            <p class="text-danger"><strong>Você tem certeza?</strong> Sua conta será suspensa de nossa plataforma, tornando seu usuário e serviços inacessíveis</p>
                        </div>
                        <div class="col-sm-4 d-flex align-items-center">
                            <button type="button" class="mybtn mybtn-outline-danger closeConfigModal" id="deleteAccount" onclick="deleteAccount()">Excluir conta</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="mybtn mybtn-secondary" data-dismiss="modal">Fechar</button>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Você tem certeza que deseja trocar a sua senha?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="location.href='../../logic/perfil_allowChangePass.php'" class="mybtn mybtn-conversion">Tenho!</button>
                    <button type="button" class="mybtn mybtn-secondary" data-dismiss="modal">Deixa pra lá</button>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="" id="emailChangeForm">
                    <div class="modal-body">
                        <label for="newEmail" class="mb-2">Insira o seu novo email</label>
                        <input type="text" class="form-control" name="email" id="newEmail">

                        <small class="text-danger" id="msgErro"></small>
                    </div>

                    <div class="modal-footer">
                        <button type="button" id="btnConfirmaTroca" class="mybtn mybtn-conversion" onclick="recebeEmail()">Confirmar troca</button>
                        <button type="reset" class="mybtn mybtn-secondary" data-dismiss="modal">Deixa pra lá</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- modal trocar email fim -->

    <!-- modal confirmar novo email (código) -->

    <div class="modal fade" id="confirmEmailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Trocar de email</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- inputs com informações do endereço -->
                <form action="../../logic/perfil_trocar_localizacao.php" method="post" id="changeLocationForm">
                    <div class="modal-body">
                        <label for="userAdressCEP" class="myLabel">CEP</label> <br>
                        <input type="text" class="form-control required" name="userAdressCEP" id="userAdressCEP" placeholder="ex.: 01234567" onkeyup="callGetAdress(this)" onchange="callGetAdress(this)" required>
                        <small id="cepError" class="text-danger"></small>

                        <div class="row mt-3">
                            <div class="col-3">
                                <label for="userAdressState" class="myLabel">Estado</label> <br>
                                <input type="text" class="form-control required mb-3" name="userAdressState" id="userAdressState" readonly data-toggle="popover" data-trigger="hover" data-content="autocompletado com o CEP" data-placement="top" required>
                            </div>
                            <div class="col-9">
                                <label for="userAdressCity" class="myLabel">Cidade</label> <br>
                                <input type="text" class="form-control required mb-3" name="userAdressCity" id="userAdressCity" placeholder="autocompletado com o CEP" readonly required>
                            </div>
                        </div>

                        <label for="userAdressNeighborhood" class="myLabel">Bairro</label> <br>
                        <input type="text" class="form-control required mb-3" name="userAdressNeighborhood" id="userAdressNeighborhood" placeholder="Digite seu bairro" required>

                        <div class="row">
                            <div class="col-9">
                                <label for="userAdressStreet" class="myLabel">Rua</label> <br>
                                <input type="text" class="form-control required mb-3" name="userAdressStreet" id="userAdressStreet" placeholder="Digite sua rua" required>
                            </div>
                            <div class="col-3">
                                <label for="userAdressNumber" class="myLabel">Número</label> <br>
                                <input type="number" class="form-control required mb-3" name="userAdressNumber" id="userAdressNumber" maxlength="5" required>
                            </div>
                        </div>

                        <label for="userAdressComplement" class="myLabel">Complemento</label> <br>
                        <input type="text" class="form-control mb-3" name="userAdressComplement" id="userAdressComplement" placeholder="Digite o complemento (caso tenha)" data-toggle="popover" data-trigger="hover" title="Exemplo" data-content="apto. 24 BL A" data-placement="top" maxlength="20">

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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-justify">
                    <p id="confirmModalMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="mybtn mybtn-secondary" data-dismiss="modal">Fechar</button>
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