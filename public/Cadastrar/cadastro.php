<?php
session_start();

//caso haja cookies salvos no pc do usuário, ele vai logar com os cookies salvos
require "../../logic/entrar_cookie.php";

//caso haja session(logado), o usuário não pode acessar essa página
if (isset($_SESSION['idUsuario']) && isset($_SESSION['email']) && isset($_SESSION['senha']) && isset($_SESSION['classificacao'])) {
    header('Location: ../Home/home.php');
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tá por aqui - Cadastro</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/global/globalStyles.css">
    <link rel="stylesheet" href="cadastro.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="../../assets/jQueyMask/jquery.mask.js" defer></script>
    <script src="https://kit.fontawesome.com/2a19bde8ca.js" crossorigin="anonymous" defer></script>
    <script src="../../assets/global/globalScripts.js" defer></script>
    <script src="cadastro.js" defer></script>
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
                    <a href="../ComoFunciona/comoFunciona.php" class="nav-link">Sobre</a>
                </li>
                <li class="nav-item">
                    <a href="../Chat/chat.php" class="nav-link">Chat</a>
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
    <section id="registerDiv" class="row container">
        <div class="col-md-9">
            <div id="registerContent">
                <h1 class="mb-4"> Crie uma conta </h1>

                <form action="../../logic/cadastro_registra_cliente.php" method="POST" id="registerForm">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="userName" class="myLabel">Nome</label>
                            <input type="text" class="form-control required" name="userName" id="userName" placeholder="Insira seu nome" maxlength="15">
                            <br>
                            <label for="userLastName" class="myLabel">Sobrenome</label>
                            <input type="text" class="form-control required" name="userLastName" id="userLastName" placeholder="Insira o seu sobrenome" maxlength="15">
                            <br>
                            <label for="userEmail" class="myLabel">Email</label>
                            <input type="email" class="form-control required" name="userEmail" id="userEmail" placeholder="ex.: exemplo@gmail.com" maxlength="40">
                            <br>
                            <label for="userPass" class="myLabel">Senha</label>
                            <div class="input-group">
                                <input type="password" class="form-control password required" name="userPass" id="userPass" placeholder="Crie uma senha" aria-label="senha do usuário" aria-describedby="viewPass" maxlength="40">
                                <button type="button" class="input-group-text btnShowPass" id="viewPass" onclick="showPass()"><i class="fas fa-eye" id="eye"></i></button>
                            </div>
                            <br>
                            <label for="userConfirmPass" class="myLabel">Confirmar senha</label>
                            <div class="input-group">
                                <input type="password" class="form-control password required" name="userConfirmPass" id="userConfirmPass" placeholder="Confirme a senha anterior" aria-label="senha do usuário" aria-describedby="viewConfirmPass" maxlength="40">
                                <button type="button" class="input-group-text btnShowPass" id="viewConfirmPass" onclick="showConfirmPass()"><i class="fas fa-eye" id="eye2"></i></button>
                            </div>

                        </div>
                        <div class="col-md-6 mt-4 mt-md-0">
                            <label for="btnAdressModal" class="myLabel">Informações de endereço</label>
                            <button type="button" id="btnAdressModal" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#adressModal" onclick="requestUserLocation()"> Editar endereço</button>
                            <br> <br>

                            <div class="modal fade" id="adressModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Informações do endereço</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <!-- inputs com informações do endereço -->
                                        <div class="modal-body">
                                            <label for="userAdressCEP" class="myLabel">CEP</label>
                                            <input type="text" class="form-control required" name="userAdressCEP" id="userAdressCEP" placeholder="ex.: 01234567" onkeyup="callGetAdress(this)">
                                            <small id="cepError" class="text-danger"></small>

                                            <div class="row mt-3">
                                                <div class="col-3">
                                                    <label for="userAdressState" class="myLabel">Estado</label>
                                                    <input type="text" class="form-control required mb-3" name="userAdressState" id="userAdressState" readonly data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="autocompletado com o CEP" data-bs-placement="top">
                                                </div>
                                                <div class="col-9">
                                                    <label for="userAdressCity" class="myLabel">Cidade</label>
                                                    <input type="text" class="form-control required mb-3" name="userAdressCity" id="userAdressCity" placeholder="autocompletado com o CEP" readonly>
                                                </div>
                                            </div>

                                            <label for="userAdressNeighborhood" class="myLabel">Bairro</label>
                                            <input type="text" class="form-control required mb-3" name="userAdressNeighborhood" id="userAdressNeighborhood" placeholder="Digite seu bairro">

                                            <div class="row">
                                                <div class="col-9">
                                                    <label for="userAdressStreet" class="myLabel">Rua</label>
                                                    <input type="text" class="form-control required mb-3" name="userAdressStreet" id="userAdressStreet" placeholder="Digite sua rua">
                                                </div>
                                                <div class="col-3">
                                                    <label for="userAdressNumber" class="myLabel">Número</label>
                                                    <input type="number" class="form-control required mb-3" name="userAdressNumber" id="userAdressNumber" maxlength="5">
                                                </div>
                                            </div>

                                            <label for="userAdressComplement" class="myLabel">Complemento</label>
                                            <input type="text" class="form-control mb-3" name="userAdressComplement" id="userAdressComplement" placeholder="Digite o complemento (caso tenha)" data-bs-toggle="popover" data-bs-trigger="hover" title="Exemplo" data-bs-content="apto. 24 BL A" data-bs-placement="top"
                                                   maxlength="20">

                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="mybtn mybtn-complement" data-bs-dismiss="modal">Salvar endereço</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <label for="userBirthDate" class="myLabel">Data de nascimento</label>
                            <input type="date" class="form-control required" name="userBirthDate" id="userBirthDate">
                            <br>

                            <label class="myLabel">Sexo</label>
                            <label for="M"> <input type="radio" name="userSex" value="M" id="M" checked> Masculino </label> <br>
                            <label for="F"> <input type="radio" name="userSex" value="F" id="F"> Feminino </label> <br>
                            <label for="O"> <input type="radio" name="userSex" value="O" id="O"> Outro </label>

                            <div id="serviceDiv" class="mt-2">
                                <h6>Você está se cadastrando como prestador de serviços?</h6>
                                <label for="serviceProvider" class="mb-4"> <input type="checkbox" name="serviceProvider" id="serviceProvider"> Eu sou um prestador de serviços</label>

                                <h6>Você está cadastrando um pequeno negócio?</h6>
                                <label for="smallBusiness"> <input type="checkbox" name="smallBusiness" id="smallBusiness"> Sim, estou cadastrando um pequeno negócio</label>
                            </div>
                        </div>
                    </div>
                    <br>
                    <label for="termsOfUse" class="label-sm"> <input type="checkbox" name="termsOfUse" id="termsOfUse"> Estou ciente, aceito e concordo com os</label> <span class="link-primary label-sm" data-bs-toggle="modal" data-bs-target="#thermsOfUserModal">termos de uso </span> <label for="termsOfUse" class="label-sm">da plataforma</label>
                    <br>
                    <div class="row mt-4">
                        <div class="col-md-8">
                            <button type="button" id="btnCreateAccount" class="btn btn-success w-100" onclick="registerConfirm()">Criar conta</button>
                        </div>
                        <div class="col-md-1 text-center mt-2 mt-md-0 d-flex align-items-center justify-content-center">
                            ou
                        </div>
                        <div class="col-md-3 mt-2 mt-md-0">
                            <a href="../Entrar/login.php" class="btn btn-outline-success w-100">Entre</a>
                        </div>
                    </div>
                    <span class="text-danger" id="msgErro"></span>
                </form>
            </div>
        </div>

        <div class="col-md-3 colorComplement"></div>
    </section>

    <svg width="761" height="567" viewBox="0 0 761 567" fill="none" xmlns="http://www.w3.org/2000/svg" class="d-none d-md-block">
        <path opacity="0.8" d="M258.947 218.405C188.4 61.0687 31.9052 7.24484 -37.5238 0L-57 625H761C746.032 565.804 682.771 442.218 549.467 421.438C382.837 395.462 347.131 415.076 258.947 218.405Z" fill="#45E586"/>
    </svg>
</div>

<!-- Modal para confirmar email -->
<div class="modal fade" id="confirmEmailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 d-flex flex-column align-items-center justify-content-center" id="modalMsg">
                            <h2>Só mais uma etapa...</h2>
                            <p class="text-justify">Verifique sua caixa de email e insira o código para finalizar o cadastro</p>
                        </div>
                        <div class="col-md-6" id="modalInput">
                            <p>Endereço de email cadastrado: <span id="InputEmailAdress" class="font-weight-bold"></span></p>
                            <input type="number" class="form-control" id="emailCode" placeholder="Insira o código enviado ao seu email">
                            <small id="confirmEmailError" class="text-danger d-none"> Código digitado invalido </small> <br>
                            <button class="btn btn-outline-success mt-2" id="confirmCode" onclick="confirmEmail()">Confirmar</button>
                        </div>
                    </div>
                </div>
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

<!-- Modal de email confirmado com sucesso -->
<?php if (isset($_GET['status']) && $_GET['status'] == "1") { ?>
    <div class="modal show" id="confirmedEmailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 d-flex flex-column align-items-center justify-content-center" id="confirmMsg">
                                <h2>Cadastro confirmado com sucesso <i class="fas fa-check" style="color: #45E586;"></i></h2> <br>
                                <a href="../Entrar/login.php" class="btn btn-outline-success"> Fazer login </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script> document.getElementById('page').style.filter = "blur(3px)" </script>
<?php } ?>
</body>
</html>