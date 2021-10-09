<?php
session_start();

//caso haja cookies salvos no pc do usuário, ele vai logar com os cookies salvos
require "../../logic/entrar_cookie.php";

if(!isset($_SESSION['idUsuario'])){
    header('Location: boasVindas.php');
    exit();
}
if (isset($_COOKIE['chatTutorial']) && $_COOKIE['chatTutorial'] === 'show'){
    header('Location: boasVindas.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tá por aqui - Chat</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/global/globalStyles.css">
    <link rel="stylesheet" href="../Denuncia/denuncia.css">
    <link rel="stylesheet" href="chat.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="../../assets/emojiPicker/fgEmojiPicker.js"></script>
    <script src="https://kit.fontawesome.com/2a19bde8ca.js" crossorigin="anonymous" defer></script>
    <script src="../../assets/global/globalScripts.js" defer></script>
    <script src="generalScripts.js"></script>
    <script src="basePageScript.js"></script>
</head>

<body>

<!--NavBar Comeco-->
<div id="myMainTopNavbarNavBackdrop" class=""></div>
<nav id="myMainTopNavbar" class="navbar navbar-expand-md">
    <div class="container-fluid">
        <a href="../Home/home.php" id="myMainTopNavbarBrand" class="navbar-brand">
            <img src="../../assets/images/dumb-brand.png" alt="Tá por aqui" class="my-brand-img">
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
                    <a href="chat.php" class="nav-link" id="navChatLink">Chat</a>
                </li>
                <?php if (empty($_SESSION['idUsuario'])) { ?>
                    <li class="nav-item">
                        <a href="../Entrar/login.php" class="nav-link">Entrar/cadastrar</a>
                    </li>
                <?php } ?>
            </ul>

            <?php if (isset($_SESSION['idUsuario']) && isset($_SESSION['email']) && isset($_SESSION['senha']) && isset($_SESSION['classificacao'])) { ?>
                <div class="dropdown">
                    <img src="../../assets/images/users/<?= $_SESSION['imagemPerfil'] ?>" alt="imagem de perfil" id="profileMenu" class="img-fluid" data-bs-toggle="dropdown" aria-expanded="false">

                    <div class="dropdown-menu" aria-labelledby="profileMenu">
                        <a class="dropdown-item" href="../Perfil/meu_perfil.php">Perfil</a>
                        <a class="dropdown-item text-danger" href="../../logic/entrar_logoff.php">Sair</a>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</nav>
<!--NavBar Fim-->

<div class="row" id="page">
    <!-- listagem de contatos -->
    <div class="col-md-3" id="chatFirstColumn">
        <h1 class="chatTitle">CHAT</h1>

        <div class="input-group mb-3">
            <input type="text" class="form-control chatSearchbar" id="searchedUser" name="searchedUser" placeholder="Insira o nome do serviço" aria-label="Recipient's username" aria-describedby="basic-addon2">
            <button class="input-group-text chatSearchButton" type="button" id="searchUser" onclick="searchUser()"> <i class="fas fa-search"></i> </button>
        </div>

        <div id="loadAssyncContacts">
            <!-- Os contatos serão carregados dinamicamente -->
            <strong class="me-3">Carregando contatos...</strong>
            <div class="spinner-border" role="status"></div>
        </div>
    </div>

    <!-- mensagens -->
    <div class="col-md-9" id="chatSecondColumn">
        <div class="returnArrow" onclick="returnToContacts()">
            <i class="fas fa-chevron-left"></i> Voltar
        </div>
        <div id="loadAssyncConversation">
            <!-- A conversa será selecionada dinamicamente -->

            <!-- Quando a página carrega sem nenhuma conversa selecionada, exibir mensagem: -->
            <div class="noConversationSelected">
                <div class="d-flex flex-column text-center mt-auto mb-auto">
                    <img src="../../assets/images/user_not_found.png" alt="selecionar um usuário" class="align-self-center">
                    <hr>
                    <h3>Se comunique eficazmente</h3>
                    <p>Use nosso chat para conversar com seu prestador ou cliente do serviço contratado. Seja educado &#x1F609;</p>
                </div>
            </div>
        </div>

        <form action="chat.php" method="POST" enctype="multipart/form-data" id="midiaForm">
            <div class="communicationBar row d-none" id="communicationBar">
                <div class="col-1 d-flex justify-content-center">
                    <button type="button" class="formatBtn" id="useEmojiMsg"><i class="far fa-laugh chatIcon"></i></button>
                </div>

                <div class="col-1 d-flex justify-content-center align-items-center">
                    <label for="midiaInput" class="formatBtn d-flex" id="showMidiainput"><i class="fas fa-paperclip chatIcon"></i></label>
                </div>

                <div class="col-10 d-flex">
                    <div class="input-group" id="chatMessageInputGroup">
                        <textarea class="form-control chatMessageInput" placeholder="Digite uma mensagem" rows="2" id="chatMessageInput" maxlength="65535"></textarea>
                        <button type="button" class="input-group-text chatMessageSend" id="sendMessage"><i class="fas fa-paper-plane"></i></button>
                    </div>

                    <div class="input-group d-none align-self-center" id="midiaInputGroup">
                        <input type="file" name="midiaInput" id="midiaInput" class="form-control" onchange="changeInput()" aria-describedby="sendFile" data-bs-toggle="popover" data-bs-placement="top">
                        <button type="submit" class="input-group-text chatMessageSend" id="sendFile"><i class="fas fa-paper-plane"></i></button>
                        <button type="button" class="input-group-text ml-2" id="deleteFile" onclick="delFile()"><i class="fas fa-trash text-danger"></i></button>
                    </div>
                </div>

                <input type="hidden" name="id_chat_contato" id="id_chat_contato">
                <input type="hidden" name="id_remetente" id="id_remetente" value="<?=$_SESSION['idUsuario']?>">
                <input type="hidden" name="id_destinatario" id="id_destinatario">
                <input type="hidden" id="nome_servico">
                <input type="hidden" id="nome_prestador">
            </div>
        </form>
    </div>
    <!-- fim mensagens -->

    <!-- detalhes do contato -->
    <div class="col-md-3" id="chatThirdColumn">
        <div class="returnArrow mt-4 ml-4" onclick="returnToChat()">
            <i class="fas fa-chevron-left"></i> Voltar
        </div>
        <div id="loadAssyncUserInfo">
            <!-- As informaçõesdo usuário serão carregadas dinamicamente -->
        </div>
    </div>
    <!-- fim detalhes do contato -->

    <!-- modal de denúncia de serviço -->
    <div class="modal fade" id="serviceComplainModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body" id="serviceComplainModalBody"></div>
            </div>
        </div>
    </div>
</div>
</body>
</html>