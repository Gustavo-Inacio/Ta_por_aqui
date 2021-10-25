<?php
session_start();

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
                        <a href="comoFunciona.php" class="nav-link">Como funciona</a>
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
                        <a href="../Perfil/meu_perfil.php" class="mt-3 sectionButton align-self-end">Entrar no Chat <i class="far fa-comment ms-3"></i></a>
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
</body>
</html>