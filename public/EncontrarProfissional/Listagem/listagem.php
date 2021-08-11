<?php
session_start();

//caso haja cookies salvos no pc do usuário, ele vai logar com os cookies salvos
require "../../../logic/entrar_cookie.php";
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
    <link rel="stylesheet" href="./listagem.css">

    <script src="../../../assets/bootstrap/jquery-3.5.1.slim.min.js" defer></script>
    <script src="../../../assets/bootstrap/popper.min.js" defer></script>
    <script src="../../../assets/bootstrap/bootstrap-4.5.3-dist/js/bootstrap.min.js" defer></script>

    <script src="../../../assets/global/globalScripts.js" defer></script>
    <script src="./listagem.js" defer></script>
</head>
<body>
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
                    <a href="listagem.php" class="nav-link">Encontre um pofissional</a>
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
                <?php if( empty($_SESSION) ){ ?>
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

    <section id="contentSection">
        <div class="fixd-side-bar">
        
        </div>

        <section id="mySearchBarSection">
            <template id="myCategoriesBtnTemplate">

            </template>


            <div class="my-categories-toggler-btn-path">
                <button class="my-categories-toggle-btn">
                    <div></div>
                    <div></div>
                    <div></div>
                </button>
            </div>
            

            <button type="button" class="serarch-icon-btn">
                <div class="serarch-icon-div">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21.7261 19.2913L17.832 15.3971C17.6562 15.2214 17.4179 15.1237 17.168 15.1237H16.5313C17.6093 13.7449 18.2499 12.0107 18.2499 10.1242C18.2499 5.63636 14.6135 2 10.1257 2C5.63783 2 2.00146 5.63636 2.00146 10.1242C2.00146 14.612 5.63783 18.2484 10.1257 18.2484C12.0122 18.2484 13.7464 17.6079 15.1252 16.5298V17.1665C15.1252 17.4165 15.2228 17.6547 15.3986 17.8305L19.2927 21.7246C19.6599 22.0918 20.2536 22.0918 20.6168 21.7246L21.7222 20.6193C22.0893 20.2521 22.0893 19.6584 21.7261 19.2913ZM10.1257 15.1237C7.36422 15.1237 5.12616 12.8896 5.12616 10.1242C5.12616 7.36276 7.36032 5.12469 10.1257 5.12469C12.8871 5.12469 15.1252 7.35885 15.1252 10.1242C15.1252 12.8857 12.891 15.1237 10.1257 15.1237Z" fill="#CCCCCC"/>
                    </svg>
                </div>
            </button>
            

            <div class="search-input-area-div">
                <input type="text">
            </div>
        </section>

        <div class="hidden-side-bar"></div>
        
        <div class="categories-container">
            <div class="categories-backdrop"></div>
            <template id="myCategorieItemTemplate">
                <div class="categorie-item">
                    <p class="categorieName">Programação e Tecnologia</p>
                    <svg class="categorieArrow" width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 10.59L4.58 6L0 1.41L1.41 0L7.41 6L1.41 12L0 10.59Z" fill="black"/>
                    </svg>
                </div>
            </template>

            <template id="mySUBCategorieItemTemplate">
                <div class="subcategorie-container">   
                    <div class="subCategorie-header">
                        <h1 class="subCategorie-section-title">Culinária</h1>
                    </div> 
                    <div class="subCategorieBody">
                        <div class="subCategorie-item">
                            <label class="subCategorie-title left-col">Marmitas 01</label>
                        </div>
                        <div class="subCategorie-item">
                            <label class="subCategorie-title right-col">Marmitas 02</label>
                        </div>
                        <div class="subCategorie-item">
                            <label class="subCategorie-title left-col">Marmitas 03</label>
                        </div>
                    </div>

                </div>
            </template>

            <section class="categoriesSection my-nice-scroll-bar hide-sidebar">
                <div class="title-area">
                    <h1>Categorias</h1>
                </div>
                <div class="categoriesSectionBody my-nice-scroll-bar">
                    <!-- <div class="a">
                        <div class="categorie-item">
                            <p class="categorieName">Programação e Tecnologia</p>
                            <svg class="categorieArrow" width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 10.59L4.58 6L0 1.41L1.41 0L7.41 6L1.41 12L0 10.59Z" fill="black"/>
                            </svg>
                        </div>

                        <div id="subCategorieItem-2" class="subcategorie-container">   
                            <div class="subCategorie-header">
                                <h1 class="subCategorie-section-title">Culinária</h1>
                            </div> 
                            <div class="subCategorieBody">
                                <div class="subCategorie-item">
                                    <label class="subCategorie-title left-col">Marmitas 01</label>
                                </div>
                                <div class="subCategorie-item">
                                    <label class="subCategorie-title right-col">Marmitas 02</label>
                                </div>
                                <div class="subCategorie-item">
                                    <label class="subCategorie-title left-col">Marmitas 03</label>
                                </div>
                            </div>

                        </div>
                    </div> -->
                   <!-- <div class="a">
                        <div class="categorie-item">
                            <p class="categorieName">Programação e Tecnologia</p>
                            <svg class="categorieArrow" width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 10.59L4.58 6L0 1.41L1.41 0L7.41 6L1.41 12L0 10.59Z" fill="black"/>
                            </svg>
                        </div>

                        <div id="subCategorieItem-2" class="subcategorie-container">   
                            <div class="subCategorie-header">
                                <h1 class="subCategorie-section-title">Culinária</h1>
                            </div> 
                            <div class="subCategorieBody">
                                <div class="subCategorie-item">
                                    <label class="subCategorie-title left-col">Marmitas 01</label>
                                </div>
                                <div class="subCategorie-item">
                                    <label class="subCategorie-title right-col">Marmitas 02</label>
                                </div>
                                <div class="subCategorie-item">
                                    <label class="subCategorie-title left-col">Marmitas 03</label>
                                </div>
                            </div>

                        </div>
                    </div>-->
                   
                
                   <!-- <div class="categorie-item">
                        <p class="categorieName">Programação e Tecnologia</p>
                        <svg class="categorieArrow" width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 10.59L4.58 6L0 1.41L1.41 0L7.41 6L1.41 12L0 10.59Z" fill="black"/>
                        </svg>
                    </div>
                    <div id="categorieItem-2" class="categorie-item">
                        <p class="categorieName">Programação e Tecnologia</p>
                        <svg class="categorieArrow" width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 10.59L4.58 6L0 1.41L1.41 0L7.41 6L1.41 12L0 10.59Z" fill="black"/>
                        </svg>
                        
                    <div>

                    <div id="subCategorieItem-2" class="subcategorie-container">   
                        <div class="subCategorie-header">
                            <h1 class="subCategorie-section-title">Culinária</h1>
                        </div> 
                        <div class="subCategorieBody">
                            <div class="subCategorie-item">
                                <label class="subCategorie-title left-col">Marmitas 01</label>
                            </div>
                            <div class="subCategorie-item">
                                <label class="subCategorie-title right-col">Marmitas 02</label>
                            </div>
                            <div class="subCategorie-item">
                                <label class="subCategorie-title left-col">Marmitas 03</label>
                            </div>
                        </div>

                    </div>

                    <div class="categorie-item">
                        <p class="categorieName">Programação e Tecnologia</p>
                        <svg class="categorieArrow" width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 10.59L4.58 6L0 1.41L1.41 0L7.41 6L1.41 12L0 10.59Z" fill="black"/>
                        </svg>
                    </div>
                    <div class="categorie-item">
                        <p class="categorieName">Programação e Tecnologia</p>
                        <svg class="categorieArrow" width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 10.59L4.58 6L0 1.41L1.41 0L7.41 6L1.41 12L0 10.59Z" fill="black"/>
                        </svg>
                    </div>
                    <div class="categorie-item">
                        <p class="categorieName">Programação e Tecnologia</p>
                        <svg class="categorieArrow" width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 10.59L4.58 6L0 1.41L1.41 0L7.41 6L1.41 12L0 10.59Z" fill="black"/>
                        </svg>
                    </div>
                    <div class="categorie-item">
                        <p class="categorieName">Programação e Tecnologia tt</p>
                        <svg class="categorieArrow" width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 10.59L4.58 6L0 1.41L1.41 0L7.41 6L1.41 12L0 10.59Z" fill="black"/>
                        </svg>
                    </div>
                    <div class="categorie-item">
                        <p class="categorieName">Programação e Tecnologia</p>
                        <svg class="categorieArrow" width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 10.59L4.58 6L0 1.41L1.41 0L7.41 6L1.41 12L0 10.59Z" fill="black"/>
                        </svg>
                    </div>
                    <div class="categorie-item">
                        <p class="categorieName">Programação e Tecnologia</p>
                        <svg class="categorieArrow" width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 10.59L4.58 6L0 1.41L1.41 0L7.41 6L1.41 12L0 10.59Z" fill="black"/>
                        </svg>
                    </div>
                    <div class="categorie-item">
                        <p class="categorieName">Programação e Tecnologia</p>
                        <svg class="categorieArrow" width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 10.59L4.58 6L0 1.41L1.41 0L7.41 6L1.41 12L0 10.59Z" fill="black"/>
                        </svg>
                    </div>
                    <div class="categorie-item">
                        <p class="categorieName">Programação e Tecnologia uu</p>
                        <svg class="categorieArrow" width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 10.59L4.58 6L0 1.41L1.41 0L7.41 6L1.41 12L0 10.59Z" fill="black"/>
                        </svg>
                    </div>
                    <div class="categorie-item">
                        <p class="categorieName">Programação e Tecnologia</p>
                        <svg class="categorieArrow" width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 10.59L4.58 6L0 1.41L1.41 0L7.41 6L1.41 12L0 10.59Z" fill="black"/>
                        </svg>
                    </div>
                    <div class="categorie-item">
                        <p class="categorieName">Programação e Tecnologia aa</p>
                        <svg class="categorieArrow" width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 10.59L4.58 6L0 1.41L1.41 0L7.41 6L1.41 12L0 10.59Z" fill="black"/>
                        </svg>
                    </div>
                    <div class="categorie-item">
                        <p class="categorieName">Programação e Tecnologia ultimo</p>
                        <svg class="categorieArrow" width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 10.59L4.58 6L0 1.41L1.41 0L7.41 6L1.41 12L0 10.59Z" fill="black"/>
                        </svg>
                    </div> -->
                </div>
            </section>
        </div>
        

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

            <button class="btn-change-location">
                <svg width="8" height="10" viewBox="0 0 8 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.36461 9.79824C0.526758 5.6842 0 5.26197 0 3.75C0 1.67893 1.67893 0 3.75 0C5.82107 0 7.5 1.67893 7.5 3.75C7.5 5.26197 6.97324 5.6842 4.13539 9.79824C3.94916 10.0673 3.55082 10.0672 3.36461 9.79824ZM3.75 5.3125C4.61295 5.3125 5.3125 4.61295 5.3125 3.75C5.3125 2.88705 4.61295 2.1875 3.75 2.1875C2.88705 2.1875 2.1875 2.88705 2.1875 3.75C2.1875 4.61295 2.88705 5.3125 3.75 5.3125Z" fill="white"/>
                </svg>

                <p class="change-location-btn-title"> <span class="sm-change-location-text"> Localização </span> <span class="normal-change-location-text"> Modificar Localização</span></p>
            </button>
        </section>

        <section id="serviceCadsSection" class="my-nice-scroll-bar">
            <div class="service-cards-path">

                <div class="service-card-container">
                    <div class="service-card">
                        <img src="../../../assets/images/profile_images/no_picture.jpg" alt="Perfil" class="service-card--profile-img">
                        <p class="service-card-provider-name">Marcos</p>
                        <div class="service-card-location-div">
                            <svg width="9" height="12" viewBox="0 0 9 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.03753 11.7579C0.632109 6.82104 0 6.31437 0 4.5C0 2.01471 2.01471 0 4.5 0C6.98529 0 9 2.01471 9 4.5C9 6.31437 8.36789 6.82104 4.96247 11.7579C4.73899 12.0807 4.26098 12.0807 4.03753 11.7579ZM4.5 6.375C5.53554 6.375 6.375 5.53554 6.375 4.5C6.375 3.46446 5.53554 2.625 4.5 2.625C3.46446 2.625 2.625 3.46446 2.625 4.5C2.625 5.53554 3.46446 6.375 4.5 6.375Z" fill="#0C0C23"/>
                            </svg>

                            <p class="service-location">Moab, UT</p>
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
                        

                        <div class="service-card--price">$ Orçamento</div>
                    </div>
                </div>
                <div class="service-card-container">
                    <div class="service-card">
                        <img src="../../../assets/images/profile_images/no_picture.jpg" alt="Perfil" class="service-card--profile-img">
                        <p class="service-card-provider-name">Marcos</p>
                        <div class="service-card-location-div">
                            <svg width="9" height="12" viewBox="0 0 9 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.03753 11.7579C0.632109 6.82104 0 6.31437 0 4.5C0 2.01471 2.01471 0 4.5 0C6.98529 0 9 2.01471 9 4.5C9 6.31437 8.36789 6.82104 4.96247 11.7579C4.73899 12.0807 4.26098 12.0807 4.03753 11.7579ZM4.5 6.375C5.53554 6.375 6.375 5.53554 6.375 4.5C6.375 3.46446 5.53554 2.625 4.5 2.625C3.46446 2.625 2.625 3.46446 2.625 4.5C2.625 5.53554 3.46446 6.375 4.5 6.375Z" fill="#0C0C23"/>
                            </svg>

                            <p class="service-location">Moab, UT</p>
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
                        

                        <div class="service-card--price">$ Orçamento</div>
                    </div>
                </div>
                <div class="service-card-container">
                    <div class="service-card">
                        <img src="../../../assets/images/profile_images/no_picture.jpg" alt="Perfil" class="service-card--profile-img">
                        <p class="service-card-provider-name">Marcos</p>
                        <div class="service-card-location-div">
                            <svg width="9" height="12" viewBox="0 0 9 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.03753 11.7579C0.632109 6.82104 0 6.31437 0 4.5C0 2.01471 2.01471 0 4.5 0C6.98529 0 9 2.01471 9 4.5C9 6.31437 8.36789 6.82104 4.96247 11.7579C4.73899 12.0807 4.26098 12.0807 4.03753 11.7579ZM4.5 6.375C5.53554 6.375 6.375 5.53554 6.375 4.5C6.375 3.46446 5.53554 2.625 4.5 2.625C3.46446 2.625 2.625 3.46446 2.625 4.5C2.625 5.53554 3.46446 6.375 4.5 6.375Z" fill="#0C0C23"/>
                            </svg>

                            <p class="service-location">Moab, UT</p>
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
                        

                        <div class="service-card--price">$ Orçamento</div>
                    </div>
                </div>
                <div class="service-card-container">
                    <div class="service-card">
                        <img src="../../../assets/images/profile_images/no_picture.jpg" alt="Perfil" class="service-card--profile-img">
                        <p class="service-card-provider-name">Marcos</p>
                        <div class="service-card-location-div">
                            <svg width="9" height="12" viewBox="0 0 9 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.03753 11.7579C0.632109 6.82104 0 6.31437 0 4.5C0 2.01471 2.01471 0 4.5 0C6.98529 0 9 2.01471 9 4.5C9 6.31437 8.36789 6.82104 4.96247 11.7579C4.73899 12.0807 4.26098 12.0807 4.03753 11.7579ZM4.5 6.375C5.53554 6.375 6.375 5.53554 6.375 4.5C6.375 3.46446 5.53554 2.625 4.5 2.625C3.46446 2.625 2.625 3.46446 2.625 4.5C2.625 5.53554 3.46446 6.375 4.5 6.375Z" fill="#0C0C23"/>
                            </svg>

                            <p class="service-location">Moab, UT</p>
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
                        

                        <div class="service-card--price">$ Orçamento</div>
                    </div>
                </div>
                <div class="service-card-container">
                    <div class="service-card">
                        <img src="../../../assets/images/profile_images/no_picture.jpg" alt="Perfil" class="service-card--profile-img">
                        <p class="service-card-provider-name">Marcos</p>
                        <div class="service-card-location-div">
                            <svg width="9" height="12" viewBox="0 0 9 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.03753 11.7579C0.632109 6.82104 0 6.31437 0 4.5C0 2.01471 2.01471 0 4.5 0C6.98529 0 9 2.01471 9 4.5C9 6.31437 8.36789 6.82104 4.96247 11.7579C4.73899 12.0807 4.26098 12.0807 4.03753 11.7579ZM4.5 6.375C5.53554 6.375 6.375 5.53554 6.375 4.5C6.375 3.46446 5.53554 2.625 4.5 2.625C3.46446 2.625 2.625 3.46446 2.625 4.5C2.625 5.53554 3.46446 6.375 4.5 6.375Z" fill="#0C0C23"/>
                            </svg>

                            <p class="service-location">Moab, UT</p>
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
                        

                        <div class="service-card--price">$ Orçamento</div>
                    </div>
                </div>
                <div class="service-card-container">
                    <div class="service-card">
                        <img src="../../../assets/images/profile_images/no_picture.jpg" alt="Perfil" class="service-card--profile-img">
                        <p class="service-card-provider-name">Marcos</p>
                        <div class="service-card-location-div">
                            <svg width="9" height="12" viewBox="0 0 9 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.03753 11.7579C0.632109 6.82104 0 6.31437 0 4.5C0 2.01471 2.01471 0 4.5 0C6.98529 0 9 2.01471 9 4.5C9 6.31437 8.36789 6.82104 4.96247 11.7579C4.73899 12.0807 4.26098 12.0807 4.03753 11.7579ZM4.5 6.375C5.53554 6.375 6.375 5.53554 6.375 4.5C6.375 3.46446 5.53554 2.625 4.5 2.625C3.46446 2.625 2.625 3.46446 2.625 4.5C2.625 5.53554 3.46446 6.375 4.5 6.375Z" fill="#0C0C23"/>
                            </svg>

                            <p class="service-location">Moab, UT</p>
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
                        

                        <div class="service-card--price">$ Orçamento</div>
                    </div>
                </div>
                <div class="service-card-container">
                    <div class="service-card">
                        <img src="../../../assets/images/profile_images/no_picture.jpg" alt="Perfil" class="service-card--profile-img">
                        <p class="service-card-provider-name">Marcos</p>
                        <div class="service-card-location-div">
                            <svg width="9" height="12" viewBox="0 0 9 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.03753 11.7579C0.632109 6.82104 0 6.31437 0 4.5C0 2.01471 2.01471 0 4.5 0C6.98529 0 9 2.01471 9 4.5C9 6.31437 8.36789 6.82104 4.96247 11.7579C4.73899 12.0807 4.26098 12.0807 4.03753 11.7579ZM4.5 6.375C5.53554 6.375 6.375 5.53554 6.375 4.5C6.375 3.46446 5.53554 2.625 4.5 2.625C3.46446 2.625 2.625 3.46446 2.625 4.5C2.625 5.53554 3.46446 6.375 4.5 6.375Z" fill="#0C0C23"/>
                            </svg>

                            <p class="service-location">Moab, UT</p>
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
                        

                        <div class="service-card--price">$ Orçamento</div>
                    </div>
                </div>
                <div class="service-card-container">
                    <div class="service-card">
                        <img src="../../../assets/images/profile_images/no_picture.jpg" alt="Perfil" class="service-card--profile-img">
                        <p class="service-card-provider-name">Marcos</p>
                        <div class="service-card-location-div">
                            <svg width="9" height="12" viewBox="0 0 9 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.03753 11.7579C0.632109 6.82104 0 6.31437 0 4.5C0 2.01471 2.01471 0 4.5 0C6.98529 0 9 2.01471 9 4.5C9 6.31437 8.36789 6.82104 4.96247 11.7579C4.73899 12.0807 4.26098 12.0807 4.03753 11.7579ZM4.5 6.375C5.53554 6.375 6.375 5.53554 6.375 4.5C6.375 3.46446 5.53554 2.625 4.5 2.625C3.46446 2.625 2.625 3.46446 2.625 4.5C2.625 5.53554 3.46446 6.375 4.5 6.375Z" fill="#0C0C23"/>
                            </svg>

                            <p class="service-location">Moab, UT</p>
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
                        

                        <div class="service-card--price">$ Orçamento</div>
                    </div>
                </div>
                <div class="service-card-container">
                    <div class="service-card">
                        <img src="../../../assets/images/profile_images/no_picture.jpg" alt="Perfil" class="service-card--profile-img">
                        <p class="service-card-provider-name">Marcos o ultimo</p>
                        <div class="service-card-location-div">
                            <svg width="9" height="12" viewBox="0 0 9 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.03753 11.7579C0.632109 6.82104 0 6.31437 0 4.5C0 2.01471 2.01471 0 4.5 0C6.98529 0 9 2.01471 9 4.5C9 6.31437 8.36789 6.82104 4.96247 11.7579C4.73899 12.0807 4.26098 12.0807 4.03753 11.7579ZM4.5 6.375C5.53554 6.375 6.375 5.53554 6.375 4.5C6.375 3.46446 5.53554 2.625 4.5 2.625C3.46446 2.625 2.625 3.46446 2.625 4.5C2.625 5.53554 3.46446 6.375 4.5 6.375Z" fill="#0C0C23"/>
                            </svg>

                            <p class="service-location">Moab, UT</p>
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
                        

                        <div class="service-card--price">$ Orçamento</div>
                    </div>
                </div>

            </div>
        </section>
    </section>

    

    
    

    <!--<section>
        <form action="../VisualizarServico/visuaizarServico.php" method="GET">
            <input hidden type="hidden" name="serviceID" value="1">
            <button type="submit">Servico 01</button>
        </form>
        <form action="../VisualizarServico/visuaizarServico.php" method="GET">
            <input hidden type="hidden" name="serviceID" value="2">
            <button type="submit">Servico 02</button>
        </form>
    </section> -->

    



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

    <section>
        <form action="../VisualizarServico/visuaizarServico.php" method="GET">
            <input hidden type="hidden" name="serviceID" value="1">
            <button type="submit">Servico 01</button>
        </form>
        <form action="../VisualizarServico/visuaizarServico.php" method="GET">
            <input hidden type="hidden" name="serviceID" value="2">
            <button type="submit">Servico 02</button>
        </form>
    </section>
</body>
</html>