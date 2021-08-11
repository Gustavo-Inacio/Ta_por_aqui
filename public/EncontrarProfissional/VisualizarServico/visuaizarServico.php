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
    $providerAvarege = $brain->getProviderAverage();

    $serviceIsSaved = false;
    if(isset($_SESSION['idUsuario'])){
        $serviceIsSaved = $brain->getSaveService($_SESSION['idUsuario']);
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://kit.fontawesome.com/2a19bde8ca.js" crossorigin="anonymous" defer></script>

    <title>Tá por aqui</title>

    <link rel="stylesheet" href="../../../assets/bootstrap/bootstrap-4.5.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../assets/global/globalStyles.css">

    <link rel="stylesheet" href="../../../assets/glider/glider.css">

    <link rel="stylesheet" href="../../Denuncia/denuncia.css">
    <link rel="stylesheet" href="./visualizarServico.css">

    <script src="../../../assets/bootstrap/jquery-3.5.1.slim.min.js" defer></script>
    <script src="../../../assets/bootstrap/popper.min.js" defer></script>
    <script src="../../../assets/bootstrap/bootstrap-4.5.3-dist/js/bootstrap.min.js" defer></script>

    <script src="../../../assets/glider/glider.js" defer></script>

    <script src="../../../assets/global/globalScripts.js" defer></script>
    <script src="./visualizarServico.js" type="module" defer></script>

   <!-- <script src="./enviarAvaliacao.js" defer></script> <!-Somente quado o usuario puder enviar a avalizacao-->
</head>
<body>

    <iframe  id="myReportIframe" src="../../Denuncia/denuncia.html" style="display: none;"></iframe>

    <!--NavBar Comeco-->
    <div id="myMainTopNavbarNavBackdrop" class=""></div>
    <nav id="myMainTopNavbar" class="navbar navbar-expand-md">
        <a href="#" id="myMainTopNavbarBrand" class="navbar-brand">
            <img src="../../../assets/images/dumb-brand.png" alt="Tá por aqui" class="my-brand-img">
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
                <a href="../../Home/home.php" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
                <a href="../Listagem/listagem.php" class="nav-link">Encontre um pofissional</a>
            </li>
            <li class="nav-item">
                <a href="../../Artigos/artigos.html" class="nav-link">Artigos</a>
            </li>
            <li class="nav-item">
                <a href="../../Contato/contato.php" class="nav-link">Fale conosco</a>
            </li>
            <li class="nav-item">
                <a href="../../SobreNos/sobreNos.php" class="nav-link">Sobre</a>
            </li>
            <li class="nav-item">
                <a href="../../Chat/chat.html" class="nav-link">Chat</a>
            </li>
            <?php if( empty($_SESSION['idUsuario']) ){ ?>
                <li class="nav-item">
                    <a href="../../Entrar/login.php" class="nav-link">Entrar/cadastrar</a>
                </li>
            <?php }?>
        </ul>

            <?php if( isset($_SESSION['idUsuario']) && isset($_SESSION['email']) && isset($_SESSION['senha']) && isset($_SESSION['classificacao']) ) {?>
                <div class="dropdown">
                    <img src="../../../assets/images/users/<?=$_SESSION['imagemPerfil']?>" alt="imagem de perfil" id="profileMenu" class="img-fluid" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    <div class="dropdown-menu" aria-labelledby="profileMenu">
                        <a class="dropdown-item" href="../../Perfil/meu_perfil.php">Perfil</a>
                        <a class="dropdown-item text-danger" href="../../../logic/entrar_logoff.php">Sair</a>
                    </div>
                </div>
            <?php } ?>
    </div>
        
    </nav>
    <!--NavBar Fim-->
    
    <section id="myInfoSection">
        <div id="myInfoContainer" class="container">
            <div class="row my-top-service-info-row">
                <div class="col">
                    <h2 id="myTopRow--providerName" class="provider-name">
                        <?php echo $providerData['nome']. ' ' .$providerData['sobrenome']?>
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
                            <?php echo $serviceData['data_publicacao']; ?>
                        </p>

                        <div class="service-dot-options">
                            <div class="service-3dot">
                                <div class="service-dot"></div>
                                <div class="service-dot"></div>
                                <div class="service-dot"></div>
                            </div>

                            <div id="serviceMenuOptions" class="service-dot-options-menu">
                                <a href="#" class="service-dot-item">
                                    <button type="button" class="" data-toggle="modal" data-target="#serviceReportModal">
                                        Denunciar Serviço
                                    </button>
                                    
                                </a>
                            </div>

                             <!-- Modal -->
                             <div class="modal fade" id="serviceReportModal" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div id="myReportModalDialog" class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                  <div class="modal-content">
                                    <div id="myReportModalBody" class="modal-body">
                                      
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

        <div class="container my-service-main-content-container">
            <div class="row my-service-main-content-row">
                <div class="my-service-main-content--carousel-area">
                    <div id="myMainServiceCarousel" class="my-main-carousel carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php foreach ($serviceImg as $i => $img) {?>
                                <div class="carousel-item <?=$i === 0 ? "active" : ""?>">
                                    <img src="../../../assets/images/users/<?php echo $img;?>" class="d-block w-100" alt="SERVICE-IMG">
                                </div>
                            <?php }?>
                        </div>

                        <a class="carousel-control-prev" href="#myMainServiceCarousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                          </a>
                          <a class="carousel-control-next" href="#myMainServiceCarousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                          </a>
                    </div>

                    <div class="my-service-carousel-img-indicators">
                        <?php foreach ($serviceImg as $i => $img) {?>
                            <div class="my-carousel-indicator-item <?=$i == 0 ? "active" : ""?>">
                                <img src="../../../assets/images/users/<?php echo $img;?>" class="d-block w-100" alt="SERVICE-IMG">
                            </div>
                        <?php }?>
                    </div>

                    <div class="my-service-location-div my-service-location-div-under-carousel">
                        <i class="fas fa-map-marker-alt"></i>
                        <p class="my-service-location">
                            <?php 
                                echo $providerData['estado'].", ".$providerData['cidade'].", ".$providerData['rua'].' '.$providerData['numero']; 
                            ?>
                    </div>
                </div>

                <div class="my-service-main-content--info-area">
                    <div class="service-price">
                        <h1 class="service-price-text"><?php echo $serviceData['orcamento']; ?></h1>
                    </div>

                    <h2 id="myProviderName" class="provider-name provider-name-mobile"><?php echo $providerData['nome']; ?></h2>
                    <h2 id="myServiceName" class="service-name"><?php echo $serviceData['nome_servico']; ?></h2>

                    
 
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

                    <a href="#" class="contact-chat-btn-a">
                        <button>
                            <label>Entrar em contato </label>
                            <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.2 0H1.8C0.81 0 0.00899999 0.855 0.00899999 1.9L0 19L3.6 15.2H16.2C17.19 15.2 18 14.345 18 13.3V1.9C18 0.855 17.19 0 16.2 0ZM3.6 6.65H14.4V8.55H3.6V6.65ZM10.8 11.4H3.6V9.5H10.8V11.4ZM14.4 5.7H3.6V3.8H14.4V5.7Z" fill="#3333CC"/>
                            </svg>    
                        </button>
                    </a>

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
                        
                        <p class="celphone-number"><?php echo $providerData['telefone'] ?></p>
                    </div>

                    <div class="my-service-location-div">
                        <?php if($serviceData['tipo'] == 1) {?>
                            <i class="fas fa-map-marker-alt"></i>
                            <p class="my-service-location">
                                <?php
                                    echo $providerData['estado'].", ".$providerData['cidade'].", ".$providerData['rua'].' '.$providerData['numero'];
                                ?>
                            </p>
                        <?php } else {?>
                            <i class="fas fa-laptop-house"></i>
                            <p class="my-service-location">
                                Serviço feito digitalmente
                            </p>
                        <?php }?>
                    </div>

                    <div class="modal fade" id="notLoggedModal" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div id="notLoggedModallDialog" class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                            <div class="modal-content">
                                <div id="notLoggedModal" class="modal-body">
                                    <h1>Para contratar um serviço é necessário que você esteja loggado.</h1>
                                    <a href="../../Entrar/login.php" class="nav-link">Entrar/cadastrar</a>
                                </div>
                            </div>
                        </div>
                    </div>


                    <?php if($avaliationPermited['status'] == 1){ ?>
                        <button style="background-color: #d82929;"  class="my-hire-service-btn">Serviço já contratado</button>
                    <?php } ?>
                    <?php if($avaliationPermited['status'] == 0){ ?>
                        <button style="background-color: #715c00;" class="my-hire-service-btn">Pedido pendente</button>
                    <?php } ?>
                    <?php if($avaliationPermited['status'] == 2){ ?>
                        <button class="my-hire-service-btn">Contratar serviço</button>
                    <?php } ?>
                    
                    <div class="save-service-div">
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
                            <?php }?>

                        </button>
    
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
    </section> 

    <section id="myDesctiptionSection">
        <div class="container my-description-section-container">
            <div class="row">
                <div class="col-12">
                    <h2 class="my-description-title">Descrição</h2>
                    <p id="myDescriptionText" class="my-description-text">
                        <?php echo $serviceData['descricao'] ?> 
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
                        <h3 class="my-other-service-card--provider-name">Marcos</h3>
                        <div class="my-other-service-card--dot"></div>
                        <h4 class="my-other-service-card--service-name">Pedreiro</h4>
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
                        <p class="my-rate-service-number">(<label>4.0</label>)</p>
                    </div>

                    <div class="my-other-service-card--location-div">
                        <i class="fas fa-map-marker-alt" aria-hidden="true"></i>

                        <p class="my-other-service-location">Moab, UT</p>
                    </div>

                    <div class="my-other-service-card--price-div">
                        <h2 class="my-other-service-price">$ Orçamento</h2>
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
                        <img src="../../../assets/images/profile_images/<?=$_SESSION['imagemPerfil']?>" alt="Foto de perfil" class="my-coment-profile-picture">
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
                            <button type="button" id="reportCommentID" data-toggle="modal" data-target="#reportComent" class="service-dot-item ">
                                Denunciar Comentário
                            </button>
                        </div>
                    </div>

                     <!-- Modal -->
                     <div class="modal fade" id="reportComent" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div id="myReportModalDialog" class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                          <div class="modal-content">
                            <div id="myReportModalBody" class="modal-body">
                              
                            </div>
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

    <footer id="myMainFooter">
        <div id="myMainFooterContainer" class="container-fluid">
            <div class="my-main-footer-logo">
                <img src="../../../assets/images/dumb-footer.png" alt="Tá por Aqui" class="my-footer-img">
            </div>
            <div class="my-main-footer-institutional">
                <p>INSTITUCIONAL</p>
                <a href="../../SobreNos/sobreNos.php">Quem Somos</a> <br>
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
 
    <!--<div class="test">
        <p class="xs">xs</p>
        <p class="sm">sm</p>
        <p class="md">md</p>
        <p class="lg">lg</p>
        <p class="xl">xl</p>
    </div>-->

    <?php if($avaliationPermited['status'] == 1){ ?>
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