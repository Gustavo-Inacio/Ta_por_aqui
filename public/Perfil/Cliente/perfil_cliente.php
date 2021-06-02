<?php
session_start();

//caso haja cookies salvos no pc do usuário, ele vai logar com os cookies salvos
require "../../../logic/entrar_cookie.php";
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://kit.fontawesome.com/2a19bde8ca.js" crossorigin="anonymous" defer></script>

    <title>Tá por aqui - Meu perfil</title>

    <link rel="stylesheet" href="../../../assets/bootstrap/bootstrap-4.5.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../assets/global/globalStyles.css">
    <link rel="stylesheet" href="../perfil.css">

    <script src="../../../assets/bootstrap/jquery-3.5.1.slim.min.js" defer></script>
    <script src="../../../assets/bootstrap/popper.min.js" defer></script>
    <script src="../../../assets/bootstrap/bootstrap-4.5.3-dist/js/bootstrap.min.js" defer></script>

    <script src="../../../assets/global/globalScripts.js" defer></script>

    <script src="perfil_prestador.js" defer></script>
</head>

<body>
    <!--NavBar Comeco-->
    <div id="myMainTopNavbarNavBackdrop" class=""></div>
    <nav id="myMainTopNavbar" class="navbar navbar-expand-md">
        <a href="../../Home/home.php" class="navbar-brand">
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
                    <a href="../../EncontrarProfissional/Listagem/listagem.php" class="nav-link">Encontre um pofissional</a>
                </li>
                <li class="nav-item">
                    <a href="../../Artigos/artigos.html" class="nav-link">Artigos</a>      
                </li>
                <li class="nav-item">
                    <a href="../../Contato/contato.html" class="nav-link">Fale conosco</a>
                </li>
                <li class="nav-item">
                    <a href="../../SobreNos/sobreNos.php" class="nav-link">Sobre</a>
                </li>
                <li class="nav-item">
                    <a href="../../Chat/chat.html" class="nav-link">Chat</a>
                </li>
                <? if( empty($_SESSION) ){ ?>
                    <li class="nav-item">
                        <a href="../../Entrar/login.php" class="nav-link">Entrar/cadastrar</a>
                    </li>
                <?}?>
            </ul>

            <? if( isset($_SESSION['idUsuario']) && isset($_SESSION['email']) && isset($_SESSION['senha']) && isset($_SESSION['classificacao']) ) {?>
                <div class="dropdown">
                    <img src="../../../assets/images/profile_images/<?=$_SESSION['imagemPerfil']?>" alt="imagem de perfil" id="profileMenu" class="img-fluid" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    <div class="dropdown-menu" aria-labelledby="profileMenu">
                        <? if($_SESSION['classificacao'] == 0) {?>
                            <a class="dropdown-item" href="../../Perfil/Cliente/meu_perfil.php">Perfil</a>
                        <? }else if($_SESSION['classificacao'] == 1 || $_SESSION['classificacao'] == 2) {?>
                            <a class="dropdown-item" href="../../Perfil/Prestador/meu_perfil.php">Perfil</a>
                        <?}?>
                        <a class="dropdown-item text-danger" href="../../../logic/entrar_logoff.php">Sair</a>
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
            <img src="../../../assets/images/profile_images/teste.jpeg" alt="Imagem de perfil" class="img-fluid"
                id="profileImage">
            <br>
            <h3>Avaliação</h3>
            <p> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i
                    class="fas fa-star"></i> <i class="fas fa-star"></i> </p>
        </div>

        <div id="editProfileInformation" class="col-md-8">
            <h1 class="formTitle d-inline">Perfil</h1>
            <form>
                <div id="myForms" class="row">

                    <div class="col-md-6">
                        <label for="userName">Nome</label> <br>
                        <input type="text" class="form-control" name="userName" id="userName" class="mb-4" readonly
                            value="Natan">

                        <br>

                        <label for="userLastName">Sobrenome</label> <br>
                        <input type="text" class="form-control" name="userLastName" id="userLastName" class="mb-4"
                            readonly value="Barbosa">

                        <br>

                        <label for="userCell">Celular</label> <br>
                        <input type="text" class="form-control" name="userCell" id="userCell" class="mb-4" readonly
                            value="(11)999999999">

                    </div>

                    <div class="col-md-6 mt-3 mt-md-0">
                        <label for="userEmail">Email</label> <br>
                        <input type="text" class="form-control" name="userEmail" id="userEmail" class="mb-4" readonly
                            value="exemplo@gmail.com">

                        <br>

                        <label for="userSite">Site</label> <br>
                        <input type="text" class="form-control" name="userSite" id="userSite" class="mb-4" readonly
                            value="https://www.site.com.br">

                        <br>

                        <label for="userDescription">Descrição</label> <br>
                        <textarea name="userDescription" class="form-control" id="userDescription" class="mb-4"
                            readonly> Esse é um exemplo de descrição </textarea>
                    </div>

                </div>
            </form>

        </div>
    </section>
    <!-- Cartão do perfil fim -->

    <br>

    <!-- Div de redes sociais -->

    <section id="socialMedia">
        <div class="container">

            <div class="myContent">
                <h1>Redes sociais</h1>

                <br>

                <div class="socialBorder"></div>

                <br>

                <form>
                    <div class="row">
                        <div class="col-md-4 mt-3">
                            <i class="fab fa-instagram"></i> <br>
                            <input type="text" name="instagram" id="instagram" class="form-control border text-center text-white" value="@seu nome" readonly> 
                        </div>

                        <div class="col-md-4 mt-3">
                            <i class="fab fa-facebook-f"></i> <br>
                            <input type="text" name="facebook" id="facebook" class="form-control border text-center text-white" value="seu nome" readonly> 
                        </div>

                        <div class="col-md-4 mt-3">
                            <i class="fab fa-twitter"></i> <br>
                            <input type="text" name="twitter" id="twitter" class="form-control border text-center text-white" value="@seu nome" readonly> 
                        </div>
                    </div>
                    <button class="btn btn-success mt-3 d-none" id="btnSalvarRedes">Salvar</button>
                    <button type="button" class="btn btn-outline-danger mt-3 d-none" id="btnCancelarRedes" onclick="location.reload()">Cancelar</button>
                </form>

            </div>

        </div>
    </section>
    <!-- Div de redes sociais fim-->

    <!-- footer -->
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
    <!-- /footer -->
</body>

</html>