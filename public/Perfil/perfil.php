<?php
session_start();

//caso haja cookies salvos no pc do usuário, ele vai logar com os cookies salvos
require "../../logic/entrar_cookie.php";

//pegando as informações do perfil visualizado
require "../../logic/DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

//Puxando os dados do meu perfil do banco de dados
if(isset($_GET['id'])) {
    $query = "SELECT * FROM usuarios where id_usuario = " . $_GET['id'] . " AND status_usuario = 1";
    $stmt = $con->query($query);
    $user = $stmt->fetch(PDO::FETCH_OBJ);

    //puxando as redes sociais do usuário
    $query2 = "SELECT rede_social, nick_rede_social, link_rede_social FROM usuario_redes_sociais WHERE id_usuario = " . $_GET['id'];
    $stmt = $con->query($query2);
    $userSocialMedia = $stmt->fetchAll(PDO::FETCH_OBJ);

    //puxando os serviços do prestador
    if($_SESSION['classificacao'] !== 0){
        $query = "SELECT id_servico, nome_servico, tipo_servico, orcamento_servico, crit_orcamento_servico, data_public_servico FROM servicos WHERE id_prestador_servico = " . $_GET['id'] . " AND status_servico = 1 ORDER BY id_servico DESC";
        $stmt = $con->query($query);
        $userServices = $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}

if( !isset($_GET['id']) || !isset($user->id_usuario) ){
?>

<!-- HTML da mensagem de erro de usuário não encontrado-->

    <!DOCTYPE html>
    <html lang="pt">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script src="https://kit.fontawesome.com/2a19bde8ca.js" crossorigin="anonymous" defer></script>

        <title>Tá por aqui - Usuário não encontrado </title>

        <link rel="stylesheet" href="../../assets/bootstrap/bootstrap-4.5.3-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../assets/global/globalStyles.css">
        <link rel="stylesheet" href="perfil.css">

        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="../../assets/bootstrap/popper.min.js" defer></script>
        <script src="../../assets/bootstrap/bootstrap-4.5.3-dist/js/bootstrap.min.js" defer></script>

        <script src="../../assets/global/globalScripts.js" defer></script>

        <script src="show_services.js" defer></script>
    </head>

    <body>
        <!--NavBar Comeco-->
        <div id="myMainTopNavbarNavBackdrop" class=""></div>
        <nav id="myMainTopNavbar" class="navbar navbar-expand-md">
            <a href="../Home/home.php" class="navbar-brand">
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
                        <a href="../Chat/chat.php" class="nav-link">Chat</a>
                    </li>
                    <?php if( empty($_SESSION) ){ ?>
                        <li class="nav-item">
                            <a href="../Entrar/login.php" class="nav-link">Entrar/cadastrar</a>
                        </li>
                    <?php }?>
                </ul>

                <?php if( isset($_SESSION['idUsuario']) && isset($_SESSION['email']) && isset($_SESSION['senha']) && isset($_SESSION['classificacao']) ) {?>
                    <div class="dropdown">
                        <img src="../../assets/images/users/<?=$_SESSION['imagemPerfil']?>" alt="imagem de perfil" id="profileMenu" class="img-fluid" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        <div class="dropdown-menu" aria-labelledby="profileMenu">
                            <a class="dropdown-item" href="meu_perfil.php">Perfil</a>
                            <a class="dropdown-item text-danger" href="../../logic/entrar_logoff.php">Sair</a>
                        </div>
                    </div>
                <?php } ?>

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

<?php } else { ?>

<!-- HTML normal -->
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://kit.fontawesome.com/2a19bde8ca.js" crossorigin="anonymous" defer></script>

    <title>Tá por aqui - <?=$user->nome_usuario?> <?=$user->sobrenome_usuario?> </title>

    <link rel="stylesheet" href="../../assets/bootstrap/bootstrap-4.5.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/global/globalStyles.css">
    <link rel="stylesheet" href="perfil.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="../../assets/bootstrap/popper.min.js" defer></script>
    <script src="../../assets/bootstrap/bootstrap-4.5.3-dist/js/bootstrap.min.js" defer></script>

    <script src="../../assets/global/globalScripts.js" defer></script>
    <script src="show_services.js" defer></script>

    <style>
        #profilePictureArea{
            padding: 70px 0 150px 0;
        }
    </style>
</head>

<body>
    <!--NavBar Comeco-->
    <div id="myMainTopNavbarNavBackdrop" class=""></div>
    <nav id="myMainTopNavbar" class="navbar navbar-expand-md">
        <a href="../Home/home.php" class="navbar-brand">
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
                    <a href="../Contato/contato.html" class="nav-link">Fale conosco</a>
                </li>
                <li class="nav-item">
                    <a href="../SobreNos/sobreNos.php" class="nav-link">Sobre</a>
                </li>
                <li class="nav-item">
                    <a href="../Chat/chat.html" class="nav-link">Chat</a>
                </li>
                <?php if( empty($_SESSION) ){ ?>
                    <li class="nav-item">
                        <a href="../Entrar/login.php" class="nav-link">Entrar/cadastrar</a>
                    </li>
                <?php }?>
            </ul>

            <?php if( isset($_SESSION['idUsuario']) && isset($_SESSION['email']) && isset($_SESSION['senha']) && isset($_SESSION['classificacao']) ) {?>
                <div class="dropdown">
                    <img src="../../assets/images/users/<?=$_SESSION['imagemPerfil']?>" alt="imagem de perfil" id="profileMenu" class="img-fluid" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    <div class="dropdown-menu" aria-labelledby="profileMenu">
                        <a class="dropdown-item" href="meu_perfil.php">Perfil</a>
                        <a class="dropdown-item text-danger" href="../../logic/entrar_logoff.php">Sair</a>
                    </div>
                </div>
            <?php } ?>

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
                            value="<?=$user->fone_usuario?>">

                    </div>

                    <div class="col-md-6 mt-3 mt-md-0">
                        <label for="userEmail">Email</label> <br>
                        <input type="text" class="form-control" name="userEmail" id="userEmail" readonly
                            value="<?=$user->email_usuario?>">

                        <br>

                        <?php if( $user->site_usuario != "" ) {?>
                            <label for="showUserSite">Site</label> <br>
                            <div id="showUserSite"> <a href="<?=$user->site_usuario?>" target="_blank"> <?=$user->site_usuario?> </a> </div>

                            <br>
                        <?php }?>

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
                        if (count($userSocialMedia) !== 0){
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
<?php } ?>