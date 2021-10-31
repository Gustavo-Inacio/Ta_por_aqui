<?php
    session_start();

    if(!$_GET['serviceID']){
        header('Location: ../Listagem/listagem.php');
    }

    require '../../../logic/visualizar_servico.php';

    //caso haja cookies salvos no pc do usuário, ele vai logar com os cookies salvos
    require "../../../logic/entrar_cookie.php";
    
    $serviceID = $_GET['serviceID'];
    $_SESSION['serviceID'] = $serviceID;

    $brain = new VisualizeService($serviceID);
    $providerData = $brain->getPorviderInfo();
    if(!$providerData){
        require './servicoInexistente.php';
        return;
    }

    $serviceData = $brain->getServiceInfo();
    $serviceImg = $brain->getServiceImages();

    $avaliationPermited = $brain->getAvaliationPermited();
    $isMyService = $brain->getSelfService();
    $providerAvarege = $brain->getProviderAverage();

    $serviceIsSaved = false;
    if(isset($_SESSION['idUsuario'])){
        $serviceIsSaved = $brain->getSaveService($_SESSION['idUsuario']);
    }

    $isProvider = false;

    if(isset($_SESSION['classificacao']) && $_SESSION['classificacao'] > 1){
        $isProvider = true;
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tá por aqui - <?=$serviceData['nome_servico']?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="../../../assets/glider/glider.css">
    <link rel="stylesheet" href="../../../assets/global/globalStyles.css">
    <link rel="stylesheet" href="../../Denuncia/denuncia.css">
    <link rel="stylesheet" href="visualizarServico.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/2a19bde8ca.js" crossorigin="anonymous" defer></script>
    <script src="../../../assets/glider/glider.js" defer></script>
    <script src="../../../assets/global/globalScripts.js" defer></script>
    <script type="module" src="visualizarServico.js" defer></script>
    <!-- <script src="./enviarAvaliacao.js" defer></script> <!-Somente quado o usuario puder enviar a avalizacao-->
</head>
<body>

    <iframe  id="myReportIframe" src="../../Denuncia/denuncia.php" style="display: none;"></iframe>

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
    
    <section id="myInfoSection" class="container-sm">
        <div class="row">
            <div id="myInfoContainer" class="container-md">
                <div class="row my-top-service-info-row">
                    <div class="col">
                        <h2 id="myTopRow--providerName" class="provider-name">
                            <?php echo $providerData['nome_usuario']. ' ' .$providerData['sobrenome_usuario']?>
                        </h2>

                        <div class="provider-rate-div">
                            <p class="provider-rate--text">Classificação Média do Prestador:</p>
                            <p class="provider-rate--number">
                                <?php echo $providerAvarege['data']['average'] ?>
                            </p>
                            <div class="provider-rate--stars">
                                <svg class="provider-rate-star" width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.44497 0.28627L10.3449 5.38246L10.3691 5.44752H10.4386H16.649L11.618 8.56749L11.5484 8.61066L11.577 8.68741L13.4668 13.7566L8.49847 10.6106L8.44497 10.5767L8.39147 10.6106L3.42316 13.7566L5.31298 8.68741L5.34132 8.61139L5.27278 8.56799L0.344844 5.44752H6.45139H6.52083L6.54509 5.38246L8.44497 0.28627Z" fill="#FF9839" stroke="black" stroke-width="0.2"/>
                                </svg>
                                <svg class="provider-rate-star" width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.44497 0.28627L10.3449 5.38246L10.3691 5.44752H10.4386H16.649L11.618 8.56749L11.5484 8.61066L11.577 8.68741L13.4668 13.7566L8.49847 10.6106L8.44497 10.5767L8.39147 10.6106L3.42316 13.7566L5.31298 8.68741L5.34132 8.61139L5.27278 8.56799L0.344844 5.44752H6.45139H6.52083L6.54509 5.38246L8.44497 0.28627Z" fill="#FF9839" stroke="black" stroke-width="0.2"/>
                                </svg>
                                <svg class="provider-rate-star" width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.44497 0.28627L10.3449 5.38246L10.3691 5.44752H10.4386H16.649L11.618 8.56749L11.5484 8.61066L11.577 8.68741L13.4668 13.7566L8.49847 10.6106L8.44497 10.5767L8.39147 10.6106L3.42316 13.7566L5.31298 8.68741L5.34132 8.61139L5.27278 8.56799L0.344844 5.44752H6.45139H6.52083L6.54509 5.38246L8.44497 0.28627Z" fill="#FF9839" stroke="black" stroke-width="0.2"/>
                                </svg>
                                <svg class="provider-rate-star" width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.44497 0.28627L10.3449 5.38246L10.3691 5.44752H10.4386H16.649L11.618 8.56749L11.5484 8.61066L11.577 8.68741L13.4668 13.7566L8.49847 10.6106L8.44497 10.5767L8.39147 10.6106L3.42316 13.7566L5.31298 8.68741L5.34132 8.61139L5.27278 8.56799L0.344844 5.44752H6.45139H6.52083L6.54509 5.38246L8.44497 0.28627Z" fill="#AAAAAA" stroke="black" stroke-width="0.2"/>
                                </svg>
                                <svg class="provider-rate-star" width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.44497 0.28627L10.3449 5.38246L10.3691 5.44752H10.4386H16.649L11.618 8.56749L11.5484 8.61066L11.577 8.68741L13.4668 13.7566L8.49847 10.6106L8.44497 10.5767L8.39147 10.6106L3.42316 13.7566L5.31298 8.68741L5.34132 8.61139L5.27278 8.56799L0.344844 5.44752H6.45139H6.52083L6.54509 5.38246L8.44497 0.28627Z" fill="#AAAAAA" stroke="black" stroke-width="0.2"/>
                                </svg>
                            </div>

                            <p class="provider-rate--quantity">(<?php echo $providerAvarege['data']['quantity'] ?> - avaliações)</p>
                        </div>

                        <div class="service-techinical-info">
                            <p class="service-publish-date">Seviço publicado em 
                                <?php echo $serviceData['data_public_servico']; ?>
                            </p>

                            <div class="service-dot-options">
                                <div class="service-3dot">
                                    <div class="service-dot"></div>
                                    <div class="service-dot"></div>
                                    <div class="service-dot"></div>
                                </div>

                                <div id="serviceMenuOptions" class="service-dot-options-menu">
                                    <a href="#" class="service-dot-item">
                                        <button type="button" class="" data-bs-toggle="modal" data-bs-target="<?=isset($_SESSION['idUsuario']) ? '#serviceReportModal' : '#notLoggedToComplain-modal'?>">
                                            Denunciar Serviço
                                        </button>
                                    </a>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="notLoggedToComplain-modal" tabindex="-1" aria-labelledby="notLoggedToComplain-label" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="notLoggedToChat-label">Entre em sua conta</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Pra denunciar um serviço ou um comentário é necessário estar logado
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                                <a href="../../Entrar/login.php"><button type="button" class="btn btn-primary">Loggin / Cadastrar</button></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- modal de denúncia de serviço -->
                                <div class="modal fade" id="serviceReportModal" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-body" id="myReportModalBody"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        
        <div class="caousel-img-display--backdrop"></div>
        <div class="carousel-img-display">
            
        </div>

        <div class="row">
            <div class="container my-service-main-content-container">
                <div class="row my-service-main-content-row g-0">

                    <div class="my-service-main-content--carousel-area ps-0 col-12 col-md-8 col-lg-7 gx-4">
                        <div id="myMainServiceCarousel" class="my-main-carousel carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php foreach ($serviceImg as $i => $img) {?>
                                    <div class="carousel-item <?=$i === 0 ? "active" : ""?>">
                                        <img src="../../../assets/images/users/<?php echo $img;?>" class="d-block w-100" alt="SERVICE-IMG">
                                        <!-- <img src="<?php echo $img;?>" class="d-block w-100" alt="SERVICE-IMG"> -->
                                    </div>
                                <?php }?>
                            </div>

                            <a class="carousel-control-prev" href="#myMainServiceCarousel" role="button" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#myMainServiceCarousel" role="button" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>

                        <div class="my-service-carousel-img-indicators">
                            <?php foreach ($serviceImg as $i => $img) {?>
                                <div class="my-carousel-indicator-item <?=$i == 0 ? "active" : ""?>">
                                    <img src="../../../assets/images/users/<?php echo $img;?>" class="d-block w-100" alt="SERVICE-IMG">
                                    <!-- <img src="<?php echo $img;?>" class="d-block w-100" alt="SERVICE-IMG"> -->
                                </div>
                            <?php }?>
                        </div>

                        <div class="my-service-location-div my-service-location-div-under-carousel">
                            <?php if($serviceData['tipo_servico'] == 1) {?>
                                <i class="fas fa-map-marker-alt"></i>
                                <p class="my-service-location">
                                    <?php
                                        echo $providerData['uf_usuario'].", ".$providerData['cidade_usuario'].", ".$providerData['rua_usuario'].' '.$providerData['numero_usuario'];
                                    ?>
                                </p>
                            <?php } else {?>
                                <i class="fas fa-laptop-house"></i>
                                <p class="my-service-location">
                                    Serviço feito digitalmente
                                </p>
                            <?php }?>
                        </div>
                    </div>

                    <div class="my-service-main-content--info-area col-sm-12 col-md-4 col-lg-3 gy-5">
                        <div class="row order-first order-md-3">
                            <div class="col">
                                <div class="service-price ">
                                    <h1 class="service-price-text"><?php echo "R$ " . $serviceData['orcamento_servico'] ." " . $serviceData['crit_orcamento_servico']; ?></h1>
                                </div>
                            </div>
                        </div>
                        


                        <div class="names row order-md-1">
                            <div class="col-12 d-flex flex-column">
                                <h2 id="myProviderName" class="provider-name provider-name-mobile"><?php echo $providerData['nome_usuario']; ?></h2>
                                <h2 id="myServiceName" class="service-name"><?php echo $serviceData['nome_servico']; ?></h2>
                            </div>
                            
                        </div>
                        
                        <div class="avaliation-and-chat row order-md-2 flex-md-column">
                            <div class="col">
                                <div class="my-rate-service-info loading">
                                    <p class="my-rate-service-title">Classificação média do serviço</p>
                                    <p id="myServiceRateNumber" class="service-rate--number ">--</p>

                                    <div class="service-rate--stars">
                                        <svg class="service-rate-star" width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8.44497 0.28627L10.3449 5.38246L10.3691 5.44752H10.4386H16.649L11.618 8.56749L11.5484 8.61066L11.577 8.68741L13.4668 13.7566L8.49847 10.6106L8.44497 10.5767L8.39147 10.6106L3.42316 13.7566L5.31298 8.68741L5.34132 8.61139L5.27278 8.56799L0.344844 5.44752H6.45139H6.52083L6.54509 5.38246L8.44497 0.28627Z" fill="" stroke="black" stroke-width="0.2"/>
                                        </svg>
                                        <svg class="service-rate-star" width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8.44497 0.28627L10.3449 5.38246L10.3691 5.44752H10.4386H16.649L11.618 8.56749L11.5484 8.61066L11.577 8.68741L13.4668 13.7566L8.49847 10.6106L8.44497 10.5767L8.39147 10.6106L3.42316 13.7566L5.31298 8.68741L5.34132 8.61139L5.27278 8.56799L0.344844 5.44752H6.45139H6.52083L6.54509 5.38246L8.44497 0.28627Z" fill="" stroke="black" stroke-width="0.2"/>
                                        </svg>
                                        <svg class="service-rate-star" width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8.44497 0.28627L10.3449 5.38246L10.3691 5.44752H10.4386H16.649L11.618 8.56749L11.5484 8.61066L11.577 8.68741L13.4668 13.7566L8.49847 10.6106L8.44497 10.5767L8.39147 10.6106L3.42316 13.7566L5.31298 8.68741L5.34132 8.61139L5.27278 8.56799L0.344844 5.44752H6.45139H6.52083L6.54509 5.38246L8.44497 0.28627Z" fill="" stroke="black" stroke-width="0.2"/>
                                        </svg>
                                        <svg class="service-rate-star" width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8.44497 0.28627L10.3449 5.38246L10.3691 5.44752H10.4386H16.649L11.618 8.56749L11.5484 8.61066L11.577 8.68741L13.4668 13.7566L8.49847 10.6106L8.44497 10.5767L8.39147 10.6106L3.42316 13.7566L5.31298 8.68741L5.34132 8.61139L5.27278 8.56799L0.344844 5.44752H6.45139H6.52083L6.54509 5.38246L8.44497 0.28627Z" fill="" stroke="black" stroke-width="0.2"/>
                                        </svg>
                                        <svg class="service-rate-star" width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8.44497 0.28627L10.3449 5.38246L10.3691 5.44752H10.4386H16.649L11.618 8.56749L11.5484 8.61066L11.577 8.68741L13.4668 13.7566L8.49847 10.6106L8.44497 10.5767L8.39147 10.6106L3.42316 13.7566L5.31298 8.68741L5.34132 8.61139L5.27278 8.56799L0.344844 5.44752H6.45139H6.52083L6.54509 5.38246L8.44497 0.28627Z" fill="" stroke="black" stroke-width="0.2"/>
                                        </svg>
                                    </div>

                                    <!--<p class="service-rate--quantity">(47 - avaliações)</p>-->
                                    <p class="service-rate--quantity"></p>
                                </div>
                            </div>
                            <div class="col d-flex">
                                <?php if(!$isMyService){?>
                                    <?php if(isset($_SESSION['idUsuario'])){ ?>
                                        <a href="../../../logic/chat/chat_criarContato.php?idServico=<?=$serviceData['id_servico']?>" class="contact-chat-btn-a">
                                            <button>
                                                <label>Entrar em contato </label>
                                                <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M16.2 0H1.8C0.81 0 0.00899999 0.855 0.00899999 1.9L0 19L3.6 15.2H16.2C17.19 15.2 18 14.345 18 13.3V1.9C18 0.855 17.19 0 16.2 0ZM3.6 6.65H14.4V8.55H3.6V6.65ZM10.8 11.4H3.6V9.5H10.8V11.4ZM14.4 5.7H3.6V3.8H14.4V5.7Z" fill="#3333CC"/>
                                                </svg>    
                                            </button>
                                        </a>
                                    <?php } else { ?>
                                        <a href="#" class="contact-chat-btn-a-not-logged">
                                            <button type="button" class="" data-bs-toggle="modal" data-bs-target="#notLoggedToChat-modal">
                                                <label style="pointer-events: none;">Entrar em contato </label>
                                                    <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M16.2 0H1.8C0.81 0 0.00899999 0.855 0.00899999 1.9L0 19L3.6 15.2H16.2C17.19 15.2 18 14.345 18 13.3V1.9C18 0.855 17.19 0 16.2 0ZM3.6 6.65H14.4V8.55H3.6V6.65ZM10.8 11.4H3.6V9.5H10.8V11.4ZM14.4 5.7H3.6V3.8H14.4V5.7Z" fill="#3333CC"/>
                                                    </svg>    
                                            </button>
                                        </a>
                                            <!-- Modal -->
                                            <div class="modal fade" id="notLoggedToChat-modal" tabindex="-1" aria-labelledby="notLoggedToChat-label" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="notLoggedToChat-label">Entre em sua conta</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Para entrar em contato com o prestador pelo chat, é necessário criar uma conta.
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                                        <a href="../../Entrar/login.php"><button type="button" class="btn btn-primary">Loggin / Cadastrar</button></a>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="row celphone-and-location order-md-4 flex-md-column">
                            <div class="col-auto order-2">
                                <div class="celphone-div">
                                    <svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0)">
                                            <rect width="24" height="24" transform="translate(0 12) rotate(-30)" fill="white"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.0393 5.04904L7.24505 9.54904C6.90052 9.74795 6.64912 10.0756 6.54616 10.4598C6.4432 10.8441 6.4971 11.2536 6.69601 11.5981L15.696 27.1865C15.8949 27.5311 16.2226 27.7825 16.6068 27.8854C16.9911 27.9884 17.4005 27.9345 17.745 27.7356L25.5393 23.2356C25.8838 23.0367 26.1352 22.709 26.2382 22.3248C26.3411 21.9405 26.2872 21.5311 26.0883 21.1865L17.0883 5.59808C16.8894 5.25355 16.5618 5.00215 16.1775 4.89919C15.7932 4.79622 15.3838 4.85013 15.0393 5.04904ZM6.49505 8.25C5.806 8.64782 5.3032 9.30308 5.09727 10.0716C4.89134 10.8402 4.99915 11.659 5.39697 12.3481L14.397 27.9365C14.7948 28.6256 15.4501 29.1284 16.2186 29.3343C16.9871 29.5402 17.806 29.4324 18.495 29.0346L26.2893 24.5346C26.9783 24.1368 27.4811 23.4815 27.6871 22.713C27.893 21.9445 27.7852 21.1256 27.3874 20.4365L18.3874 4.84808C17.9895 4.15902 17.3343 3.65623 16.5657 3.4503C15.7972 3.24437 14.9783 3.35218 14.2893 3.75L6.49505 8.25Z" fill="#888F98"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M20.8923 24.1865C21.2368 23.9876 21.4882 23.66 21.5912 23.2757C21.6942 22.8914 21.6402 22.482 21.4413 22.1375C21.2424 21.793 20.9148 21.5416 20.5305 21.4386C20.1463 21.3356 19.7368 21.3895 19.3923 21.5884C19.0478 21.7874 18.7964 22.115 18.6934 22.4992C18.5904 22.8835 18.6443 23.293 18.8433 23.6375C19.0422 23.982 19.3698 24.2334 19.7541 24.3364C20.1383 24.4393 20.5478 24.3854 20.8923 24.1865Z" fill="#FF6F6F"/>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0">
                                                <rect width="24" height="24" fill="white" transform="translate(0 12) rotate(-30)"/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    
                                    <p class="celphone-number"><?= $providerData['fone_usuario'] == '' ? 'O usuário não tem um telefone de contato' : $providerData['fone_usuario'] ?></p>
                                </div>
                            </div>
                            
                            <div class="col order-1 d-flex">
                                <div class="my-service-location-div">
                                    <?php if($serviceData['tipo_servico'] == 1) {?>
                                        <i class="fas fa-map-marker-alt"></i>
                                        <p class="my-service-location">
                                            <?php
                                                echo $providerData['uf_usuario'].", ".$providerData['cidade_usuario'].", ".$providerData['rua_usuario'].' '.$providerData['numero_usuario'];
                                            ?>
                                        </p>
                                    <?php } else {?>
                                        <i class="fas fa-laptop-house"></i>
                                        <p class="my-service-location">
                                            Serviço feito digitalmente
                                        </p>
                                    <?php }?>
                                </div>
                            </div>
                        </div>

                        <div class="hire-and-save row order-md-5">
                            <div class="col">
                                <?php if(isset($_SESSION['idUsuario'])){ ?>
                                    <?php if(!$isMyService){?>
                                        <?php if($avaliationPermited['status'] == 1){ ?>
                                            <button style="background-color: #d82929;"  class="my-hire-service-btn">Serviço já contratado</button>
                                        <?php } ?>
                                        <?php if($avaliationPermited['status'] == 0){ ?>
                                            <button style="background-color: #715c00;" class="my-hire-service-btn">Pedido pendente</button>
                                        <?php } ?>
                                        <?php if($avaliationPermited['status'] == 2){ ?>
                                            <button class="my-hire-service-btn">Contratar serviço</button>
                                        <?php } ?>
                                    <?php } else{?>
                                    <form action="../../EditarServico/editar_servico.php" method="POST">
                                        <input type="number" hidden name="serviceID" value="<?php echo $serviceID?>">
                                        <a href="#">
                                            <button class="btn btn-success" type="submit">
                                                Editar serviço
                                            </button>    
                                        </a>
                                    </form>
                                        
                                    <?php }?>
                                <?php } else{ ?>

                                    <button type="button" class="my-hire-service-btn-not-logged" data-bs-toggle="modal" data-bs-target="#notLoggedToHire-modal">
                                        Contratar serviço
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="notLoggedToHire-modal" tabindex="-1" aria-labelledby="notLoggedToHire-label" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="notLoggedToHire-label">Entre em sua conta</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Para contratar um serviço é necessário que você esteja loggado.
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                            <a href="../../Entrar/login.php"><button type="button" class="btn btn-primary">Loggin / Cadastrar</button></a>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="col-auto d-flex align-items-center ms-auto">
                                <div class="save-service-div">
                                    <?php if(isset($_SESSION['idUsuario'])){ ?>
                                        <button class="my-save-service-btn">
                                            <?php if($serviceIsSaved) {?>
                                                <svg id="saveSVG-unsave" width="46" height="44" viewBox="0 0 46 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="0.5" y="0.5" width="44.2941" height="43" rx="7.5" stroke="#FF6F6F"/>
                                                    <path d="M14 31L33 12" stroke="#FF6F6F" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M33 31L14 12" stroke="#FF6F6F" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            <?php } else {?>
                                            <svg id="saveSVG-save" width="46" height="44" viewBox="0 0 46 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="0.5" y="0.5" width="44.2941" height="43" rx="7.5" stroke="#FF6F6F"/>
                                                <path d="M12.6401 15.7143L13.6935 14.6667H19.4869L21.0669 16.7619H26.8604H31.0738V29.8572H12.6401V15.7143Z" fill="#FF6F6F"/>
                                                <path d="M21.0673 19.9047H23.174V22.5238H24.754H26.8607V24.0952H23.174V27.2381H21.0673V24.0952H17.9072V22.5238H21.0673V19.9047Z" fill="white"/>
                                            </svg>
                                           
                                        </button>
                                    <?php }?>
                                        <?php } else{ ?>
                                            <button type="button" class="btn p-0" data-bs-toggle="modal" data-bs-target="#notLoggedToSave-modal">
                                                <svg id="saveSVG-save" width="46" height="44" viewBox="0 0 46 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="0.5" y="0.5" width="44.2941" height="43" rx="7.5" stroke="#FF6F6F"/>
                                                    <path d="M12.6401 15.7143L13.6935 14.6667H19.4869L21.0669 16.7619H26.8604H31.0738V29.8572H12.6401V15.7143Z" fill="#FF6F6F"/>
                                                    <path d="M21.0673 19.9047H23.174V22.5238H24.754H26.8607V24.0952H23.174V27.2381H21.0673V24.0952H17.9072V22.5238H21.0673V19.9047Z" fill="white"/>
                                                </svg>
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="notLoggedToSave-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Entre em sua conta</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Para salvar um serviço é necessário que você esteja loggado.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                                    <a href="../../Entrar/login.php"><button type="button" class="btn btn-primary">Loggin / Cadastrar</button></a>
                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                        <?php } ?>
                
                                    <div class="save-service-label">
                                        <svg width="12" height="44" viewBox="0 0 12 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.3467 25.3L11.64 44V0L10.3467 16.5L0 20.9L10.3467 25.3Z" fill="#FF6F6F"/>
                                        </svg>
                                    
                                        <p>Salvar</p>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        
    </section> 

    <section id="myDesctiptionSection">
        <div class="container my-description-section-container">
            <div class="row">
                <div class="col-12">
                    <h2 class="my-description-title">Descrição</h2>
                    <p id="myDescriptionText" class="my-description-text">
                        <?php echo $serviceData['desc_servico'] ?>
                    </p>

                    <label id="myDescriptionToggleLabel" class="my-description-text--label-extend">Ler mais</label>
                </div>
            </div>
        </div>
    </section>

    <template id="myOtherServiceTemplate" >
        <a class="my-other-service-link mx-auto" href="#">
            <div class="my-other-service-card">
                <div class=" my-other-service--person-picture-div">
                    <!--img alt="Foto de perfil" src="" class="my-other-service--person-picture">-->
                </div>
                <div class="my-other-service-card--info">
                    <div class="my-other-service-card--header">
                        <h3 class="my-other-service-card--provider-name">----------</h3>
                        <div class="my-other-service-card--dot"></div>
                        <h4 class="my-other-service-card--service-name">----------</h4>
                    </div>
                    
                    <div class="my-other-service-card--rate-div">
                        <div class="my-rate-stars">
                            <svg class="service-rate-star" width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.44497 0.28627L10.3449 5.38246L10.3691 5.44752H10.4386H16.649L11.618 8.56749L11.5484 8.61066L11.577 8.68741L13.4668 13.7566L8.49847 10.6106L8.44497 10.5767L8.39147 10.6106L3.42316 13.7566L5.31298 8.68741L5.34132 8.61139L5.27278 8.56799L0.344844 5.44752H6.45139H6.52083L6.54509 5.38246L8.44497 0.28627Z" fill="#AAAAAA" stroke="black" stroke-width="0.2"/>
                            </svg>
                            <svg class="service-rate-star" width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.44497 0.28627L10.3449 5.38246L10.3691 5.44752H10.4386H16.649L11.618 8.56749L11.5484 8.61066L11.577 8.68741L13.4668 13.7566L8.49847 10.6106L8.44497 10.5767L8.39147 10.6106L3.42316 13.7566L5.31298 8.68741L5.34132 8.61139L5.27278 8.56799L0.344844 5.44752H6.45139H6.52083L6.54509 5.38246L8.44497 0.28627Z" fill="#AAAAAA" stroke="black" stroke-width="0.2"/>
                            </svg>
                            <svg class="service-rate-star" width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.44497 0.28627L10.3449 5.38246L10.3691 5.44752H10.4386H16.649L11.618 8.56749L11.5484 8.61066L11.577 8.68741L13.4668 13.7566L8.49847 10.6106L8.44497 10.5767L8.39147 10.6106L3.42316 13.7566L5.31298 8.68741L5.34132 8.61139L5.27278 8.56799L0.344844 5.44752H6.45139H6.52083L6.54509 5.38246L8.44497 0.28627Z" fill="#AAAAAA" stroke="black" stroke-width="0.2"/>
                            </svg>
                            <svg class="service-rate-star" width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.44497 0.28627L10.3449 5.38246L10.3691 5.44752H10.4386H16.649L11.618 8.56749L11.5484 8.61066L11.577 8.68741L13.4668 13.7566L8.49847 10.6106L8.44497 10.5767L8.39147 10.6106L3.42316 13.7566L5.31298 8.68741L5.34132 8.61139L5.27278 8.56799L0.344844 5.44752H6.45139H6.52083L6.54509 5.38246L8.44497 0.28627Z" fill="#AAAAAA" stroke="black" stroke-width="0.2"/>
                            </svg>
                            <svg class="service-rate-star" width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.44497 0.28627L10.3449 5.38246L10.3691 5.44752H10.4386H16.649L11.618 8.56749L11.5484 8.61066L11.577 8.68741L13.4668 13.7566L8.49847 10.6106L8.44497 10.5767L8.39147 10.6106L3.42316 13.7566L5.31298 8.68741L5.34132 8.61139L5.27278 8.56799L0.344844 5.44752H6.45139H6.52083L6.54509 5.38246L8.44497 0.28627Z" fill="#AAAAAA" stroke="black" stroke-width="0.2"/>
                            </svg>
                        </div>
                        <p class="my-rate-service-number">(<label>--</label>)</p>
                    </div>

                    <div class="my-other-service-card--location-div">
                        <i class="fas fa-map-marker-alt" aria-hidden="true"></i>

                        <p class="my-other-service-location">------</p>
                    </div>

                    <div class="my-other-service-card--price-div">
                        <h2 class="my-other-service-price">---------</h2>
                    </div>
                </div>
            </div>
        </a>
    </template>

    <section id="myOtherServicesSection">
        <h1 class="my-other-service-section-title">Outros Serviços</h1>

        <div class="glider-contain">
            <div class="glider"></div>

            <button aria-label="Previous" class="glider-prev my-glider-controller-arrow" id="myOtherServiceControllerLeft">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button aria-label="Next" class="glider-next my-glider-controller-arrow" id="myOtherServiceControllerRight">
                <i class="fas fa-chevron-right"></i>
            </button>

            <div role="tablist" class="dots"></div>
        </div>

    </section>

    <?php if($avaliationPermited['status'] == 1){ ?>
    <section id="myAvaliationSection">
        <div class="container-fluid">
            <h1 class="my-write-coment-section-title">Avalie este serviço</h1>

            <div class="row">
                <div class="col-12 my-write-coment">
                    <div class="my-write-rate">
                        <div class="my-rate-stars">
                            <svg class="service-rate-star" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.44497 0.28627L10.3449 5.38246L10.3691 5.44752H10.4386H16.649L11.618 8.56749L11.5484 8.61066L11.577 8.68741L13.4668 13.7566L8.49847 10.6106L8.44497 10.5767L8.39147 10.6106L3.42316 13.7566L5.31298 8.68741L5.34132 8.61139L5.27278 8.56799L0.344844 5.44752H6.45139H6.52083L6.54509 5.38246L8.44497 0.28627Z" fill="none" stroke="black" stroke-width="0.2"/>
                            </svg>
                            <svg class="service-rate-star" width="40" height="40" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.44497 0.28627L10.3449 5.38246L10.3691 5.44752H10.4386H16.649L11.618 8.56749L11.5484 8.61066L11.577 8.68741L13.4668 13.7566L8.49847 10.6106L8.44497 10.5767L8.39147 10.6106L3.42316 13.7566L5.31298 8.68741L5.34132 8.61139L5.27278 8.56799L0.344844 5.44752H6.45139H6.52083L6.54509 5.38246L8.44497 0.28627Z" fill="none" stroke="black" stroke-width="0.2"/>
                            </svg>
                            <svg class="service-rate-star" width="40" height="40" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.44497 0.28627L10.3449 5.38246L10.3691 5.44752H10.4386H16.649L11.618 8.56749L11.5484 8.61066L11.577 8.68741L13.4668 13.7566L8.49847 10.6106L8.44497 10.5767L8.39147 10.6106L3.42316 13.7566L5.31298 8.68741L5.34132 8.61139L5.27278 8.56799L0.344844 5.44752H6.45139H6.52083L6.54509 5.38246L8.44497 0.28627Z" fill="none" stroke="black" stroke-width="0.2"/>
                            </svg>
                            <svg class="service-rate-star" width="40" height="40" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.44497 0.28627L10.3449 5.38246L10.3691 5.44752H10.4386H16.649L11.618 8.56749L11.5484 8.61066L11.577 8.68741L13.4668 13.7566L8.49847 10.6106L8.44497 10.5767L8.39147 10.6106L3.42316 13.7566L5.31298 8.68741L5.34132 8.61139L5.27278 8.56799L0.344844 5.44752H6.45139H6.52083L6.54509 5.38246L8.44497 0.28627Z" fill="none" stroke="black" stroke-width="0.2"/>
                            </svg>
                            <svg class="service-rate-star" width="40" height="40" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.44497 0.28627L10.3449 5.38246L10.3691 5.44752H10.4386H16.649L11.618 8.56749L11.5484 8.61066L11.577 8.68741L13.4668 13.7566L8.49847 10.6106L8.44497 10.5767L8.39147 10.6106L3.42316 13.7566L5.31298 8.68741L5.34132 8.61139L5.27278 8.56799L0.344844 5.44752H6.45139H6.52083L6.54509 5.38246L8.44497 0.28627Z" fill="none" stroke="black" stroke-width="0.2"/>
                            </svg>
                          
                           
                        </div>

                        <div class="rate-stars-error-div alert alert-danger" role="alert">
                            Avalie este serviço com a pontuação desejada!
                        </div>
                    </div>
    
                    <div class="my-write-coment-content">
                       <!-- <img src="../../../assets/images/profile_images/teste.jpeg" alt="Foto de perfil" class="my-coment-profile-picture">-->
                        <img src="../../../assets/images/users/<?=$_SESSION['imagemPerfil']?>" alt="Foto de perfil" class="my-coment-profile-picture">
                        <textarea id="myWriteComentTextArea" class="my-write-coment-input" placeholder="Deixe seu comentário"></textarea>
                    </div>
    
                    <div class="write-rate-btn-div">
                        <button class="write-coment-btn-cancel">Cancelar</button>
                        <button class="write-coment-btn-send" disabled="true">Comentar</button>
                    </div>
                   
                </div>
            
            </div>
        </div>
    </section>
    <?php }?>

    <template id="myCommentTemplate">
        <div class="row my-coment-row">
            <div class="col-12 my-seen-coment">
                <div class="my-coment-header">
                    <div class="my-coment-profile-picture-div loading loading-comment-img">
                        <!--<img src="../../../assets/images/profile_images/teste.jpeg" alt="Foto de Perfil" class="my-coment-profile-picture">-->
                    </div>
                    
                    <h1 class="my-coment-user-name">Natan Rock</h1>
                    <p class="my-coment-publish-date">20/03/2020</p>
                    <div class="my-rate-stars">
                        <svg class="service-rate-star" width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.44497 0.28627L10.3449 5.38246L10.3691 5.44752H10.4386H16.649L11.618 8.56749L11.5484 8.61066L11.577 8.68741L13.4668 13.7566L8.49847 10.6106L8.44497 10.5767L8.39147 10.6106L3.42316 13.7566L5.31298 8.68741L5.34132 8.61139L5.27278 8.56799L0.344844 5.44752H6.45139H6.52083L6.54509 5.38246L8.44497 0.28627Z" fill="#FF9839" stroke="black" stroke-width="0.2"/>
                        </svg>
                        <svg class="service-rate-star" width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.44497 0.28627L10.3449 5.38246L10.3691 5.44752H10.4386H16.649L11.618 8.56749L11.5484 8.61066L11.577 8.68741L13.4668 13.7566L8.49847 10.6106L8.44497 10.5767L8.39147 10.6106L3.42316 13.7566L5.31298 8.68741L5.34132 8.61139L5.27278 8.56799L0.344844 5.44752H6.45139H6.52083L6.54509 5.38246L8.44497 0.28627Z" fill="#FF9839" stroke="black" stroke-width="0.2"/>
                        </svg>
                        <svg class="service-rate-star" width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.44497 0.28627L10.3449 5.38246L10.3691 5.44752H10.4386H16.649L11.618 8.56749L11.5484 8.61066L11.577 8.68741L13.4668 13.7566L8.49847 10.6106L8.44497 10.5767L8.39147 10.6106L3.42316 13.7566L5.31298 8.68741L5.34132 8.61139L5.27278 8.56799L0.344844 5.44752H6.45139H6.52083L6.54509 5.38246L8.44497 0.28627Z" fill="#FF9839" stroke="black" stroke-width="0.2"/>
                        </svg>
                        <svg class="service-rate-star" width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.44497 0.28627L10.3449 5.38246L10.3691 5.44752H10.4386H16.649L11.618 8.56749L11.5484 8.61066L11.577 8.68741L13.4668 13.7566L8.49847 10.6106L8.44497 10.5767L8.39147 10.6106L3.42316 13.7566L5.31298 8.68741L5.34132 8.61139L5.27278 8.56799L0.344844 5.44752H6.45139H6.52083L6.54509 5.38246L8.44497 0.28627Z" fill="#FF9839" stroke="black" stroke-width="0.2"/>
                        </svg>
                        <svg class="service-rate-star" width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.44497 0.28627L10.3449 5.38246L10.3691 5.44752H10.4386H16.649L11.618 8.56749L11.5484 8.61066L11.577 8.68741L13.4668 13.7566L8.49847 10.6106L8.44497 10.5767L8.39147 10.6106L3.42316 13.7566L5.31298 8.68741L5.34132 8.61139L5.27278 8.56799L0.344844 5.44752H6.45139H6.52083L6.54509 5.38246L8.44497 0.28627Z" fill="#AAAAAA" stroke="black" stroke-width="0.2"/>
                        </svg>
                    </div>

                    <div class="my-coment-3-dot">
                        <button class="my-coment-tecnical-option-3-dot">
                            <div class="service-dot"></div>
                            <div class="service-dot"></div>
                            <div class="service-dot"></div>
                        </button>

                        <div id="serviceMenuOptions" class="service-dot-options-menu comment-dot-menu">
                            <button type="button" id="reportCommentID" data-bs-toggle="modal" data-bs-target="#reportComent" class="service-dot-item ">
                                Denunciar Comentário
                            </button>
                        </div>
                    </div>

                     <!-- Modal de denúncia de comentário antigo
                     <div class="modal fade" id="reportComent" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div id="myReportModalDialog" class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                          <div class="modal-content">
                            <div id="myReportModalBody" class="modal-body">
                              
                            </div>
                          </div>
                        </div>
                    </div> -->

                    <!-- modal de denúncia de serviço -->
                    <div class="modal fade" id="reportComent" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-body" id="myReportModalBody"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="my-coment-body">
                    <p class=" dont-break-out my-coment-text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis nec libero a leo mattis imperdiet. Vivamus eleifend ipsum et erat efficitur, non porttitor est ultricies. Nunc mauris est, gravida ac odio eu, vulputate venenatis leo.
                    </p>

                    <label class="my-coment-read-more">Ler Mais</label>
                </div>
            </div>
        </div>
    </template>

    <section id="myComentSection">
        <div class="container-fluid my-coment-section-container">
            <h1 class="my-coment-section-title">Comentários</h1>
            
        </div>
    </section>

    <input type="hidden" hidden id="getServiceIdForComplain" value="<?=$serviceData['id_servico']?>">

    <footer id="myMainFooter">
        <div id="myMainFooterContainer" class="container-fluid">
            <div class="my-main-footer-logo">
                <img src="../../../assets/images/dumb-footer.png" alt="Tá por Aqui" class="my-footer-img">
            </div>
            <div class="my-main-footer-institutional">
                <p>INSTITUCIONAL</p>
                <a href="../../ComoFunciona/comoFunciona.php">Quem Somos</a> <br>
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

    
<div id="mobileBottomNavbarSection-spacer"></div>
<section id="mobileBottomNavbarSection" class="d-fixed d-sm-none">
        <div class="container-fluid">
            <div class="row">
                <div class="col mobile-navbar-item">
                    <a href="../../Home/home.php">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M25.333 29.3332H6.66634C5.92996 29.3332 5.33301 28.7363 5.33301 27.9999V15.2186C5.33301 14.865 5.47361 14.5259 5.72367 14.2759L15.057 4.94256C15.3071 4.69219 15.6465 4.55151 16.0003 4.55151C16.3542 4.55151 16.6936 4.69219 16.9437 4.94256L26.277 14.2759C26.5273 14.5256 26.6675 14.865 26.6663 15.2186V27.9999C26.6663 28.7363 26.0694 29.3332 25.333 29.3332ZM13.333 19.9999H18.6663V26.6666H23.9997V15.7706L15.9997 7.77056L7.99967 15.7706V26.6666H13.333V19.9999Z" fill="#888F98"/>
                        </svg>

                        <p>Home</p>
                    </a>
                </div>
                <div class="col mobile-navbar-item ">
                    <a href="../../Chat/chat.php">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.7351 23.7713L11.6065 24.2371C12.9568 24.959 14.4648 25.3356 15.996 25.3333L16 25.3333C21.1548 25.3333 25.3333 21.1548 25.3333 16C25.3333 10.8452 21.1548 6.66667 16 6.66667C10.8452 6.66667 6.66668 10.8452 6.66668 16V16.004C6.66437 17.5352 7.04097 19.0432 7.76289 20.3935L8.22873 21.2649L7.51244 24.4876L10.7351 23.7713ZM4.00001 28L5.41121 21.6508C4.48185 19.9125 3.99705 17.9712 4.00001 16C4.00001 9.3724 9.37241 4 16 4C22.6276 4 28 9.3724 28 16C28 22.6276 22.6276 28 16 28C14.0288 28.003 12.0875 27.5181 10.3492 26.5888L4.00001 28Z" fill="#888F98"/>
                        </svg>

                        <p>Chat</p>
                    </a>
                </div>

                <?php if($isProvider){ ?>
                    <div class="col mobile-navbar-item getting-out">
                        <a href="../../Perfil/CriacaoServico/criar_servico.php">

                           <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20.5714 9.85714H14.1429V3.42857C14.1429 2.63973 13.5031 2 12.7143 2H11.2857C10.4969 2 9.85714 2.63973 9.85714 3.42857V9.85714H3.42857C2.63973 9.85714 2 10.4969 2 11.2857V12.7143C2 13.5031 2.63973 14.1429 3.42857 14.1429H9.85714V20.5714C9.85714 21.3603 10.4969 22 11.2857 22H12.7143C13.5031 22 14.1429 21.3603 14.1429 20.5714V14.1429H20.5714C21.3603 14.1429 22 13.5031 22 12.7143V11.2857C22 10.4969 21.3603 9.85714 20.5714 9.85714Z" fill="white"/>
                            </svg>
                        </a>
                    </div>
                <?php } ?>

                <div class="col mobile-navbar-item">
                    <a href="../Listagem/listagem.php">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.0005 29.3335C13.9845 29.3391 11.9941 28.883 10.1818 28.0001C9.51852 27.6775 8.88303 27.3006 8.28179 26.8734L8.09912 26.7401C6.44555 25.5196 5.09362 23.9364 4.14713 22.1121C3.16811 20.2239 2.66034 18.127 2.66706 16.0001C2.66706 8.63628 8.63666 2.66675 16.0005 2.66675C23.3643 2.66675 29.3339 8.63628 29.3339 16.0001C29.3405 18.1259 28.8332 20.2219 27.8551 22.1094C26.9099 23.9327 25.5599 25.5153 23.9085 26.7361C23.2855 27.1921 22.6244 27.5936 21.9325 27.9361L21.8258 27.9894C20.0124 28.877 18.0195 29.3368 16.0005 29.3335ZM16.0005 22.6667C14.0024 22.6628 12.1707 23.7788 11.2578 25.5561C14.2463 27.0363 17.7546 27.0363 20.7431 25.5561V25.5494C19.8291 23.7741 17.9973 22.6606 16.0005 22.6667ZM16.0005 20.0001C18.8886 20.0039 21.5517 21.5602 22.9725 24.0747L22.9925 24.0574L23.0111 24.0414L22.9885 24.0614L22.9751 24.0721C26.3471 21.1589 27.5528 16.4565 25.9987 12.2802C24.4445 8.10392 20.4579 5.33384 16.0018 5.33384C11.5457 5.33384 7.55912 8.10392 6.00493 12.2802C4.45074 16.4565 5.65646 21.1589 9.02846 24.0721C10.4501 21.5588 13.1129 20.0036 16.0005 20.0001ZM16.0005 18.6667C13.0549 18.6667 10.6671 16.2789 10.6671 13.3334C10.6671 10.3879 13.0549 8.00008 16.0005 8.00008C18.946 8.00008 21.3338 10.3879 21.3338 13.3334C21.3338 14.7479 20.7719 16.1045 19.7717 17.1047C18.7715 18.1048 17.4149 18.6667 16.0005 18.6667ZM16.0005 10.6667C14.5277 10.6667 13.3338 11.8607 13.3338 13.3334C13.3338 14.8062 14.5277 16.0001 16.0005 16.0001C17.4732 16.0001 18.6671 14.8062 18.6671 13.3334C18.6671 11.8607 17.4732 10.6667 16.0005 10.6667Z" fill="#888F98"/>
                        </svg>


                        <p>Pesquisar</p>
                    </a>
                </div>
                <div class="col mobile-navbar-item ">
                    <a href="../../Perfil/meu_perfil.php">
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
 
   
    <?php if(!$isMyService && isset($_SESSION['idUsuario'])){?>
        <script>
            const hireServiceHandler = () => {
            let btnHire = document.querySelector('.my-hire-service-btn');
            btnHire.onclick = () => {
                let request = new XMLHttpRequest();
                
                request.onload = () => {
                    if(request.status === 200 && request.readyState === XMLHttpRequest.DONE){
                        console.log(request.response)
                        let info = JSON.parse(request.response);
                        console.log(info)


                        if(!info.logged){
                            let myModal = new bootstrap.Modal(document.getElementById('notLoggedModal'))
                            myModal.toggle()
                            return false;
                        }

                        let statusConfig = [ 
                            {
                                color:'#715c00',
                                text: 'Contrato: Pedido Pendente'
                            },
                            {
                                color:'#d82929', 
                                text: 'Serviço já contratato'
                            },
                            {
                                color:'#06A77D', 
                                text: 'Contratar serviço'
                            },
                        ];

                        btnHire.style.backgroundColor = statusConfig[info.status].color;
                        btnHire.innerHTML = statusConfig[info.status].text;
                    }
                    
                }
        //data-bs-toggle="modal" data-bs-target="#notLoggedModal"
                request.open('POST', '../../../logic/contratar_servico.php');
                request.send();
            }
        }
        hireServiceHandler()
        </script>
    <?php }?>

    <?php if($avaliationPermited['status'] == 1 && !$isMyService){ ?>
    <script type="module">
        import {commentsDataHandler, refreshAverageRate} from './visualizarServico.js';

        const ajaxTrigger = (data) => // esta funcao rebe os valores e os envia para o Back
        {

            const config = {
                sendComment : 'true',
                sendCommentData : data
            };

            let xhr = new XMLHttpRequest();
            xhr.onload = () => {
                if(xhr.status === 200 && xhr.readyState === XMLHttpRequest.DONE){
                    console.log(xhr.response);
                    console.log("a")
                    let response = JSON.parse(xhr.response);
                    console.log("b")
                    let allInfo = response.sendComment;
                    console.log(allInfo);
                    if(allInfo.refreshAllComments){
                        
                        let comments = allInfo.data;
                        let commentSection = document.querySelector('.my-coment-section-container');
                        let headingSection = '<h1 class="my-coment-section-title">Comentários</h1>';
                        commentSection.innerHTML = headingSection;
                        
                        console.log(comments)
                        commentsDataHandler(comments);
                        console.log(allInfo);
                        refreshAverageRate(allInfo.updatedAverage);
                    }
                }
            }

            xhr.open("POST", "./getAsyncData.php");
            xhr.send(JSON.stringify(config));
        }

        const writeCommentResizeTextArea = () => { // esta funcao evita que o textarea tenha scroll, pois aumenta seu tamenho de acodo com o texto
            textarea_e.style.height = '1px';
            textarea_e.style.minHeight = '1px';
            textarea_e.style.maxHeight = '1px';

            textarea_e.style.minHeight = (textarea_e.scrollHeight) + "px";
            textarea_e.style.maxHeight = (25 + textarea_e.scrollHeight) + "px";
            textarea_e.style.height = ( textarea_e.scrollHeight) + "px";
        }


        const rateDOM = () => {// manipula a interacao com a DOM com a avaliacao do servico
            let section = document.querySelector('#myAvaliationSection'); // esta eh a section que engloba todos os elementos que serao utilizados 

            let stars = section.querySelectorAll('.my-write-rate svg'); // sao os svg de estrelas de pontuacao
            let textArea = section.querySelector('#myWriteComentTextArea'); // o input de comentario
            
            let btnActionDiv = section.querySelector('.write-rate-btn-div'); // eh a div que engloba os btn enviar e cancelar
            let btnAction = {// btn enviar e cancelar
                cancel : section.querySelector('.write-coment-btn-cancel'),
                send : section.querySelector('.write-coment-btn-send')
            }

            let alertDiv = section.querySelector('.rate-stars-error-div'); // div de alert de erro ou falta de dados

            let state = { // aqui estao todos os dados 
                rateNumber: 0, // esta eh a nota de aviacao
                comment: '', // comentario
                textAreafocus : false // caso o o input de comentario foi selecionado (a btnActionDiv sera mostrada)
            }

            const paintStars = () => { // pinta as estrelinhas selecionadas, o valor esta no state.
                for(let i =0 ;i < stars.length; i++){ // descolore todas
                    stars[i].querySelector('path').setAttribute('fill', "none");
                }

                for(let i = 0; i < state.rateNumber && i < stars.length; i++){ // pinta de acordo com o numero contido no state 
                    stars[i].querySelector('path').setAttribute('fill', "#FF9839");
                }
            }

            const showBtnAction = () => { // cuida de mostrar ou esconder a div de btn de acao
                if(state.textAreafocus) // caso o input de comatario foi selecionado
                    btnActionDiv.style.display = 'flex';
                else
                    btnActionDiv.style.display = 'none';
            }

            const togglebtnSendColor = () => { // cuida de deixar o btn send ativo ou sesativado
                if(state.comment === ""){ // caso nao tenha comentario nenhum.
                    btnAction.send.disabled = true
                }
                else{
                    btnAction.send.disabled = false
                }
            }

            const textAreaHandler = () => { // cuida de preencher o textarea com o valor do state
                textArea.value = state.comment;
                togglebtnSendColor(); // atualiza a cor do btn
            }

            const refreshAll = (obj) => { // quando atualiza o state, ela deve atualizar tudo que depende da propriedade que foi atualizada
                if('rateNumber' in obj) // caso atulizaou o valor de avaliacao
                    paintStars(); // refaz as estrelinhas
                if('comment' in obj) // caso mudou o comentario
                    textAreaHandler(); // atualiza o que depende do comentario
                if('textAreafocus' in obj) // caso focalizou no input 
                    showBtnAction(); // atualiza o que depende desse estado 
            }

            const setState = (obj = null) => { // funcao que serve para atualizar o state. Deve ser enviado um obj para ela com a propriedade e o valor que se deseja inserir nela 
                if(!obj) return;
                
                for(let i in obj){
                    if(state[i] !== obj[i]){ // caso a propriedade enviada for diferente da que ja existe
                        state[i] = obj[i]; // atualiza o state 
                        refreshAll(obj) // atualiza a interface com base no state atualizado 
                    }
                }
            }

            stars.forEach((star, index) => { // acad estrelinha devera ter uma funcao onclick para atualizar o state com o valor da avaliacao
                star.onclick = () => {
                    setState({rateNumber : index + 1});
                }
            });

            const clearFields = () => { // limpa todo o state.
                setState({comment: '', rateNumber: 0, textAreafocus: false})
            }

            btnAction.cancel.onclick = () => {
                clearFields();
                writeCommentResizeTextArea()
            }

            btnAction.send.onclick = () => {
                if(state.rateNumber > 0  && state.comment !== ""){ // caso os valores forem validos 
                    ajaxTrigger(state); // manda para a funcao de ajax 
                    clearFields(); // limpa os campos 
                    alertDiv.style.display = 'none'; // retira o alert de erro
                }
                else{
                    alertDiv.style.display = 'block'; // coloca o alert de erro
                }

                writeCommentResizeTextArea();
            }

            if(textArea.addEventListener){ // caso seja suportado o eventListener 
                textArea.addEventListener('input',(value) => { // caso o usuario digite algo
                    setState({comment: textArea.value});
                })

                textArea.addEventListener('focus', () => { // caso o susario facalize o input
                    setState({textAreafocus: true});
                })

            /*  stars.forEach((star, index) => {
                    star.addEventListener('mousemove', () => {
                        setState({rateNumber : index + 1});
                    })

                    star.onclick = () => {
                    
                    }
                });*/
            }
            else if (textArea.attachEvent) { // para IE
                area.attachEvent('onpropertychange', () => {
                    setState({comment: textArea.value});
                });
            }

        }

        rateDOM();

        let textarea_e = document.getElementById("myWriteComentTextArea");
        textarea_e.onkeydown = writeCommentResizeTextArea;

        writeCommentResizeTextArea();
    </script>
    <?php }?>

</body>
</html>