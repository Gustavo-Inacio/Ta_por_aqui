<?php
session_start();

$_SESSION['listServices'] = true;
$searchQuery = "";
if(isset($_GET['query'])){
    $searchQuery = $_GET['query'];
}

//caso haja cookies salvos no pc do usuário, ele vai logar com os cookies salvos
require "../../../logic/entrar_cookie.php";
// require "../../../logic/DbConnection.php";
//     $connectClass = new DbConnection();
//    $con = $connectClass->connect();
//     $con->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8mb4_general_ci'");
    
//     $query = "SELECT * from categorias";
//     $stmt = $con->query($query);
//     $a = $stmt->fetchAll(PDO::FETCH_ASSOC);

//     print_r($a);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tá por aqui - Encontre um profissional</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="../../../assets/global/globalStyles.css">
    <link rel="stylesheet" href="listagem.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
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
                        <a href="../../ComoFunciona/comoFunciona.php" class="nav-link">Como funciona</a>
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
            <div id="cat-container" class=" col-md-4 ">
                <div class="row">
                    <section class="cool-categories-section my-nice-scroll-bar">
                        <header class="row">
                            <svg class="my-categories-toggle-btn" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.6902 8.41707L11.3658 1.74147C11.6878 1.41951 12.2098 1.41951 12.5317 1.74147L13.3103 2.52007C13.6317 2.84148 13.6323 3.36239 13.3117 3.68456L8.02111 9.00002L13.3117 14.3154C13.6323 14.6376 13.6317 15.1585 13.3103 15.4799L12.5317 16.2585C12.2097 16.5805 11.6878 16.5805 11.3658 16.2585L4.6902 9.58296C4.36827 9.26101 4.36827 8.73903 4.6902 8.41707Z" fill="white"/>
                            </svg>

                            <h1 class="h1">Categorias</h1>
                        </header>
                        <div class="content row my-nice-scroll-bar">
                            
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
                            <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.375 13H9.125C9.22446 13 9.31984 12.9605 9.39017 12.8902C9.46049 12.8198 9.5 12.7245 9.5 12.625V5.875C9.5 5.77554 9.46049 5.68016 9.39017 5.60984C9.31984 5.53951 9.22446 5.5 9.125 5.5H8.375C8.27554 5.5 8.18016 5.53951 8.10983 5.60984C8.03951 5.68016 8 5.77554 8 5.875V12.625C8 12.7245 8.03951 12.8198 8.10983 12.8902C8.18016 12.9605 8.27554 13 8.375 13ZM13.5 2.5H10.9247L9.86219 0.728125C9.72885 0.505942 9.54022 0.322091 9.3147 0.194487C9.08917 0.066882 8.83444 -0.000123231 8.57531 1.70139e-07H5.42469C5.16567 -1.5274e-05 4.91106 0.0670412 4.68566 0.194641C4.46025 0.32224 4.27172 0.506033 4.13844 0.728125L3.07531 2.5H0.5C0.367392 2.5 0.240215 2.55268 0.146447 2.64645C0.0526784 2.74022 0 2.86739 0 3L0 3.5C0 3.63261 0.0526784 3.75979 0.146447 3.85355C0.240215 3.94732 0.367392 4 0.5 4H1V14.5C1 14.8978 1.15804 15.2794 1.43934 15.5607C1.72064 15.842 2.10218 16 2.5 16H11.5C11.8978 16 12.2794 15.842 12.5607 15.5607C12.842 15.2794 13 14.8978 13 14.5V4H13.5C13.6326 4 13.7598 3.94732 13.8536 3.85355C13.9473 3.75979 14 3.63261 14 3.5V3C14 2.86739 13.9473 2.74022 13.8536 2.64645C13.7598 2.55268 13.6326 2.5 13.5 2.5ZM5.37 1.59094C5.38671 1.56312 5.41035 1.54012 5.43862 1.52418C5.46688 1.50824 5.4988 1.49991 5.53125 1.5H8.46875C8.50115 1.49996 8.533 1.50832 8.5612 1.52426C8.58941 1.54019 8.613 1.56317 8.62969 1.59094L9.17531 2.5H4.82469L5.37 1.59094ZM11.5 14.5H2.5V4H11.5V14.5ZM4.875 13H5.625C5.72446 13 5.81984 12.9605 5.89016 12.8902C5.96049 12.8198 6 12.7245 6 12.625V5.875C6 5.77554 5.96049 5.68016 5.89016 5.60984C5.81984 5.53951 5.72446 5.5 5.625 5.5H4.875C4.77554 5.5 4.68016 5.53951 4.60984 5.60984C4.53951 5.68016 4.5 5.77554 4.5 5.875V12.625C4.5 12.7245 4.53951 12.8198 4.60984 12.8902C4.68016 12.9605 4.77554 13 4.875 13Z" fill="#888F98"/>
                            </svg>

                            <label>Limapr Seleção</label>
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

                        <span class="change-location-btn-title"> <span class="sm-change-location-text"> Localização </span> <span class="normal-change-location-text"> Modificar Localização</span></span>
                    </button>
                    <div class="text-secondary mt-3 text-end w-100" style="font-size: 12px" id="showTempLocation"><span>Usando localização temporária: </span> <strong>Rua Ernesta Pelosini, 195, Bairro Nova Petrópolis - São Bernardo do Campo, SP</strong></div>
                </section>

                <template id="serviceCardTemplate">
                    <a href="#" class="service-card-link">
                        <div class="service-card-container ">
                            <div class="service-card ">
                                <div class="service-card--profile-img-div">
                                    <!--<img src="../../../assets/images/profile_images/no_picture.jpg" alt="Perfil" class="service-card--profile-img">-->
                                </div>

                                <div class="service-card-info">
                                    <p class="service-card-provider-name">Marcos</p>
                                    <div class="service-card-location-div">
                                        <div class="row">
                                            <svg width="9" height="12" viewBox="0 0 9 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M4.03753 11.7579C0.632109 6.82104 0 6.31437 0 4.5C0 2.01471 2.01471 0 4.5 0C6.98529 0 9 2.01471 9 4.5C9 6.31437 8.36789 6.82104 4.96247 11.7579C4.73899 12.0807 4.26098 12.0807 4.03753 11.7579ZM4.5 6.375C5.53554 6.375 6.375 5.53554 6.375 4.5C6.375 3.46446 5.53554 2.625 4.5 2.625C3.46446 2.625 2.625 3.46446 2.625 4.5C2.625 5.53554 3.46446 6.375 4.5 6.375Z" fill="#0C0C23"/>
                                            </svg>

                                            <label class="service-location">Moab, UT</label>
                                        </div>
                                    
                                        <label class="service-card--price">$ Orçamento</label>
                                    </div>

                                    <div class="service-card--service-name--service-rate">
                                        <p class="service-card--service-name">Pedreiro</p>

                                        <div class="service-card--rate-div">
                                            <div class="service-card--rate-stars">
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
                                                </svg>
                                                <svg width="13" height="13" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4.96763 0.857178L6.14033 4.29487H10L6.8651 6.41948L8.0378 9.85718L4.96763 7.73257L1.89747 9.85718L3.07017 6.41948L0 4.29487H3.79493L4.96763 0.857178Z" fill="#FF9839"/>
                                                </svg>
                                                
                                            </div>

                                            <p class="service-card--avaliation-quantity">(47)</p>
                                        </div>
                                    </div>
                                </div>

                                
                            </div>
                        </div>
                    </a>
                    
                </template>

                <section id="serviceCadsSection" class="my-nice-scroll-bar">
                    <div class="service-cards-path">

                    

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
                    <h5 class="modal-title" id="exampleModalLabel">Trocar endereço de pesquisa</h5>
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
                        <button type="submit" class="mybtn mybtn-conversion">Salvar endereço temporário</button>
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

    <script type="module">
        import {setSearchState} from './listagem.js';

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

        handleSeachText("<?php echo $searchQuery; ?>");

    // let btnSearch = document.querySelector("#searchButton");

        // const handleBtnSearch = (event) => {
        //     event.preventDefault();
        //     let text = document.querySelector("#searchBar").value;
        //     text = text.trim();

        //     let spliText = text.split(" ")
        //     if(text == "") spliText = [];   

        //     let serviceCardsPath = document.querySelector(".service-cards-path");
        //     serviceCardsPath.innerHTML = "";

        //     setSearchState({write : spliText});
            
        // };

        <?php if(!$searchQuery == ""){?>
            // let btnSearch = document.querySelector("#searchButton");
            // btnSearch.onclick = handleBtnSearch;
        <?php }?>

    </script>

    <!-- <div id="cat-container" class="container-fluid ">
        <div class="row">
            <section class="cool-categories-section col-3">
                <header class="row">
                    <h1 class="h1">Categorias</h1>
                </header>
                <div class="content row">
                    
                    <div class="col-12 cat-view">
                        <!-- <div class="row cat-item selected">
                            <div class="col">
                                <p class="cat-text">Programação e Tecnologia</p>

                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.482 11.831L1.54814 5.89714C1.26195 5.61096 1.26195 5.14698 1.54814 4.86082L2.24023 4.16873C2.52592 3.88304 2.98896 3.88249 3.27532 4.16751L8.00018 8.87023L12.725 4.16751C13.0114 3.88249 13.4744 3.88304 13.7601 4.16873L14.4522 4.86082C14.7384 5.14701 14.7384 5.61099 14.4522 5.89714L8.51835 11.831C8.23217 12.1172 7.76819 12.1172 7.482 11.831Z" fill="#3333CC"/>
                                </svg>
                            </div>
                        </div>
                        <div class="row cat-item">
                            <div class="col">
                                <p class='cat-text'>Beleza</p>

                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.482 11.831L1.54814 5.89714C1.26195 5.61096 1.26195 5.14698 1.54814 4.86082L2.24023 4.16873C2.52592 3.88304 2.98896 3.88249 3.27532 4.16751L8.00018 8.87023L12.725 4.16751C13.0114 3.88249 13.4744 3.88304 13.7601 4.16873L14.4522 4.86082C14.7384 5.14701 14.7384 5.61099 14.4522 5.89714L8.51835 11.831C8.23217 12.1172 7.76819 12.1172 7.482 11.831Z" fill="#3333CC"/>
                                </svg>
                            </div>
                        </div>
                        <div class="row cat-item">
                            <div class="col">
                                <p class="cat-text">Programação e Tecnologia</p>

                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.482 11.831L1.54814 5.89714C1.26195 5.61096 1.26195 5.14698 1.54814 4.86082L2.24023 4.16873C2.52592 3.88304 2.98896 3.88249 3.27532 4.16751L8.00018 8.87023L12.725 4.16751C13.0114 3.88249 13.4744 3.88304 13.7601 4.16873L14.4522 4.86082C14.7384 5.14701 14.7384 5.61099 14.4522 5.89714L8.51835 11.831C8.23217 12.1172 7.76819 12.1172 7.482 11.831Z" fill="#3333CC"/>
                                </svg>
                            </div>
                        </div>
                        <div class="row cat-item">
                            <div class="col">
                                <p class='cat-text'>Beleza</p>

                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.482 11.831L1.54814 5.89714C1.26195 5.61096 1.26195 5.14698 1.54814 4.86082L2.24023 4.16873C2.52592 3.88304 2.98896 3.88249 3.27532 4.16751L8.00018 8.87023L12.725 4.16751C13.0114 3.88249 13.4744 3.88304 13.7601 4.16873L14.4522 4.86082C14.7384 5.14701 14.7384 5.61099 14.4522 5.89714L8.51835 11.831C8.23217 12.1172 7.76819 12.1172 7.482 11.831Z" fill="#3333CC"/>
                                </svg>
                            </div>
                        </div>
                        <div class="row cat-item">
                            <div class="col">
                                <p class="cat-text">Programação e Tecnologia</p>

                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.482 11.831L1.54814 5.89714C1.26195 5.61096 1.26195 5.14698 1.54814 4.86082L2.24023 4.16873C2.52592 3.88304 2.98896 3.88249 3.27532 4.16751L8.00018 8.87023L12.725 4.16751C13.0114 3.88249 13.4744 3.88304 13.7601 4.16873L14.4522 4.86082C14.7384 5.14701 14.7384 5.61099 14.4522 5.89714L8.51835 11.831C8.23217 12.1172 7.76819 12.1172 7.482 11.831Z" fill="#3333CC"/>
                                </svg>
                            </div>
                        </div>
                        <div class="row cat-item">
                            <div class="col">
                                <p class='cat-text'>Beleza</p>

                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.482 11.831L1.54814 5.89714C1.26195 5.61096 1.26195 5.14698 1.54814 4.86082L2.24023 4.16873C2.52592 3.88304 2.98896 3.88249 3.27532 4.16751L8.00018 8.87023L12.725 4.16751C13.0114 3.88249 13.4744 3.88304 13.7601 4.16873L14.4522 4.86082C14.7384 5.14701 14.7384 5.61099 14.4522 5.89714L8.51835 11.831C8.23217 12.1172 7.76819 12.1172 7.482 11.831Z" fill="#3333CC"/>
                                </svg>
                            </div>
                        </div> -->
                    </div>
                    <!-- <div class="col-12 subcat-view">
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
    </div> -->
     
</body>
</html>