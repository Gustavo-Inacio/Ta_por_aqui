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
    $query = "SELECT * FROM usuarios where id_usuario = " . $_GET['id'];
    $stmt = $con->query($query);
    $user = $stmt->fetch(PDO::FETCH_OBJ);
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

        <script src="../../assets/bootstrap/jquery-3.5.1.slim.min.js" defer></script>
        <script src="../../assets/bootstrap/popper.min.js" defer></script>
        <script src="../../assets/bootstrap/bootstrap-4.5.3-dist/js/bootstrap.min.js" defer></script>

        <script src="../../assets/global/globalScripts.js" defer></script>
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
                    <? if( empty($_SESSION) ){ ?>
                        <li class="nav-item">
                            <a href="../Entrar/login.php" class="nav-link">Entrar/cadastrar</a>
                        </li>
                    <?}?>
                </ul>

                <? if( isset($_SESSION['idUsuario']) && isset($_SESSION['email']) && isset($_SESSION['senha']) && isset($_SESSION['classificacao']) ) {?>
                    <div class="dropdown">
                        <img src="../../assets/images/profile_images/<?=$_SESSION['imagemPerfil']?>" alt="imagem de perfil" id="profileMenu" class="img-fluid" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        <div class="dropdown-menu" aria-labelledby="profileMenu">
                            <a class="dropdown-item" href="meu_perfil.php">Perfil</a>
                            <a class="dropdown-item text-danger" href="../../logic/entrar_logoff.php">Sair</a>
                        </div>
                    </div>
                <? } ?>

            </div>
        </nav>
        <!--NavBar Fim-->

        <!-- Cartão usuário inexistente-->
        <section id="myProfileSection" class="row">
            <div id="profilePictureArea" class="col-md-4">
                <h1>Usuário inexistente</h1>
                <br>
                <img src="../../assets/images/profile_images/no_picture.jpg" alt="Imagem de perfil" class="rounded-image"
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

<? } else { ?>

<!-- HTML normal -->
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://kit.fontawesome.com/2a19bde8ca.js" crossorigin="anonymous" defer></script>

    <title>Tá por aqui - <?=$user->nome?> <?=$user->sobrenome?> </title>

    <link rel="stylesheet" href="../../assets/bootstrap/bootstrap-4.5.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/global/globalStyles.css">
    <link rel="stylesheet" href="perfil.css">

    <script src="../../assets/bootstrap/jquery-3.5.1.slim.min.js" defer></script>
    <script src="../../assets/bootstrap/popper.min.js" defer></script>
    <script src="../../assets/bootstrap/bootstrap-4.5.3-dist/js/bootstrap.min.js" defer></script>

    <script src="../../assets/global/globalScripts.js" defer></script>
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
                <? if( empty($_SESSION) ){ ?>
                    <li class="nav-item">
                        <a href="../Entrar/login.php" class="nav-link">Entrar/cadastrar</a>
                    </li>
                <?}?>
            </ul>

            <? if( isset($_SESSION['idUsuario']) && isset($_SESSION['email']) && isset($_SESSION['senha']) && isset($_SESSION['classificacao']) ) {?>
                <div class="dropdown">
                    <img src="../../assets/images/profile_images/<?=$_SESSION['imagemPerfil']?>" alt="imagem de perfil" id="profileMenu" class="img-fluid" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    <div class="dropdown-menu" aria-labelledby="profileMenu">
                        <a class="dropdown-item" href="meu_perfil.php">Perfil</a>
                        <a class="dropdown-item text-danger" href="../../logic/entrar_logoff.php">Sair</a>
                    </div>
                </div>
            <? } ?>

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
            <h3>Avaliação</h3>
            <p> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i
                    class="fas fa-star"></i> <i class="fas fa-star"></i> </p>
        </div>

        <div id="editProfileInformation" class="col-md-8">
            <h1 class="formTitle d-inline">Perfil</h1>
                <div id="myForms" class="row">
                    <div class="col-md-6">
                        <label for="userName">Nome</label> <br>
                        <input type="text" class="form-control" name="userName" id="userName" class="mb-4" readonly
                            value="<?=$user->nome?>">

                        <br>

                        <label for="userLastName">Sobrenome</label> <br>
                        <input type="text" class="form-control" name="userLastName" id="userLastName" class="mb-4"
                            readonly value="<?=$user->sobrenome?>">

                        <br>

                        <label for="userCell">Celular</label> <br>
                        <input type="text" class="form-control" name="userCell" id="userCell" class="mb-4" readonly
                            value="<?=$user->telefone?>">

                    </div>

                    <div class="col-md-6 mt-3 mt-md-0">
                        <label for="userEmail">Email</label> <br>
                        <input type="text" class="form-control" name="userEmail" id="userEmail" class="mb-4" readonly
                            value="<?=$user->email?>">

                        <br>

                        <?if( $user->site != "" ) {?>
                            <label for="showUserSite">Site</label> <br>
                            <div id="showUserSite"> <a href="<?=$user->site?>" target="_blank"> <?=$user->site?> </a> </div>

                            <br>
                        <?}?>

                        <label for="userDescription">Descrição</label> <br>
                        <textarea name="userDescription" class="form-control" id="userDescription" class="mb-4" placeholder="O usuário não colocou nenhuma descrição"
                            readonly><?=$user->descricao?></textarea>
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
                    <div class="row">
                        <div class="col-md-4 mt-3">
                            <i class="fab fa-instagram"></i> <br>
                            <input type="text" name="instagram" id="instagram" class="form-control border text-center text-white" value="@Natan" readonly> 
                        </div>

                        <div class="col-md-4 mt-3">
                            <i class="fab fa-facebook-f"></i> <br>
                            <input type="text" name="facebook" id="facebook" class="form-control border text-center text-white" value="Natan Barbosa" readonly> 
                        </div>

                        <div class="col-md-4 mt-3">
                            <i class="fab fa-twitter"></i> <br>
                            <input type="text" name="twitter" id="twitter" class="form-control border text-center text-white" value="@Natan" readonly> 
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </section>
    <!-- Div de redes sociais fim-->

<? if($user->classificacao == 1 || $user->classificacao == 2) { ?>
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
                                <a href="#" class="btn myCardButton">Contratar</a>
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
                                <a href="#" class="btn myCardButton">Contratar</a>
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
                                <a href="#" class="btn myCardButton"> Contratar </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fim serviços disponibilizados -->
<? } ?>

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
<? } ?>