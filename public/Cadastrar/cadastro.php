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
    <link rel="stylesheet" href="cadastro.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="../../assets/bootstrap/popper.min.js" defer></script>
    <script src="../../assets/bootstrap/bootstrap-4.5.3-dist/js/bootstrap.min.js" defer></script>
    <script src="../../assets/jQueyMask/jquery.mask.js" defer></script>

    <script src="../../assets/global/globalScripts.js" defer></script>
    <script src="cadastro.js" defer></script>
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
                    <a href="../Home/home.html" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="../EncontrarProfissional/Listagem/dumb.txt" class="nav-link">Encontre um pofissional</a> 
                </li>
                <li class="nav-item">
                    <a href="../Artigos/artigos.html" class="nav-link">Artigos</a>      
                </li>
                <li class="nav-item">
                    <a href="../Contato/contato.html" class="nav-link">Fale conosco</a>
                </li>
                <li class="nav-item">
                    <a href="../SobreNos/sobreNos.html" class="nav-link">Sobre</a>
                </li>
                <li class="nav-item">
                    <a href="../Chat/chat.html" class="nav-link">Chat</a>
                </li>
                <li class="nav-item">
                    <a href="../Entrar/login.html" class="nav-link">Entrar/cadastrar</a>
                </li>
            </ul>

        </div>
        
    </nav>
    <!--NavBar Fim-->

    <div id="page">
        <section id="registerDiv" class="row container">
            <div class="col-md-9">
                <div id="registerContent">
                    <h1> Crie uma conta </h1>
                    <br>

                    <form action="../../logic/cadastro_registra_cliente.php" method="POST" id="registerForm">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="userName" class="myLabel">Nome</label> <br>
                                <input type="text" class="form-control required" name="userName" id="userName" placeholder="Insira seu nome">
                                <br>
                                <label for="userLastName" class="myLabel">Sobrenome</label> <br>
                                <input type="text" class="form-control required" name="userLastName" id="userLastName" placeholder="Insira o seu sobrenome">
                                <br>
                                <label for="userPhone" class="myLabel">Telefone</label> <br>
                                <input type="tel" class="form-control required" name="userPhone" id="userPhone" placeholder="ex.: (11)91234-5678">
                                <br>
                                <label for="userEmail" class="myLabel">Email</label> <br>
                                <input type="email" class="form-control required" name="userEmail" id="userEmail" placeholder="ex.: pearrudas@gmail.com">
                                <br>
                                <label for="userPass" class="myLabel">Senha</label> <br>
                                <div class="input-group">
                                    <input type="password" class="form-control password required" name="userPass" id="userPass" placeholder="Crie uma senha" aria-describedby="viewPass">
                                    <div class="input-group-append">
                                        <button type="button" class="input-group-text btnShowPass" id="viewPass" onclick="showPass()"> <i class="fas fa-eye" id="eye"></i> </button>
                                    </div>
                                </div>
                                <br>
                                <label for="userConfirmPass" class="myLabel">Confirmar senha</label> <br>
                                <div class="input-group">
                                    <input type="password" class="form-control password required" name="userConfirmPass" id="userConfirmPass" placeholder="Confirme a senha anterior" aria-describedby="viewPass">
                                    <div class="input-group-append">
                                        <button type="button" class="input-group-text btnShowPass" id="viewConfirmPass" onclick="showConfirmPass()"> <i class="fas fa-eye" id="eye2"></i> </button>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-md-6 mt-4 mt-md-0">
                                <label for="btnAdressModal" class="myLabel">Informações de endereço</label> <br>
                                <button type="button" id="btnAdressModal" class="btn btn-primary btn-block" data-toggle="modal" data-target="#adressModal"> Editar endereço </button>
                                <div class="modal fade" id="adressModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">

                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">Informações do endereço</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>

                                        <!-- inputs com informações do endereço -->
                                        <div class="modal-body">
                                            <label for="userAdressCEP" class="myLabel">CEP</label> <br>
                                            <input type="text" class="form-control required" name="userAdressCEP" id="userAdressCEP" placeholder="ex.: 01234567" onkeyup="callGetAdress(this)">
                                            <small id="cepError" class="text-danger"></small>

                                            <div class="row mt-3">
                                                <div class="col-3">
                                                    <label for="userAdressState" class="myLabel">Estado</label> <br>
                                                    <input type="text" class="form-control required mb-3" name="userAdressState" id="userAdressState" readonly data-toggle="popover" data-trigger="hover" data-content="autocompletado com o CEP" data-placement="top">
                                                </div>
                                                <div class="col-9">
                                                    <label for="userAdressCity" class="myLabel">Cidade</label> <br>
                                                    <input type="text" class="form-control required mb-3" name="userAdressCity" id="userAdressCity" placeholder="autocompletado com o CEP" readonly>
                                                </div>
                                            </div>

                                            <label for="userAdressNeighborhood" class="myLabel">Bairro</label> <br>
                                            <input type="text" class="form-control required mb-3" name="userAdressNeighborhood" id="userAdressNeighborhood" placeholder="Digite seu bairro" >

                                            <div class="row">
                                                <div class="col-9">
                                                    <label for="userAdressStreet" class="myLabel">Rua</label> <br>
                                                    <input type="text" class="form-control required mb-3" name="userAdressStreet" id="userAdressStreet" placeholder="Digite sua rua" >
                                                </div>
                                                <div class="col-3">
                                                    <label for="userAdressNumber" class="myLabel">Número</label> <br>
                                                    <input type="number" class="form-control required mb-3" name="userAdressNumber" id="userAdressNumber" >
                                                </div>
                                            </div>

                                            <label for="userAdressComplement" class="myLabel">Complemento</label> <br>
                                            <input type="text" class="form-control mb-3" name="userAdressComplement" id="userAdressComplement" placeholder="Digite o complemento (caso tenha)" data-toggle="popover" data-trigger="hover" title="Exemplo" data-content="apto. 24 BL A" data-placement="top">
                                            
                                        </div>

                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-primary" data-dismiss="modal">Salvar endereço</button>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                
                                <br>
                                <label for="userBirthDate" class="myLabel">Data de nascimento</label> <br>
                                <input type="date" class="form-control required" name="userBirthDate" id="userBirthDate" class="mb-3">
                                <br>
                                <label class="myLabel">Sexo</label> <br>
                                <label for="M"> <input type="radio" name="userSex" value="M" id="M" checked> Masculino </label> <br>
                                <label for="F"> <input type="radio" name="userSex" value="F" id="F"> Feminino </label> <br>
                                <label for="O"> <input type="radio" name="userSex" value="O" id="O"> Outro </label>

                                <div id="serviceDiv" class="mt-2">
                                    <h6>Você está se cadastrando como prestador de serviços?</h6>
                                    <label for="serviceProvider"> <input type="checkbox" name="serviceProvider" id="serviceProvider"> Eu sou um prestador de serviços</label> 
                                    <br><br>
                                    <h6>Você está cadastrando um pequeno negócio?</h6>
                                    <label for="smallBusiness"> <input type="checkbox" name="smallBusiness" id="smallBusiness"> Sim, estou cadastrando um pequeno negócio</label> 
                                </div>
                            </div>
                        </div>
                        <br>
                        <label for="termsOfUse" style="font-size: 14px;"> <input type="checkbox" name="termsOfUse" id="termsOfUse"> Estou ciente, aceito e concordo com os <a href="">termos de uso </a> da plataforma</label> 
                        <br>
                        <div class="row mt-4">
                            <div class="col-md-8">
                                <button type="button" id="btnCreateAccount" class="btn btn-success btn-block" onclick="registerConfirm()">Criar conta </button>
                            </div>
                            <div class="col-md-1 text-center mt-2 mt-md-0">
                                ou
                            </div>
                            <div class="col-md-3 mt-2 mt-md-0">
                                <a href="../Entrar/login.html" class="btn btn-outline-success btn-block">Entre</a>
                            </div>
                        </div>
                        <span class="text-danger" id="msgErro"></span>
                    </form>
                </div>
            </div>
            
            <div class="col-md-3 colorComplement"></div>
        </section>
    </div>

    <!-- Modal para confirmar email -->
    <div class="modal fade" id="confirmEmailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <p>Endereço de email cadastrado: <span id="InputEmailAdress" class="font-weight-bold"></span> </p>
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

    <!-- Modal de email confirmado com sucesso -->
    <?if( isset($_GET['status']) && $_GET['status'] == "1" ){?>
        <div class="modal show" id="confirmedEmailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12 d-flex flex-column align-items-center justify-content-center" id="confirmMsg">
                                    <h2>Cadastro confirmado com sucesso <i class="fas fa-check" style="color: #45E586;"></i> </h2> <br>
                                    <a href="../Entrar/login.html" class="btn btn-outline-success"> Fazer login </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script> document.getElementById('page').style.filter = "blur(3px)" </script>
    <?}?>


    <svg width="761" height="567" viewBox="0 0 761 567" fill="none" xmlns="http://www.w3.org/2000/svg" class="d-none d-md-block">
        <path opacity="0.8" d="M258.947 218.405C188.4 61.0687 31.9052 7.24484 -37.5238 0L-57 625H761C746.032 565.804 682.771 442.218 549.467 421.438C382.837 395.462 347.131 415.076 258.947 218.405Z" fill="#45E586"/>
    </svg>
</body>
</html>