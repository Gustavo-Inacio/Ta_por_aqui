<?php
session_start();

require "../../logic/DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

$user_info = [];
if(isset($_SESSION['idUsuario'])) {
    $query = "SELECT nome_usuario, sobrenome_usuario, email_usuario, fone_usuario from usuarios where id_usuario = " . $_SESSION['idUsuario'];
    $stmt = $con->query($query);
    $user_info = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    $user_info['nome_usuario'] = null;
    $user_info['sobrenome_usuario'] = null;
    $user_info['email_usuario'] = null;
    $user_info['fone_usuario'] = null;
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

    <link rel="stylesheet" href="../../assets/bootstrap/bootstrap-4.5.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/global/globalStyles.css">
    <link rel="stylesheet" href="contato.css">

    <script src="../../assets/bootstrap/jquery-3.5.1.slim.min.js" defer></script>
    <script src="../../assets/bootstrap/popper.min.js" defer></script>
    <script src="../../assets/bootstrap/bootstrap-4.5.3-dist/js/bootstrap.min.js" defer></script>
    <script src="../../assets/jQueyMask/jquery.mask.js" defer></script>

    <script src="../../assets/global/globalScripts.js" defer></script>
    <script src="contato.js" defer></script>
</head>
<body>
    <!--NavBar Comeco-->
    <div id="myMainTopNavbarNavBackdrop" class=""></div>
    <nav id="myMainTopNavbar" class="navbar navbar-expand-md">
        <a href="#" id="myMainTopNavbarBrand" class="navbar-brand">
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
                    <a href="../Contato/contato.php" class="nav-link">Fale conosco</a>
                </li>
                <li class="nav-item">
                    <a href="../SobreNos/sobreNos.php" class="nav-link">Sobre</a>
                </li>
                <li class="nav-item">
                    <a href="../Chat/chat.html" class="nav-link">Chat</a>
                </li>
                <?php if( empty($_SESSION['idUsuario']) ){ ?>
                    <li class="nav-item">
                        <a href="../Entrar/login.php" class="nav-link">Entrar/cadastrar</a>
                    </li>
                <?php }?>
            </ul>

            <?php if( isset($_SESSION['idUsuario']) && isset($_SESSION['email']) && isset($_SESSION['senha']) && isset($_SESSION['classificacao']) ) {?>
                <div class="dropdown">
                    <img src="../../assets/images/users/<?=$_SESSION['imagemPerfil']?>" alt="imagem de perfil" id="profileMenu" class="img-fluid" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    <div class="dropdown-menu" aria-labelledby="profileMenu">
                        <a class="dropdown-item" href="../Perfil/meu_perfil.php">Perfil</a>
                        <a class="dropdown-item text-danger" href="../../logic/entrar_logoff.php">Sair</a>
                    </div>
                </div>
            <?php } ?>

        </div>
        
    </nav>
    <!--NavBar Fim-->

    <!--Contato Inicio-->
    <h1 id="title">Contato</h1>

    <div class="container">
        <div id="contact" class="row justify-content-center">

            <?php if(isset($_GET['status']) && $_GET['status'] === "0") {?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Não foi possível enviar sua mensagem pois algum campo não foi preenchido. Tente novamente preenchendo todos os campos obrigatórios
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php }?>

            <?php if(isset($_GET['status']) && $_GET['status'] === "1") {?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Obrigado por enviar sua mensagem para nós. Analisaremos o problema/sugestão e, caso solicitado, entraremos em contato com você assim que possível
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php }?>

            <div id="ourInfo" class="col-md-4">
                <a>Nossos Contatos</a>
                <a>Encontre-nos nas redes sociais</a>
                <div class="contactInfo">
                    <i class="fas fa-phone-alt"></i>
                    <p>+55 (11) 0000-0000</p>
                </div>
                <div class="contactInfo">
                    <i class="fab fa-instagram"></i>
                    <p>Instagram</p>
                </div>
                <div class="contactInfo">
                    <i class="far fa-envelope"></i>
                    <p>taporaqui@gmail.com</p>
                </div>
            </div>
            <div id="contactArea" class="col-md-8">
                <form method="POST" action="../../logic/contato_enviar.php" id="contactForms">
                    <div class="row">
                        <div class="form-group col-md-6" id="nome">
                            <label for="contactName">Nome</label>
                            <input type="text" name="contactName" id="contactName" class="form-control required" placeholder="Nome Sobrenome" required value="<?=$user_info['nome_usuario']?><?=$user_info['nome_usuario'] === null ? "" : " "?><?=$user_info['sobrenome_usuario']?>">
                        </div>
                        <div class="form-group col-md-6" id="address">
                            <label for="contactEmail">Endereço de Email</label>
                            <input type="email" name="contactEmail" id="contactEmail" class="form-control required" placeholder="seu@email.com" required value="<?=$user_info['email_usuario']?>">
                        </div>
                        <div class="form-group col-md-6" id="reason">
                            <label for="contactReason">Motivos de contato</label> <br>
                            <select class="form-control" name="contactReason" id="contactReason" required>
                                <option value="">Selecione uma motivo</option>
                                <option value="1">Elogios</option>
                                <option value="2">Sugestões</option>
                                <option value="3">Reclamações</option>
                                <option value="4">Problemas/bugs</option>
                                <option value="6">Contestação de banimento</option>
                                <option value="5">Outros</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6" id="phone">
                            <label for="contactPhone">Telefone / Cel.</label>
                            <input type="tel" name="contactPhone" id="contactPhone" class="form-control required" placeholder="(00) 0000-0000" required value="<?=$user_info['fone_usuario']?>">
                        </div>
                        <div class="form-group col-md-12" id="message">
                            <label for="contactMessage">Mensagem</label>
                            <textarea class="form-control" name="contactMessage" id="contactMessage" rows="4" required placeholder="Escreva aqui uma mensagem reportando algum problema que você experienciou em nossa plataforma, ou com alguma sugestão que queira nos dar"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="mybtn mybtn-conversion">Enviar Mensagem</button>
                </form>
            </div>
        </div>
    </div>

    <!--Contato Fim-->



    <footer id="myMainFooter">
        <div id="myMainFooterContainer" class="container-fluid">
            <div class="my-main-footer-logo">
                <img src="../../assets/images/dumb-footer.png" alt="Tá por Aqui" class="my-footer-img">
            </div>
            <div class="my-main-footer-institutional">
                <p>INSTITUCIONAL</p>
                <a href="../SobreNos/sobreNos.html">Quem Somos</a> <br>
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
</body>
</html>