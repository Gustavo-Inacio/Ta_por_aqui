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

//Se o usuário carregou essa página, não precisa mais mostrar o tutorial de chat pra ele -> destrói o cookie que verifica isso
setcookie('chatTutorial', '', time() - 3600, '/');
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
    <link rel="stylesheet" href="boasVindas.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="../../assets/emojiPicker/fgEmojiPicker.js"></script>
    <script src="https://kit.fontawesome.com/2a19bde8ca.js" crossorigin="anonymous" defer></script>
    <script src="../../assets/global/globalScripts.js" defer></script>
    <script src="generalScripts.js"></script>
    <script src="basePageScript.js" type="module"></script>
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

<div id="page">
    <div class="myContainer row">
        <div class="col-12 col-md-7 content-col">
            <div class="png-square align-self-center d-block d-md-none">
                <img class="png" src="../../assets/images/chat-cell-logo.png" alt="chat logo">
            </div>

            <h1 class="content-title">Olá, bem vindo ao chat!</h1>

            <?php if (isset($_SESSION['idUsuario'])) {?>
                <div id="information-carrousel" class="carousel carousel-dark slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#information-carrousel" data-bs-slide-to="0" class="border active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#information-carrousel" data-bs-slide-to="1" class="border" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#information-carrousel" data-bs-slide-to="2" class="border" aria-label="Slide 3"></button>
                    </div>

                    <div class="carousel-inner">
                        <div class="carousel-item active" data-bs-interval="100000">
                            <p class="content-text" style="margin-bottom: 15px">
                                O chat é uma forma de se conectar com o cliente ou com um prestador de serviço que está cadastrado em nossa plataforma. <br>
                                <button type="button" class="mybtn mybtn-outline-complement w-50 mt-4" data-bs-target="#information-carrousel" data-bs-slide-to="1">Prosseguir</button>
                            </p>
                        </div>
                        <div class="carousel-item" data-bs-interval="100000">
                            <p class="content-text" style="margin-bottom: 15px">
                                Ao usar nosso sistema de chat você concorda com os <span class="link-primary label-sm" data-bs-toggle="modal" data-bs-target="#thermsOfUserModal">termos de uso</span> da plataforma<br>
                                <button type="button" class="mybtn mybtn-outline-complement w-50 mt-4" data-bs-target="#information-carrousel" data-bs-slide-to="2">Prosseguir</button>
                            </p>
                        </div>
                        <div class="carousel-item" data-bs-interval="100000">
                            <div class="content-list">
                                Para manter sua experiência na plataforma a melhor possível, siga algumas regras de conduta e segurança:
                                <ul>
                                    <li>Seja educado com a outra pessoa e não use xingamentos ou ofensas</li>
                                    <li>Não compartilhe dados sigilosos com ninguém (por exemplo: senhas, contas, etc.)</li>
                                    <li>Não compartilhe arquivos maliciosos e não confie em arquivos com extensões suspeitas</li>
                                </ul>
                            </div>
                            <button type="button" class="mybtn mybtn-outline-complement w-50 mt-4" data-bs-target="#information-carrousel" data-bs-slide-to="0">Voltar</button>
                            <br> ou <br>
                            <a href="chat.php" class="mybtn mybtn-outline-conversion w-50">Ir para o chat</a>
                        </div>
                    </div>
                    <br>
                </div>
            <?php } else {?>
                <p class="content-text" style="margin-bottom: 15px">
                    O chat é uma forma de se conectar com o cliente ou com um prestador de serviço que está cadastrado em nossa plataforma.
                </p>
                <p class="content-text" style="margin-bottom: 10px">
                    Para acessar o chat é necessário ter um cadastro na plataforma. Não perca tempo e cadastre-se agora mesmo para encontrar os melhores prestadores! <br>
                </p>
                <a href="../Cadastrar/cadastro.php" class="mybtn mybtn-outline-complement mt-2">Cadastrar!</a>
            <?php }?>
        </div>
        <div class="col-md-4 d-none d-md-flex image-col">
            <div class="png-circle align-self-center">
                <img class="png" src="../../assets/images/chat-logo.png" alt="chat logo">
            </div>
        </div>
    </div>
</div>

<!-- Modal de termos de uso -->
<div class="modal fade" id="thermsOfUserModal" tabindex="-1" aria-labelledby="thermsOfUserModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Termos e condições de uso da plataforma</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p> Obrigado por utilizar os serviços do Tá Por Aqui! A seguir apresentaremos os termos do nosso website, os quais designam informações que regem nossa conformidade com prestadores de serviços, clientes e usuários em geral. Ao utilizar essa plataforma ou seus serviços, você concorda que deve agir sob as cláusulas manifestadas nesses termos, estando vinculado aos mesmos. Caso possua algum inquérito sobre esse documento, é possível nos contatar pelos nossos canais de comunicação, como nosso e-mail (<a href="mailto: taporaqui@gmail.com">taporaqui@gmail.com</a>) ou pela nossa  <a href="../Contato/contato.php" target="_blank">página de Contato</a>. </p>
                <hr>
                <h3 class="thermsOfUseTitle">Relação entre Cliente e Prestador</h3>
                <p>O prestador terá a responsabilidade de realizar seus serviços conforme estão designados no seu próprio Serviço; assim sendo, o cliente deverá fornecer o ambiente ou a condição para a realização do mesmo, além de estar obrigado a realizar o pagamento devido ao prestador, conforme foi proposto na plataforma. O prestador deverá seguir as instruções designadas pelo cliente, caso sejam válidas, sem aplicar serviços indesejáveis ou cobranças extras que não entram em acordo com seu serviço; inversamente, o cliente não deverá demandar serviços extras que não estejam de acordo com os serviços de seu prestador. </p>
                <p>A omissão, realização indevida ou conduta indevida durante o período de prestação de serviços não será responsabilidade do Tá Por Aqui, estando sob jurisdição da legislação e responsabilidade dos partidários envolvidos. Essa plataforma apenas busca conectar clientes a prestadores e vice versa, contudo, não estamos responsáveis por qualquer ação causada pela realização do serviço fora desse ambiente, que inclui pagamento por serviços, contato físico entre prestador e cliente e o ato do serviço em si. Declaramos também isenção a quaisquer responsabilidades pelo aspecto profissional e relacional entre usuários, estando ao dispor dos mesmos. </p>
                <hr>
                <h3 class="thermsOfUseTitle">Cadastro de Usuário e Uso de Dados</h3>
                <p>Ao criar uma conta como cliente ou prestador, o usuário concorda que possui 18 anos ou mais e, afirma que somente ele é responsável pela sua conta. O usuário também concorda com o uso de cookies, que são utilizados nesse site apenas essencialmente, permitindo que o usuário se mantenha logado e mantenha certos dados necessários ao trocar de página. </p>
                <p>O Tá Por Aqui trata os dados de seus usuários e serviços com devida segurança, e a esse fim, os únicos dados que a empresa utilizará para compartilhamento serão dados de localização para APIs de terceiros. A nossa equipe realiza a coleta e uso dos seguintes dados: Nome, Sobrenome, E-Mail e Endereço, que serão utilizados no cadastro e exibidos em seu perfil e serviço; Senha, Sexo, Data de Nascimento e Status de Prestador, que serão utilizados no cadastro, mas que permanecerão anônimos; imagens e informações providenciadas no cadastro de serviço, as quais serão exibidas no catálogo de serviços; qualquer texto, imagem ou documento enviado pelo chat, que estarão sujeitas a revisão caso uma denuncia ocorra. </p>
                <hr>
                <h3 class="thermsOfUseTitle">Cadastro de Serviço</h3>
                <p>Durante o processo de criação de serviço, o usuário concorda que deverá utilizar ele civilmente, conforme a legislação nacional imponha, e que a plataforma não é responsável por qualquer atividade ilegal realizada por usuários durante os serviços ou o cadastro deles, incluindo o conteúdo dos mesmos. O criador do serviço deverá também manter as imagens do serviço relevantes, com sujeita a mudança ou remoção das imagens. </p>
                <p>A responsabilidade do serviço criado cai inteiramente sobre o criador do mesmo, devendo atualiza-lo conforme informações relevantes como endereço e informações de contato mudarem, e concorda em não propagar em seus serviços o seguinte: conteúdo potencialmente obsceno ou ofensivo, pornográfico, ou que faça ofensa ou atente um individuo ou grupo. Também não serão permitidos conteúdos que violem nossa propriedade intelectual. A brecha desses termos poderá resultar em punição ao usuário ou ao(s) serviço(s) dele, como suspensão ou deleção. </p>
                <hr>
                <h3 class="thermsOfUseTitle">Propriedade Intelectual</h3>
                <p>Em acordo com o conteúdo, estrutura, padrão, e formatação de nosso site, os mesmos estão protegidos sob direitos gerais de propriedade intelectual. Da mesma forma, é proibida a modificação, cópia ou distribuição de nosso website ou quaisquer elementos seus, além de estar proibida a distribuição de elementos como imagens e texto nele contidos. </p>
                <p>Quaisquer imagens, informações, texto e dados que o usuário inserir em seus serviços ou perfil passam a ser propriedade sua, e que o Tá Por Aqui poderá utilizar esses dados para devidos fins como divulgação. </p>
                <p>O Tá Por Aqui não se responsabiliza por infração de direitos a imagem ou propriedade intelectual realizados por usuários do site ou de terceiros, porém, a infração em questão poderá ser resolvida pela plataforma a qualquer momento. </p>
                <hr>
                <h3 class="thermsOfUseTitle">Usos Gerais </h3>
                <p>Esse documento poderá ser atualizado conforme a necessidade surgir pela plataforma a qualquer momento, sem aviso prévio. </p>

            </div>
            <div class="modal-footer">
                <button type="button" class="mybtn mybtn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>