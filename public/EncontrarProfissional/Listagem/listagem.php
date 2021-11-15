<?php
session_start();

$_SESSION['listServices'] = true;
$searchQuery = "";
if(isset($_GET['query'])){
    $searchQuery = $_GET['query'];
}

//caso haja cookies salvos no pc do usuário, ele vai logar com os cookies salvos
require "../../../logic/entrar_cookie.php";

$isProvider = false;

if(isset($_SESSION['classificacao']) && $_SESSION['classificacao'] >= 1){
    $isProvider = true;
}

$logged = 'false';
if (isset($_SESSION['idUsuario']) && $_SESSION['idUsuario'] !== ""){
    $logged = 'true';
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tá por aqui - Encontre um profissional</title>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../../../assets/global/globalStyles.css">
    <link rel="stylesheet" href="listagem.css">

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/2a19bde8ca.js" crossorigin="anonymous" defer></script>
    <script src="../../../assets/global/globalScripts.js" defer></script>
    <script type="module" src="listagem.js" defer></script>
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
                        <a href="listagem.php" class="nav-link">Encontre um profissional</a>
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

    <section id="contentSection" class="container-lg">
   
        <div class="categories-backdrop"></div>
        <template id="myCategorieItemTemplate">
            <div class="categorie-item">
                <p class="categorieName">...</p>
                <svg class="categorieArrow" width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 10.59L4.58 6L0 1.41L1.41 0L7.41 6L1.41 12L0 10.59Z" fill="black"/>
                </svg>
            </div>
        </template>

        <template id="mySUBCategorieItemTemplate">
            <div class="subcategorie-container">   
                <div class="subCategorie-header">
                    <h1 class="subCategorie-section-title">...</h1>
                </div> 
                <div class="subCategorieBody">
                    <div class="subCategorie-item">
                        <label class="subCategorie-title left-col dont-break-out">... 01</label>
                    </div>
                    <div class="subCategorie-item">
                        <label class="subCategorie-title right-col dont-break-out">... 02</label>
                    </div>
                    <div class="subCategorie-item">
                        <label class="subCategorie-title left-col dont-break-out">... 03</label>
                    </div>
                </div>

            </div>
        </template>

      <!--  <section class="categoriesSection my-nice-scroll-bar hide-sidebar">
            <div class="title-area">
                <h1>Categorias</h1>
            </div>
            <div class="categoriesSectionBody my-nice-scroll-bar">
                
            </div>
        </section> -->

        <div class="row">
            <div id="cat-container" class=" col-md-4 my-nice-scroll-bar">
                <div class="row ">
                    <section class="cool-categories-section">
                        <header class="row ">
                            <svg class="my-categories-toggle-btn" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.6902 8.41707L11.3658 1.74147C11.6878 1.41951 12.2098 1.41951 12.5317 1.74147L13.3103 2.52007C13.6317 2.84148 13.6323 3.36239 13.3117 3.68456L8.02111 9.00002L13.3117 14.3154C13.6323 14.6376 13.6317 15.1585 13.3103 15.4799L12.5317 16.2585C12.2097 16.5805 11.6878 16.5805 11.3658 16.2585L4.6902 9.58296C4.36827 9.26101 4.36827 8.73903 4.6902 8.41707Z" fill="white"/>
                            </svg>

                            <h1 class="h1">Categorias</h1>
                        </header>
                        <div class="content row ">
                            
                            <div class="col-12 cat-view">
                                <!-- <div class="row cat-item selected">
                                    <div class="col">
                                        <p class="cat-text">Programação e Tecnologia</p>

                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7.482 11.831L1.54814 5.89714C1.26195 5.61096 1.26195 5.14698 1.54814 4.86082L2.24023 4.16873C2.52592 3.88304 2.98896 3.88249 3.27532 4.16751L8.00018 8.87023L12.725 4.16751C13.0114 3.88249 13.4744 3.88304 13.7601 4.16873L14.4522 4.86082C14.7384 5.14701 14.7384 5.61099 14.4522 5.89714L8.51835 11.831C8.23217 12.1172 7.76819 12.1172 7.482 11.831Z" fill="#3333CC"/>
                                        </svg>
                                    </div>
                                </div>-->
                            </div>
                            <div class="col-12 subcat-view">
                                <header class="row">
                                    <div class="back-to-main-menu">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7.9848 13.7857H21.4643C21.7601 13.7857 22 13.5458 22 13.25V10.75C22 10.4541 21.7601 10.2143 21.4643 10.2143H7.9848V8.15806C7.9848 7.20351 6.83074 6.72547 6.15574 7.40043L2.31383 11.2423C1.89539 11.6608 1.89539 12.3392 2.31383 12.7576L6.15574 16.5995C6.83069 17.2744 7.9848 16.7964 7.9848 15.8418V13.7857Z" fill="#3333CC"/>
                                        </svg>

                                        <h1>Voltar Para o menu Principal</h1>
                                    </div>
                                </header>
                                <div class="row content">
                                    
                                </div>
                            </div>

                        </div>
                        
                    </section>
                </div>
            </div>
            
            
            <section class="filter-service-cards col-12 col-md-8">
                <section id="mySearchBarSection">
                    <div class="my-categories-toggler-btn-path">
                        <button class="my-categories-toggle-btn">
                            <div></div>
                            <div></div>
                            <div></div>
                        </button>
                    </div>
                    
                    <form class="d-flex w-100" action="./listagem.php" method="GET">
                        <button type="submit" id="searchButton" class="serarch-icon-btn">
                            <div class="serarch-icon-div">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21.7261 19.2913L17.832 15.3971C17.6562 15.2214 17.4179 15.1237 17.168 15.1237H16.5313C17.6093 13.7449 18.2499 12.0107 18.2499 10.1242C18.2499 5.63636 14.6135 2 10.1257 2C5.63783 2 2.00146 5.63636 2.00146 10.1242C2.00146 14.612 5.63783 18.2484 10.1257 18.2484C12.0122 18.2484 13.7464 17.6079 15.1252 16.5298V17.1665C15.1252 17.4165 15.2228 17.6547 15.3986 17.8305L19.2927 21.7246C19.6599 22.0918 20.2536 22.0918 20.6168 21.7246L21.7222 20.6193C22.0893 20.2521 22.0893 19.6584 21.7261 19.2913ZM10.1257 15.1237C7.36422 15.1237 5.12616 12.8896 5.12616 10.1242C5.12616 7.36276 7.36032 5.12469 10.1257 5.12469C12.8871 5.12469 15.1252 7.35885 15.1252 10.1242C15.1252 12.8857 12.891 15.1237 10.1257 15.1237Z" fill="#CCCCCC"/>
                                </svg>
                            </div>
                        </button>
                        

                        <div class="search-input-area-div">
                            <input id="searchBar" type="text" name="query" value="<?php echo $searchQuery; ?>">
                            <input type="hidden" name="tmpLat" id="tmpLat" value="<?= $_GET['tmpLat'] ?? '' ?>">
                            <input type="hidden" name="tmpLng" id="tmpLng" value="<?= $_GET['tmpLng'] ?? '' ?>">
                        </div>
                    </form>
                    
                </section>

                <!-- <section id="searchTagSection">
                    <template class="search-tags-template">
                        <div class="search-tag">
                            <label class="search-tag-title"></label>
                            <svg class="search-tag-clear-tag" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0)">
                                <path d="M7 0.875C5.37555 0.875 3.81763 1.52031 2.66897 2.66897C1.52031 3.81763 0.875 5.37555 0.875 7C0.875 8.62445 1.52031 10.1824 2.66897 11.331C3.81763 12.4797 5.37555 13.125 7 13.125C8.62445 13.125 10.1824 12.4797 11.331 11.331C12.4797 10.1824 13.125 8.62445 13.125 7C13.125 5.37555 12.4797 3.81763 11.331 2.66897C10.1824 1.52031 8.62445 0.875 7 0.875ZM7 0C8.85652 0 10.637 0.737497 11.9497 2.05025C13.2625 3.36301 14 5.14348 14 7C14 8.85652 13.2625 10.637 11.9497 11.9497C10.637 13.2625 8.85652 14 7 14C5.14348 14 3.36301 13.2625 2.05025 11.9497C0.737498 10.637 0 8.85652 0 7C0 5.14348 0.737498 3.36301 2.05025 2.05025C3.36301 0.737497 5.14348 0 7 0Z" fill="white"/>
                                <path d="M4.06506 9.9347C4.1057 9.97544 4.15397 10.0078 4.20713 10.0298C4.26028 10.0519 4.31726 10.0632 4.37481 10.0632C4.43235 10.0632 4.48933 10.0519 4.54248 10.0298C4.59564 10.0078 4.64392 9.97544 4.68456 9.9347L6.99981 7.61858L9.31505 9.9347C9.35573 9.97538 9.40402 10.0076 9.45717 10.0297C9.51032 10.0517 9.56728 10.063 9.6248 10.063C9.68233 10.063 9.73929 10.0517 9.79244 10.0297C9.84559 10.0076 9.89388 9.97538 9.93456 9.9347C9.97523 9.89402 10.0075 9.84573 10.0295 9.79259C10.0515 9.73944 10.0629 9.68248 10.0629 9.62495C10.0629 9.56742 10.0515 9.51046 10.0295 9.45731C10.0075 9.40417 9.97523 9.35588 9.93456 9.3152L7.61843 6.99995L9.93456 4.6847C9.97523 4.64402 10.0075 4.59573 10.0295 4.54259C10.0515 4.48944 10.0629 4.43248 10.0629 4.37495C10.0629 4.31743 10.0515 4.26046 10.0295 4.20732C10.0075 4.15417 9.97523 4.10588 9.93456 4.0652C9.89388 4.02452 9.84559 3.99226 9.79244 3.97024C9.73929 3.94823 9.68233 3.9369 9.6248 3.9369C9.56728 3.9369 9.51032 3.94823 9.45717 3.97024C9.40402 3.99226 9.35573 4.02452 9.31505 4.0652L6.99981 6.38133L4.68456 4.0652C4.64388 4.02452 4.59559 3.99226 4.54244 3.97024C4.48929 3.94823 4.43233 3.9369 4.37481 3.9369C4.31728 3.9369 4.26032 3.94823 4.20717 3.97024C4.15402 3.99226 4.10573 4.02452 4.06506 4.0652C4.02438 4.10588 3.99211 4.15417 3.9701 4.20732C3.94808 4.26046 3.93675 4.31743 3.93675 4.37495C3.93675 4.43248 3.94808 4.48944 3.9701 4.54259C3.99211 4.59573 4.02438 4.64402 4.06506 4.6847L6.38118 6.99995L4.06506 9.3152C4.02431 9.35584 3.99199 9.40412 3.96993 9.45727C3.94788 9.51042 3.93652 9.5674 3.93652 9.62495C3.93652 9.6825 3.94788 9.73948 3.96993 9.79263C3.99199 9.84578 4.02431 9.89406 4.06506 9.9347Z" fill="white"/>
                                </g>
                                <defs>
                                <clipPath id="clip0">
                                <rect width="14" height="14" fill="white" transform="matrix(1 0 0 -1 0 14)"/>
                                </clipPath>
                                </defs>
                            </svg>
                        </div>
                    </template>
                
                    <div class="tags-div">
                        
                    </div>
                </section> -->
                <section id="searchTagSection" class="row">
                    <template class="search-tags-template">
                        <div class="search-tag">
                            <label class="search-tag-title"></label>
                            
                             <svg class="search-tag-clear-tag" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.7914 0L6 4.79143L1.20857 0L0 1.20857L4.79143 6L0 10.7914L1.20857 12L6 7.20857L10.7914 12L12 10.7914L7.20857 6L12 1.20857L10.7914 0Z" fill="#888F98"/>
                            </svg>
                        </div>
                    </template>
                
                    <div class="tags-div ">
                        <!-- <div class="clear-tags-div">
                            <i class="fas fa-trash"></i> <label>limpar Seleção</label>
                        </div>
                        <div class="search-tag">
                            <label class="search-tag-title">titulo da tag</label>
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                             <path d="M10.7914 0L6 4.79143L1.20857 0L0 1.20857L4.79143 6L0 10.7914L1.20857 12L6 7.20857L10.7914 12L12 10.7914L7.20857 6L12 1.20857L10.7914 0Z" fill="#888F98"/>
                            </svg>

                        </div>
                        <div class="search-tag">
                            <label class="search-tag-title">titulo da tag</label>
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.7914 0L6 4.79143L1.20857 0L0 1.20857L4.79143 6L0 10.7914L1.20857 12L6 7.20857L10.7914 12L12 10.7914L7.20857 6L12 1.20857L10.7914 0Z" fill="#888F98"/>
                            </svg>

                        </div> -->
                    </div>
                </section>

                <section id="filterSection">
                    <h1 class="filterSectionTitle">Filtrar por :</h1>

                    <div class="closest-location filter-item">
                        <label class="filter-name">Mais Próximos</label>
                        <svg class="filter-arrow-svg arrow-up" width="8" height="11" viewBox="0 0 8 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.35355 0.646446C4.15829 0.451184 3.84171 0.451184 3.64645 0.646446L0.464466 3.82843C0.269204 4.02369 0.269204 4.34027 0.464466 4.53553C0.659728 4.7308 0.976311 4.7308 1.17157 4.53553L4 1.70711L6.82843 4.53553C7.02369 4.7308 7.34027 4.7308 7.53553 4.53553C7.7308 4.34027 7.7308 4.02369 7.53553 3.82843L4.35355 0.646446ZM4.5 11L4.5 1H3.5L3.5 11H4.5Z" fill="#0C0C23"/>
                        </svg>
                    </div>

                    <div class="filter-section-vertical-line"></div>

                    <div class="better-avaliation filter-item">
                        <label class="filter-name">Avaliação </label>
                        <svg class="filter-arrow-svg arrow-up" width="8" height="11" viewBox="0 0 8 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.35355 0.646446C4.15829 0.451184 3.84171 0.451184 3.64645 0.646446L0.464466 3.82843C0.269204 4.02369 0.269204 4.34027 0.464466 4.53553C0.659728 4.7308 0.976311 4.7308 1.17157 4.53553L4 1.70711L6.82843 4.53553C7.02369 4.7308 7.34027 4.7308 7.53553 4.53553C7.7308 4.34027 7.7308 4.02369 7.53553 3.82843L4.35355 0.646446ZM4.5 11L4.5 1H3.5L3.5 11H4.5Z" fill="#0C0C23"/>
                        </svg>
                    </div>

                    <button id="btn-change-location" class="btn-change-location" data-bs-toggle="modal" data-bs-target="#addressModal">
                        <svg width="8" height="10" viewBox="0 0 8 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3.36461 9.79824C0.526758 5.6842 0 5.26197 0 3.75C0 1.67893 1.67893 0 3.75 0C5.82107 0 7.5 1.67893 7.5 3.75C7.5 5.26197 6.97324 5.6842 4.13539 9.79824C3.94916 10.0673 3.55082 10.0672 3.36461 9.79824ZM3.75 5.3125C4.61295 5.3125 5.3125 4.61295 5.3125 3.75C5.3125 2.88705 4.61295 2.1875 3.75 2.1875C2.88705 2.1875 2.1875 2.88705 2.1875 3.75C2.1875 4.61295 2.88705 5.3125 3.75 5.3125Z" fill="white"/>
                        </svg>

                        <span class="change-location-btn-title"> <span class="sm-change-location-text"> Localização </span> <span class="normal-change-location-text"> <?=isset($_SESSION['idUsuario']) ? 'Modificar' : 'Adicionar' ?> Localização</span></span>
                    </button>

                    <div class="text-secondary mt-3 text-end w-100" style="font-size: 12px" id="showTempLocation"><!--<span>Usando localização temporária: </span> <strong>Rua Ernesta Pelosini, 195, Bairro Nova Petrópolis - São Bernardo do Campo, SP</strong>--></div>

                </section>

                <template id="serviceCardTemplate">
                    <a href="#" class="service-card-link">
                        <div class="service-card-container ">
                            <div class="service-card ">
                                <div class="service-card--profile-img-div">
                                    <!--<img src="../../../assets/images/profile_images/no_picture.jpg" alt="Perfil" class="service-card--profile-img">-->
                                </div>

                                <div class="service-card-info row">
                                    <div class="col-12 col-sm-6">
                                        <div class="row">
                                            <div class="col-8 col-sm-12">
                                                <p class="service-card-provider-name">Marcos</p>
                                                <p class="service-card--service-name">Pedreiro</p>
                                            </div>
                                            <div class="col-4 col-sm-12">
                                                <div class="service-card--service-name--service-rate">
                                                    <div class="service-card--rate-div row">
                                                        <p class="avaliation-text d-block d-sm-none col-12">Avaliação</p>
                                                        <div class="col-12">
                                                            <div class="avaliation">
                                                                <div class="service-card--rate-stars">
                                                                    <svg width="13" height="13" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M4.28267 4.14927L4.02262 4.18718L0.836642 4.65166L0.836278 4.65172C0.675589 4.67502 0.609816 4.87488 0.727337 4.98931L0.727479 4.98945L3.03246 7.23555L3.22083 7.41911L3.17629 7.67832L2.63118 10.8509C2.60355 11.0123 2.77424 11.1348 2.91597 11.0597L2.91754 11.0588L5.76769 9.56072L6.00033 9.43844L6.23296 9.56072L9.08311 11.0588L9.08319 11.0589C9.22838 11.1352 9.39656 11.0093 9.36948 10.8509C9.36948 10.8509 9.36948 10.8509 9.36948 10.8509L8.82436 7.67832L8.77983 7.41911L8.96819 7.23555L11.2732 4.98945L11.2733 4.98931C11.3908 4.87488 11.3251 4.67502 11.1644 4.65172L11.164 4.65166L7.97803 4.18718L7.71799 4.14927L7.60174 3.91357L6.17821 1.02727C6.17816 1.02717 6.17811 1.02707 6.17806 1.02697C6.10395 0.878057 5.89426 0.882167 5.8229 1.02635L4.28267 4.14927ZM4.28267 4.14927L4.39891 3.91357L5.8228 1.02654L4.28267 4.14927Z" fill="#F5FF6C" stroke="black"/>
                                                                    </svg>
                                                                    <svg width="13" height="13" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M4.28267 4.14927L4.02262 4.18718L0.836642 4.65166L0.836278 4.65172C0.675589 4.67502 0.609816 4.87488 0.727337 4.98931L0.727479 4.98945L3.03246 7.23555L3.22083 7.41911L3.17629 7.67832L2.63118 10.8509C2.60355 11.0123 2.77424 11.1348 2.91597 11.0597L2.91754 11.0588L5.76769 9.56072L6.00033 9.43844L6.23296 9.56072L9.08311 11.0588L9.08319 11.0589C9.22838 11.1352 9.39656 11.0093 9.36948 10.8509C9.36948 10.8509 9.36948 10.8509 9.36948 10.8509L8.82436 7.67832L8.77983 7.41911L8.96819 7.23555L11.2732 4.98945L11.2733 4.98931C11.3908 4.87488 11.3251 4.67502 11.1644 4.65172L11.164 4.65166L7.97803 4.18718L7.71799 4.14927L7.60174 3.91357L6.17821 1.02727C6.17816 1.02717 6.17811 1.02707 6.17806 1.02697C6.10395 0.878057 5.89426 0.882167 5.8229 1.02635L4.28267 4.14927ZM4.28267 4.14927L4.39891 3.91357L5.8228 1.02654L4.28267 4.14927Z" fill="#F5FF6C" stroke="black"/>
                                                                    </svg>
                                                                    <svg width="13" height="13" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M4.28267 4.14927L4.02262 4.18718L0.836642 4.65166L0.836278 4.65172C0.675589 4.67502 0.609816 4.87488 0.727337 4.98931L0.727479 4.98945L3.03246 7.23555L3.22083 7.41911L3.17629 7.67832L2.63118 10.8509C2.60355 11.0123 2.77424 11.1348 2.91597 11.0597L2.91754 11.0588L5.76769 9.56072L6.00033 9.43844L6.23296 9.56072L9.08311 11.0588L9.08319 11.0589C9.22838 11.1352 9.39656 11.0093 9.36948 10.8509C9.36948 10.8509 9.36948 10.8509 9.36948 10.8509L8.82436 7.67832L8.77983 7.41911L8.96819 7.23555L11.2732 4.98945L11.2733 4.98931C11.3908 4.87488 11.3251 4.67502 11.1644 4.65172L11.164 4.65166L7.97803 4.18718L7.71799 4.14927L7.60174 3.91357L6.17821 1.02727C6.17816 1.02717 6.17811 1.02707 6.17806 1.02697C6.10395 0.878057 5.89426 0.882167 5.8229 1.02635L4.28267 4.14927ZM4.28267 4.14927L4.39891 3.91357L5.8228 1.02654L4.28267 4.14927Z" fill="#F5FF6C" stroke="black"/>
                                                                    </svg>
                                                                    <svg width="13" height="13" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M4.28267 4.14927L4.02262 4.18718L0.836642 4.65166L0.836278 4.65172C0.675589 4.67502 0.609816 4.87488 0.727337 4.98931L0.727479 4.98945L3.03246 7.23555L3.22083 7.41911L3.17629 7.67832L2.63118 10.8509C2.60355 11.0123 2.77424 11.1348 2.91597 11.0597L2.91754 11.0588L5.76769 9.56072L6.00033 9.43844L6.23296 9.56072L9.08311 11.0588L9.08319 11.0589C9.22838 11.1352 9.39656 11.0093 9.36948 10.8509C9.36948 10.8509 9.36948 10.8509 9.36948 10.8509L8.82436 7.67832L8.77983 7.41911L8.96819 7.23555L11.2732 4.98945L11.2733 4.98931C11.3908 4.87488 11.3251 4.67502 11.1644 4.65172L11.164 4.65166L7.97803 4.18718L7.71799 4.14927L7.60174 3.91357L6.17821 1.02727C6.17816 1.02717 6.17811 1.02707 6.17806 1.02697C6.10395 0.878057 5.89426 0.882167 5.8229 1.02635L4.28267 4.14927ZM4.28267 4.14927L4.39891 3.91357L5.8228 1.02654L4.28267 4.14927Z" fill="#F5FF6C" stroke="black"/>
                                                                    </svg>
                                                                    <svg width="13" height="13" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M4.28267 4.14927L4.02262 4.18718L0.836642 4.65166L0.836278 4.65172C0.675589 4.67502 0.609816 4.87488 0.727337 4.98931L0.727479 4.98945L3.03246 7.23555L3.22083 7.41911L3.17629 7.67832L2.63118 10.8509C2.60355 11.0123 2.77424 11.1348 2.91597 11.0597L2.91754 11.0588L5.76769 9.56072L6.00033 9.43844L6.23296 9.56072L9.08311 11.0588L9.08319 11.0589C9.22838 11.1352 9.39656 11.0093 9.36948 10.8509C9.36948 10.8509 9.36948 10.8509 9.36948 10.8509L8.82436 7.67832L8.77983 7.41911L8.96819 7.23555L11.2732 4.98945L11.2733 4.98931C11.3908 4.87488 11.3251 4.67502 11.1644 4.65172L11.164 4.65166L7.97803 4.18718L7.71799 4.14927L7.60174 3.91357L6.17821 1.02727C6.17816 1.02717 6.17811 1.02707 6.17806 1.02697C6.10395 0.878057 5.89426 0.882167 5.8229 1.02635L4.28267 4.14927ZM4.28267 4.14927L4.39891 3.91357L5.8228 1.02654L4.28267 4.14927Z" fill="#F5FF6C" stroke="black"/>
                                                                    </svg>

                                                                    <!-- <svg width="13" height="13" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M4.96763 0.857178L6.14033 4.29487H10L6.8651 6.41948L8.0378 9.85718L4.96763 7.73257L1.89747 9.85718L3.07017 6.41948L0 4.29487H3.79493L4.96763 0.857178Z" fill="#FF9839"/>
                                                                    </svg>
                                                                    <svg width="13" height="13" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M4.96763 0.857178L6.14033 4.29487H10L6.8651 6.41948L8.0378 9.85718L4.96763 7.73257L1.89747 9.85718L3.07017 6.41948L0 4.29487H3.79493L4.96763 0.857178Z" fill="#FF9839"/>
                                                                    </svg>
                                                                    <svg width="13" height="13" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M4.96763 0.857178L6.14033 4.29487H10L6.8651 6.41948L8.0378 9.85718L4.96763 7.73257L1.89747 9.85718L3.07017 6.41948L0 4.29487H3.79493L4.96763 0.857178Z" fill="#FF9839"/>
                                                                    </svg>
                                                                    <svg width="13" height="13" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M4.96763 0.857178L6.14033 4.29487H10L6.8651 6.41948L8.0378 9.85718L4.96763 7.73257L1.89747 9.85718L3.07017 6.41948L0 4.29487H3.79493L4.96763 0.857178Z" fill="#FF9839"/>
                                                                    </svg>
                                                                    <svg width="13" height="13" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M4.96763 0.857178L6.14033 4.29487H10L6.8651 6.41948L8.0378 9.85718L4.96763 7.73257L1.89747 9.85718L3.07017 6.41948L0 4.29487H3.79493L4.96763 0.857178Z" fill="#FF9839"/>
                                                                    </svg> -->
                                                                    
                                                                </div>

                                                                <p class="service-card--avaliation-quantity">(47)</p>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="col-12 col-sm-6">
                                        <div class="service-card-location-div row">
                                            <div class="col-12 service-card-location">
                                                <svg width="15" height="15" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4.55038 11.525C1.23955 6.72531 0.625 6.23272 0.625 4.46875C0.625 2.0525 2.58375 0.09375 5 0.09375C7.41625 0.09375 9.375 2.0525 9.375 4.46875C9.375 6.23272 8.76045 6.72531 5.44962 11.525C5.23235 11.8389 4.76762 11.8389 4.55038 11.525ZM5 6.29167C6.00677 6.29167 6.82292 5.47552 6.82292 4.46875C6.82292 3.46198 6.00677 2.64583 5 2.64583C3.99323 2.64583 3.17708 3.46198 3.17708 4.46875C3.17708 5.47552 3.99323 6.29167 5 6.29167Z" fill="#888F98"/>
                                                </svg>


                                                <label class="service-location">Moab, UT</label>
                                            </div>
                                        
                                            <div class="col">
                                                <p class="service-card--price ">$ Orçamento</p>
                                            </div>
                                        
                                        </div>

                                    </div>
                                    
                                    
                                    
                                </div>

                                
                            </div>
                        </div>
                    </a>
                    
                </template>

                <section id="serviceCadsSection" class="my-nice-scroll-bar">
                    <div class="service-cards-path">

                        <div class="beforeSearch">
                            <h3>Para fazer uma pesquisa</h3>

                            <ul>
                                <li>Faça o uso da <strong>barra de pesquisa</strong> ou <strong>tabela de categorias</strong></li>
                                <li><strong>Filtre por:</strong> <span>Mais próximos <i class="fas fa-long-arrow-alt-up"></i></span> <span>Melhor avaliado <i class="fas fa-long-arrow-alt-up"></i></span> para que tenha a <strong>melhor escolha custo benefício</strong></li>
                            </ul>
                        </div>

                    </div>
                    <div class="service-cards-loading-container">
                        
                    </div>
                </section>
            </section>
        </div>
    </section>

    <!-- modal de trocar de endereço -->
    <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?=isset($_SESSION['idUsuario']) ? 'Trocar' : 'Adicionar'?> endereço de pesquisa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- inputs com informações do endereço -->
                <form action="#" method="post" id="changeLocationForm">
                    <div class="modal-body">
                        <button type="button" class="btn btn-info text-light w-100 mb-3" data-bs-toggle="popover" data-bs-trigger="focus" title="Como assim?" data-bs-content="Use essa função caso você precise pesquisar um serviço, mas está em um local diferente do que você cadastrou perfil. Ao configurar essa nova localização, ela será usada como referência para pesquisar os serviços mais próximos de você na localização atual, ignorando a localização que você cadastrou. Essa é uma localização temporária e não alterará as suas informações de cadastro. Caso você tenha permitido, nós pegamos sua localização atual para autocompletar os campos abaixo.">Como assim?</button>

                        <label for="userAdressCEP" class="myLabel">CEP</label> <br>
                        <input type="text" class="form-control requiredAdressData" name="userAdressCEP" id="userAdressCEP" placeholder="ex.: 01234567" maxlength="8">
                        <small id="cepError" class="text-danger"></small>

                        <div class="row mt-3">
                            <div class="col-3">
                                <label for="userAdressState" class="myLabel">Estado</label> <br>
                                <input type="text" class="form-control requiredAdressData mb-3" name="userAdressState" id="userAdressState" readonly data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="autocompletado com o CEP" data-bs-placement="top">
                            </div>
                            <div class="col-9">
                                <label for="userAdressCity" class="myLabel">Cidade</label> <br>
                                <input type="text" class="form-control requiredAdressData mb-3" name="userAdressCity" id="userAdressCity" placeholder="autocompletado com o CEP" readonly>
                            </div>
                        </div>

                        <label for="userAdressNeighborhood" class="myLabel">Bairro</label> <br>
                        <input type="text" class="form-control requiredAdressData mb-3" name="userAdressNeighborhood" id="userAdressNeighborhood" placeholder="Digite seu bairro">

                        <div class="row">
                            <div class="col-9">
                                <label for="userAdressStreet" class="myLabel">Rua</label> <br>
                                <input type="text" class="form-control requiredAdressData mb-3" name="userAdressStreet" id="userAdressStreet" placeholder="Digite sua rua">
                            </div>
                            <div class="col-3">
                                <label for="userAdressNumber" class="myLabel">Número</label> <br>
                                <input type="number" class="form-control requiredAdressData mb-3" name="userAdressNumber" id="userAdressNumber" maxlength="5">
                            </div>
                        </div>

                        <label for="userAdressComplement" class="myLabel">Complemento</label> <br>
                        <input type="text" class="form-control mb-3" name="userAdressComplement" id="userAdressComplement" placeholder="Digite o complemento (caso tenha)" data-bs-toggle="popover" data-bs-trigger="hover" title="Exemplo" data-bs-content="apto. 24 BL A" data-bs-placement="top" maxlength="20">
                        <div class="text-danger mt-3" id="adressInfoError" style="font-size: 13px"></div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="mybtn mybtn-conversion" id="saveTempAdressBtn">Salvar endereço temporário</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- modal de trocar de endereço fim -->

    <footer id="myMainFooter">
        <div id="myMainFooterContainer" class="container-fluid">
            <div class="my-main-footer-logo">
                <img src="../../../assets/images/dumb-footer.png" alt="Tá por Aqui" class="my-footer-img">
            </div>
            <div class="my-main-footer-institutional">
                <p>INSTITUCIONAL</p>
                <a href="../../ComoFunciona/sobreNos%20old.php">Quem Somos</a> <br>
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

                <div class="col mobile-navbar-item active">
                    <a href="./listagem.php">
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

    <script type="module">
        import {setSearchState, setTempPosition, userNotLogged, tempPosition} from './listagem.js';

        const handleSeachText = (query) => {
            if(!query) return;

            let text = query;
            text = text.trim();

            let spliText = text.split(" ")
            if(text == "") spliText = [];   

            let serviceCardsPath = document.querySelector(".service-cards-path");
            serviceCardsPath.innerHTML = "";

            setSearchState({write : spliText});
        }

        <?php
            $tempLat = "";
            $tempLng = "";
            if (isset($_GET['tmpLat'])){
                if ($_GET['tmpLat'] !== ""){
                    $tempLat = $_GET['tmpLat'];
                } else {
                    $tempLat = 'false';
                }
            } else {
                $tempLat = 'false';
            }

        if (isset($_GET['tmpLng'])){
            if ($_GET['tmpLng'] !== ""){
                $tempLng = $_GET['tmpLng'];
            } else {
                $tempLng = 'false';
            }
        } else {
            $tempLng = 'false';
        }

        if ($tempLat !== 'false' && $tempLng !== 'false'){
            echo "setTempPosition({tempLat: $tempLat, tempLng: $tempLng})";
        }
        ?>

        handleSeachText("<?php echo $searchQuery; ?>");

        <?php
            $is_set_location = 'false';
            if ($logged === 'true' || ($tempLat !== 'false' && $tempLng !== 'false')){
                $is_set_location = 'true';
            }
        ?>
        userNotLogged('<?=$is_set_location?>')
    </script>
</body>
</html>
