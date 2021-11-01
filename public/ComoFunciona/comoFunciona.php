<?php
session_start();

$isProvider = false;

if(isset($_SESSION['classificacao']) && $_SESSION['classificacao'] >= 1){
    $isProvider = true;
}


//caso haja cookies salvos no pc do usuário, ele vai logar com os cookies salvos
require "../../logic/entrar_cookie.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tá por aqui - Sobre Nós</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/global/globalStyles.css">
    <link rel="stylesheet" href="comoFunciona.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/2a19bde8ca.js" crossorigin="anonymous" defer></script>
    <script src="../../assets/global/globalScripts.js" defer></script>

    <script>
        function openCollapsedInfo(content, button) {
            //fechar todas as CollapsedInfo primeiro e tirar foco do botão
            [].forEach.bind(document.getElementsByClassName("collapseContent"),element => {
                element.classList.add('d-none')
            })();

            [].forEach.bind(document.getElementsByClassName("collapseOption"),element => {
                element.classList.remove('selected')
            })();

            //destacar botão
            button.classList.add('selected')

            //abrir conteúdo
            document.getElementById(`collapsedContent${content}`).classList.remove('d-none')
        }
    </script>
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
                        <a href="comoFunciona.php" class="nav-link">Sobre</a>
                    </li>
                    <li class="nav-item">
                        <a href="../Chat/chat.php" class="nav-link" id="navChatLink">Chat</a>
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

    <!-- Seção sobre nós -->
    <section class="aboutUs">
        <div class="container">
            <div class="content">
                <div class="row">
                    <div class="col-md-3">
                        <div class="collapseMenu">
                            <button class="collapseOption selected" onclick="openCollapsedInfo(1, this)"><i class="fas fa-bullseye me-3"></i> <span>Nossa missão e valores</span></button>
                            <button class="collapseOption" onclick="openCollapsedInfo(2, this)"><i class="far fa-handshake"></i> <span>Aos prestadores</span></button>
                            <button class="collapseOption" onclick="openCollapsedInfo(3, this)"><i class="far fa-user"></i> <span>Aos clientes</span></button>
                            <button class="collapseOption" onclick="openCollapsedInfo(4, this)"><i class="fas fa-file-contract"></i> <span>Termos de uso</span></button>
                        </div>
                    </div>
                    <div class="col-md-9 mt-4 mt-md-0">
                        <div class="collapseContent" id="collapsedContent1">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="fas fa-bullseye icon"></i>
                                </div>
                                <div class="col">
                                    <h2>Nossa missão e valores</h2>
                                    <span>Qual o propósito do Ta por Aqui em ajudar nossos usuários</span>
                                </div>
                            </div>
                            <div class="collapseContentText">
                                <p>Somos uma plataforma com um <strong> ideal voltado a um trabalho social</strong>, afim de <strong> ajudar os trabalhadores prejudicados pela pandemia e a quarentena.</strong></p>
                                <p>Além de proporcionar um <strong>sistema eficaz e acessível</strong> para ambos as partes do negócio, Tornamos possível que um serviço esteja mais perto de você e que um trabalhador <strong>autónomo consiga exercer sua profissão ou sua nova habilidade.</strong></p>
                            </div>
                        </div>

                        <div class="collapseContent d-none" id="collapsedContent2">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="far fa-handshake icon"></i>
                                </div>
                                <div class="col">
                                    <h2>Aos prestadores</h2>
                                    <span>O que temos a oferecer para nosso usuários prestadores</span>
                                </div>
                            </div>
                            <div class="collapseContentText">
                                <p>A plataforma <strong>Tá por aqui</strong> garante que você, como prestador, tenha uma vitrine para anunciar os seus serviços para antigos e novos clientes. Nos disponibilizamos uma completa e prática ferramenta de criação de serviço para que você consiga detalhar ao máximo suas habilidade e atrair clientes.</p>
                                <p>Não se preocupe pois a plataforma sempre irá te recomendar para o cliente mais próximo possível que esteja procurando um serviço parecido com o seu</p>
                            </div>
                        </div>

                        <div class="collapseContent d-none" id="collapsedContent3">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="far fa-user icon"></i>
                                </div>
                                <div class="col">
                                    <h2>Aos clientes</h2>
                                    <span>O que temos a oferecer para nosso usuários clientes</span>
                                </div>
                            </div>
                            <div class="collapseContentText">
                                <p>A plataforma <strong>Tá por aqui</strong> garante o seu conforto e confiabilidade como cliente, indicando os melhores e mais próximos prestadores para fazerem um serviço para você.</p>
                                <p>É sempre possível checar a qualidade do serviço prestado por meio das avaliações e das redes sociais</p>
                            </div>
                        </div>

                        <div class="collapseContent d-none" id="collapsedContent4">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="fas fa-file-contract icon"></i>
                                </div>
                                <div class="col">
                                    <h2>Termos de uso</h2>
                                    <span>Quais são as responsabilidades da plataforma e do usuário</span>
                                </div>
                            </div>
                            <div class="collapseContentText">
                                Leia os termos de uso <a href="#thermsOfUserModal" data-bs-toggle="modal" data-bs-target="#thermsOfUserModal" class="text-light fw-bold">clicando aqui</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- fim seção sobre nós -->

    <!-- seção tutorial pesquisa -->
    <section class="searchTutorial">
        <div class="container">
            <div class="content">
                <div class="row">
                    <div class="col-md-8 d-flex flex-column justify-content-center">
                        <h1 class="sectionTitle">Como encontrar um prestador de serviço</h1>

                        <p class="sectionText">Encontrar um prestador de serviço na nossa plataforma é uma tarefa bem simples, basta que você vá na aba <a href="../EncontrarProfissional/Listagem/listagem.php" class="fw-bold text-dark">ENCONTRAR UM PROFISSIONAL</a>. </p>
                        <p class="sectionText">Lá serão <strong>listados todos os serviços cadastrados na plataforma</strong> e você poderá entrar em contato com o profissional mais adequado à sua necessidade.</p>

                        <a href="../EncontrarProfissional/Listagem/listagem.php" class="sectionButton">ENCONTRAR UM PROFISSIONAL</a>
                    </div>
                    <div class="col-md-4 d-none d-md-flex flex-row justify-content-center">
                        <img src="../../assets/images/worker.png" class="sectionImg" alt="Imagem de trabalhador">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- fim seção tutorial pesquisa -->

    <!-- seção tutorial filtros -->
    <section class="filterTutorial">
        <div class="container">
            <div class="content">
                <div class="row">
                    <div class="col-md-8">
                        <h1 class="sectionTitle">O Filtro e a escolha ideal para sua necessidade</h1>
                        <p class="mb-3 sectionText">
                            A plataforma do Ta Por Aqui permite uma busca pelo serviço ideial por meio de série de critérios e preferências que serão escolhidas pelo próprio usuário. Permitindo a melhor escolha possível, para resolver as necessidades do cliente.
                        </p>

                        <div class="criteria"><i class="fas fa-list me-3"></i> <span>O sistema de avaliação permite que você escolha o melhor da área</span></div>
                        <div class="criteria"><i class="fas fa-map-marker-alt me-3"></i> <span>Você pode escolher os serviços mais próximos de você </span></div>
                        <div class="criteria"><i class="fas fa-home me-3"></i> <span>Serviço remoto ou não remoto</span></div>
                        <div class="criteria"><i class="fas fa-medal me-3"></i> <span>Categoria e Subcategoria do serviço </span></div>
                        <div class="criteria"><i class="fas fa-money-bill me-3"></i> <span>O tipo de orçamento permite a melhor escolha financeira</span></div>

                        <a href="../EncontrarProfissional/Listagem/listagem.php" class="mt-3 sectionButton">Buscar Serviço ideal</a>
                    </div>
                    <div class="col-md-4 d-none d-md-flex flex-row justify-content-center align-items-end">
                        <img src="../../assets/images/example_screen.png" class="img-fluid" alt="Imagem da tela de encontrar serviço">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- fim seção tutorial filtros -->

    <!-- seção tutorial prestador -->
    <section class="providerTutorial">
        <div class="container">
            <div class="content">
                <div class="row">
                    <div class="col-md-4 d-none d-md-flex flex-row justify-content-center">
                        <img src="../../assets/images/become_provider_tutorial.png" class="sectionImg" alt="Imagem do modal de configurações de conta">
                    </div>
                    <div class="col-md-8 d-flex flex-column justify-content-center">
                        <h1 class="sectionTitle mb-3">Como posso me tornar um prestador de serviço na plataforma?</h1>

                        <p class="sectionText">Caso você não tenha se <strong>cadastrado na plataforma como prestador</strong>, não se preocupe, pois você ainda pode prestar serviços!</p>
                        <p class="sectionText">Para se tornar um prestador de serviço é necessário: <strong>abrir a sua tela de perfil <i class="fas fa-arrow-right"></i> clicar no botão "outras configurações" <i class="fas fa-arrow-right"></i> clicar no botão "Ser prestador". <i class="fas fa-arrow-right"></i> confirmar </strong></p>
                        <p class="sectionText">Desse modo é possível que você divulgue seus serviços na plataforma.</p>

                        <a href="../Perfil/meu_perfil.php" class="mt-3 sectionButton">Ir para configuração de Perfil</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- fim seção tutorial prestador -->

    <!-- seção tutorial chat -->
    <section class="chatTutorial">
        <div class="container">
            <div class="content">
                <div class="row">
                    <div class="col-md-4 d-none d-md-flex flex-row justify-content-center">
                        <img src="../../assets/images/handshake.png" class="img-fluid" alt="negócio fechado" style="max-width: 300px">
                    </div>
                    <div class="col-md-8 d-flex flex-column justify-content-center">
                        <h1 class="sectionTitle mb-3">Use chat para se comunicar e negociar com seu cliente</h1>

                        <p class="sectionText">Nossa plataforma conta com uma página de chat, onde é possível se comunicar com o cliente que contratou o serviço, ou com um profissional que você pretende contratar.</p>
                        <a href="../Chat/chat.php" class="mt-3 sectionButton align-self-end">Entrar no Chat <i class="far fa-comment ms-3"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- fim seção tutorial chat -->

    <!-- seção ajuda -->
    <section class="needHelp">
        <div class="container">
            <div class="content">
                <div class="row">
                    <div class="col-md-8 d-flex flex-column justify-content-center">
                        <h1 class="sectionTitle mb-3">Em caso de dúvida ou qualquer problema, estaremos a disposição para lhe ajudar. </h1>

                        <p class="sectionText">Caso haja qualquer problema na plataforma ou qualquer tipo de dúvida quanto as funcionalidades entre na <a href="../Contato/contato.php" class="fw-bold text-dark">página de suporte</a>. </p>
                        <p>Lá você poderá encontrar as dúvidas mais frequentes e poderá entrar em contato direto com os administradores por meio de un formulário de contato.</p>
                        <p>Caso preferir entrar em contato de outra forma, na mesma página há alguns outros meios de entrar em contato conosco, como por email, telefone ou instagram</p>

                        <a href="../Contato/contato.php" class="mt-3 sectionButton">Central de suporte</a>
                    </div>
                    <div class="col-md-4 d-none d-md-flex flex-row justify-content-center">

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- fim seção ajuda -->

    <!-- Footer -->
    <footer id="myMainFooter">
        <div id="myMainFooterContainer" class="container-fluid">
            <div class="my-main-footer-logo">
                <img src="../../assets/images/dumb-footer.png" alt="Tá por Aqui" class="my-footer-img">
            </div>
            <div class="my-main-footer-institutional">
                <p>INSTITUCIONAL</p>
                <a href="#">Quem Somos</a> <br>
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

    
<div id="mobileBottomNavbarSection-spacer"></div>
    <section id="mobileBottomNavbarSection" class="d-fixed d-sm-none">
        <div class="container-fluid">
            <div class="row">
                <div class="col mobile-navbar-item">
                    <a href="../Home/home.php">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M25.333 29.3332H6.66634C5.92996 29.3332 5.33301 28.7363 5.33301 27.9999V15.2186C5.33301 14.865 5.47361 14.5259 5.72367 14.2759L15.057 4.94256C15.3071 4.69219 15.6465 4.55151 16.0003 4.55151C16.3542 4.55151 16.6936 4.69219 16.9437 4.94256L26.277 14.2759C26.5273 14.5256 26.6675 14.865 26.6663 15.2186V27.9999C26.6663 28.7363 26.0694 29.3332 25.333 29.3332ZM13.333 19.9999H18.6663V26.6666H23.9997V15.7706L15.9997 7.77056L7.99967 15.7706V26.6666H13.333V19.9999Z" fill="#888F98"/>
                        </svg>

                        <p>Home</p>
                    </a>
                </div>
                <div class="col mobile-navbar-item ">
                    <a href="../Chat/chat.php">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.7351 23.7713L11.6065 24.2371C12.9568 24.959 14.4648 25.3356 15.996 25.3333L16 25.3333C21.1548 25.3333 25.3333 21.1548 25.3333 16C25.3333 10.8452 21.1548 6.66667 16 6.66667C10.8452 6.66667 6.66668 10.8452 6.66668 16V16.004C6.66437 17.5352 7.04097 19.0432 7.76289 20.3935L8.22873 21.2649L7.51244 24.4876L10.7351 23.7713ZM4.00001 28L5.41121 21.6508C4.48185 19.9125 3.99705 17.9712 4.00001 16C4.00001 9.3724 9.37241 4 16 4C22.6276 4 28 9.3724 28 16C28 22.6276 22.6276 28 16 28C14.0288 28.003 12.0875 27.5181 10.3492 26.5888L4.00001 28Z" fill="#888F98"/>
                        </svg>

                        <p>Chat</p>
                    </a>
                </div>

                <?php if($isProvider){ ?>
                    <div class="col mobile-navbar-item getting-out">
                        <a href="../Perfil/CriacaoServico/criar_servico.php">

                           <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20.5714 9.85714H14.1429V3.42857C14.1429 2.63973 13.5031 2 12.7143 2H11.2857C10.4969 2 9.85714 2.63973 9.85714 3.42857V9.85714H3.42857C2.63973 9.85714 2 10.4969 2 11.2857V12.7143C2 13.5031 2.63973 14.1429 3.42857 14.1429H9.85714V20.5714C9.85714 21.3603 10.4969 22 11.2857 22H12.7143C13.5031 22 14.1429 21.3603 14.1429 20.5714V14.1429H20.5714C21.3603 14.1429 22 13.5031 22 12.7143V11.2857C22 10.4969 21.3603 9.85714 20.5714 9.85714Z" fill="white"/>
                            </svg>
                        </a>
                    </div>
                <?php } ?>

                <div class="col mobile-navbar-item">
                    <a href="../EncontrarProfissional/Listagem/listagem.php">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.0005 29.3335C13.9845 29.3391 11.9941 28.883 10.1818 28.0001C9.51852 27.6775 8.88303 27.3006 8.28179 26.8734L8.09912 26.7401C6.44555 25.5196 5.09362 23.9364 4.14713 22.1121C3.16811 20.2239 2.66034 18.127 2.66706 16.0001C2.66706 8.63628 8.63666 2.66675 16.0005 2.66675C23.3643 2.66675 29.3339 8.63628 29.3339 16.0001C29.3405 18.1259 28.8332 20.2219 27.8551 22.1094C26.9099 23.9327 25.5599 25.5153 23.9085 26.7361C23.2855 27.1921 22.6244 27.5936 21.9325 27.9361L21.8258 27.9894C20.0124 28.877 18.0195 29.3368 16.0005 29.3335ZM16.0005 22.6667C14.0024 22.6628 12.1707 23.7788 11.2578 25.5561C14.2463 27.0363 17.7546 27.0363 20.7431 25.5561V25.5494C19.8291 23.7741 17.9973 22.6606 16.0005 22.6667ZM16.0005 20.0001C18.8886 20.0039 21.5517 21.5602 22.9725 24.0747L22.9925 24.0574L23.0111 24.0414L22.9885 24.0614L22.9751 24.0721C26.3471 21.1589 27.5528 16.4565 25.9987 12.2802C24.4445 8.10392 20.4579 5.33384 16.0018 5.33384C11.5457 5.33384 7.55912 8.10392 6.00493 12.2802C4.45074 16.4565 5.65646 21.1589 9.02846 24.0721C10.4501 21.5588 13.1129 20.0036 16.0005 20.0001ZM16.0005 18.6667C13.0549 18.6667 10.6671 16.2789 10.6671 13.3334C10.6671 10.3879 13.0549 8.00008 16.0005 8.00008C18.946 8.00008 21.3338 10.3879 21.3338 13.3334C21.3338 14.7479 20.7719 16.1045 19.7717 17.1047C18.7715 18.1048 17.4149 18.6667 16.0005 18.6667ZM16.0005 10.6667C14.5277 10.6667 13.3338 11.8607 13.3338 13.3334C13.3338 14.8062 14.5277 16.0001 16.0005 16.0001C17.4732 16.0001 18.6671 14.8062 18.6671 13.3334C18.6671 11.8607 17.4732 10.6667 16.0005 10.6667Z" fill="#888F98"/>
                        </svg>


                        <p>Pesquisar</p>
                    </a>
                </div>
                <div class="col mobile-navbar-item">
                    <a href="../Perfil/meu_perfil.php">
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
</body>
</html>