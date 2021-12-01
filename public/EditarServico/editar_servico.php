<?php
session_start();

if( empty($_SESSION['idUsuario'] || empty($_POST['serviceID'])) ){
    header('Location: ../Home/home.php');
}
if($_SESSION['classificacao'] == 0){
    header('Location: ../Home/home.php');
}

require_once '../../logic/editar_servico_brain.php';


$editService = new editService($_POST['serviceID']);

$serviceIsMine = $editService->verifySelfService(); // verifica se o servico eh dele mesmo
if(!$serviceIsMine){
    header('Location: ../EncontrarProfissional/VisualizarServico/visuaizarServico.php?serviceID='.$_POST['serviceID']);
    die();
}

$serviceData = $editService->getServiceData(); // verifica se o servico eh dele mesmo, e retorna o dados
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tá por aqui - Editar serviço</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/global/globalStyles.css">
    <link rel="stylesheet" href="./editar_servico.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="../../assets/jQueyMask/jquery.mask.js" defer></script>
    <script src="https://kit.fontawesome.com/2a19bde8ca.js" crossorigin="anonymous" defer></script>
    <script src="../../assets/global/globalScripts.js" defer></script>
    <script src="./editar_servico.js" defer></script>
    <script defer>
        let idCategoria = <?=$serviceData['serviceData']['categoria_mestre']?>;
        let serviceId = <?=$_POST['serviceID']?>;

        $.ajax({
            url: 'subcategorias/subcategorias.php',
            method: 'post',
            data: {
                requested_category: idCategoria,
                currentServiceCategory: idCategoria,
                serviceId: serviceId
            },
            success: data => {
                document.getElementById('categoriesModalContent').innerHTML = data

                //etapa 3 --> categoria do serviço
                document.getElementById('cardServiceCategory').innerHTML = ""

                $('.checkCategory:checked').each( (index, checkbox) => {
                    if ( $('.checkCategory:checked').length - 1 === index ){
                        //sem vírgula no fim
                        document.getElementById('cardServiceCategory').innerHTML += $(`label[for="subcategoria${checkbox.value}"]`)[0].innerText
                    } else {
                        //com vírgula no fim
                        document.getElementById('cardServiceCategory').innerHTML += $(`label[for="subcategoria${checkbox.value}"]`)[0].innerText + ", "
                    }
                } )
            }
        })
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
                    <a href="../ComoFunciona/comoFunciona.php" class="nav-link">Sobre</a>
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
                        <a class="dropdown-item text-danger" href="../../../logic/entrar_logoff.php">Sair</a>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</nav>
<!--NavBar Fim-->

<div id="page">
    <div class="container">
        <?php if(isset($_GET['erro'])) { ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <?= $_GET['erro'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>
        <form enctype="multipart/form-data" action="../../logic/editar_servico_enviar.php" method="POST" id="serviceForm">

            <input type="hidden" name="serviceId" value="<?=$_POST['serviceID']?>">

            <!-- 1. Etapa de criação do serviço -->
            <div class="row stageContent">
                <!-- info -->
                <section class="col-md-4">
                    <div class="row d-flex">
                        <div class="col-3">
                            <span class="big_number">1</span>
                        </div>
                        <div class="col-9 align-self-center">
                            <h6>Etapa de criação de serviço</h6>
                            <p>Insira as respectivas informações que serão apresentadas para os usuários e clientes da página </p>
                        </div>
                    </div>
                </section>

                <!-- Form -->
                <section class="col-md-6 ml-5 d-flex align-items-center p-0">
                    <div class="formItems">
                        <label for="nome">Nome do serviço</label> <br>
                        <input type="text" class="form-control required" name="nome" id="nome" placeholder="ex.: encanamento" onchange="createConfirmCard(1)" maxlength="60" value="<?php echo $serviceData['serviceData']['nome_servico']?>">
                    </div>
                </section>
            </div>
            <!--FIM 1. Etapa de criação do serviço -->

            <hr class="horizontalLine  d-md-none">

            <!-- 2. Etapa de criterização do serviço -->
            <div class="row stageContent">
                <!-- info -->
                <section class="col-md-4">
                    <div class="row d-flex">
                        <div class="col-3">
                            <span class="big_number">2</span>
                        </div>
                        <div class="col-9 align-self-center">
                            <h6>Etapa de criterização do serviço</h6>
                            <p> É necessário que você deixe claro a que tipo de categoria o seu serviço está relacionado. </p>
                        </div>
                    </div>
                </section>

                <!-- Form -->
                <section class="col-md-6 ml-5 d-flex align-items-center p-0">
                    <div class="formItems">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="tipo">Tipo de serviço</label> <br>
                                <select name="tipo" id="tipo" class="form-select required" data-bs-placement="top" data-bs-toggle="popover" data-bs-trigger="hover" title="Nota" data-bs-content="Caso o serviço seja remoto, ele não dependerá da localização do usuário para aparecer nas buscas" onchange="createConfirmCard(2)">
                                    <option value="">Selecionar</option>
                                    <option <?php if($serviceData['serviceData']['tipo_servico'] == 0){echo "selected";}?> value="0">Remoto</option>
                                    <option <?php if($serviceData['serviceData']['tipo_servico'] == 1){echo "selected";}?> value="1">Presencial</option>
                                </select>
                            </div>

                            <div class="col-md-6 mt-4 mt-md-0">
                                <label for="categorias">Categorias do serviço</label>
                                <button type="button" class="btn btn-primary w-100" id="categorias" data-bs-toggle="modal" data-bs-target="#categoriesModal">Escolha a categoria</button>

                                <small class="text-light">Clique no botão, escolha uma área de atuação e selecione até 3 categorias que condizem com seu serviço.</small>
                            </div>
                        </div>
                        <br>
                        <label for="descricao">Descrição</label> <br>
                        <textarea class="form-control required" name="descricao" id="descricao" rows="6" placeholder="Escreva aqui os detalhes do seu serviço, como por exemplo como ele é feito, quanto tempo leva aproximadamente, que materiais serão usados, no que ele ajuda o seu cliente, qual seu critério de cobrança, entre outras coisas que você achar relevante" onchange="createConfirmCard(4)" maxlength="65535"><?php echo $serviceData['serviceData']['desc_servico']?></textarea>
                    </div>
                </section>

                <div class="modal fade" id="categoriesModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content" id="categoriesModalContent">
                            <!-- Conteúdo carregado dinamicamente -->
                        </div>
                    </div>
                </div>

                <div class="verticalLine"></div>

            </div>
            <!--FIM 2. Etapa de criterização do serviço -->

            <hr class="horizontalLine  d-md-none">

            <!-- 3. Etapa de monetização do serviço -->
            <div class="row stageContent">
                <!-- info -->
                <section class="col-md-4">
                    <div class="row d-flex">
                        <div class="col-3">
                            <span class="big_number">3</span>
                        </div>
                        <div class="col-9 align-self-center">
                            <h6>Etapa de monetização do serviço</h6>
                            <p> Aqui se trata da escolha de pagamento e negociação que o cliente irá ver. Escolha a forma mais adequada ao seu tipo de serviço e negócio </p>
                        </div>
                    </div>
                </section>

                <!-- Form -->
                <section class="col-md-6 ml-5 d-flex align-items-center p-0">
                    <div class="formItems">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="tipoPagamento">Defina o tipo orçamento</label> <br>
                                <select class="form-select required" name="tipoPagamento" id="tipoPagamento" onchange="toggleOrcamentoComMedia(this.value); createConfirmCard(5)">
                                    <option value="">Selecione um orçamento</option>
                                    <option <?php if(!isset($serviceData['serviceData']['orcamento_servico'])){echo "selected";}?> value="1">Orçamento</option>
                                    <option <?php if(isset($serviceData['serviceData']['orcamento_servico'])){echo "selected";}?> value="2">Orçamento com média</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row <?php if(isset($serviceData['serviceData']['orcamento_servico'])){echo "d-flex";}else{echo "d-none";} ?>" id="divOrcamentoComMedia">
                            <div class="col-6" id="divOrcamento">
                                <label for="orcamento">Defina o valor</label> <br>
                                <input type='number' class='form-control' name='orcamento' id='orcamento' onchange="createConfirmCard(6)" maxlength="20" value="<?php if(isset($serviceData['serviceData']['orcamento_servico'])){echo $serviceData['serviceData']['orcamento_servico'];} ?>">
                            </div>

                            <div class='col-6' id='divCriterio'>
                                <label for='criterio'>Defina o critério</label>
                                <input type="text" class="form-control" name="criterio" id="criterio" list="listaCriterios" onchange="createConfirmCard(6)" maxlength="25" value="<?php if($serviceData['serviceData']['crit_orcamento_servico'] !== 'A definir orçamento'){echo $serviceData['serviceData']['crit_orcamento_servico'];} ?>">
                                <datalist id="listaCriterios">
                                    <option value="por hora">
                                    <option value="por m²">
                                    <option value="por quilo">
                                    <option value="por cabeça">
                                    <option value="por quantidade">
                                </datalist>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <!--FIM 3. Etapa de monetização do serviço -->

            <hr class="horizontalLine  d-md-none">

            <!-- 4. Etapa de definição de imagens do projeto -->
            <div class="row stageContent">
                <!-- info -->
                <section class="col-md-4">
                    <div class="row d-flex">
                        <div class="col-3">
                            <span class="big_number">4</span>
                        </div>
                        <div class="col-9 align-self-center">
                            <h6>Etapa de definição de imagens</h6>
                            <p> Fotografe e selecione fotos de sua galeria que mostre seu projeto em ação, seus materiais, resultados, etc. </p>
                        </div>
                    </div>
                </section>

                <!-- Form -->
                <section class="col-md-6 ml-5 d-flex align-items-center p-0">
                    <div class="formItems">
                        <label for="imagens[]" id="selectNewImagesMsg">Selecione, no máximo, mais <?=4 - count($serviceData['serviceIMG'])?> <?=4 - count($serviceData['serviceIMG']) === 1 ? 'imagem' : 'imagens'?></label> <br>
                        <label for="imagens[]" class="fakeInputFile">Enviar arquivos <i class="fas fa-upload"></i></label>
                        <input type="file" class="d-none" name="imagens[]" id="imagens[]" aria-describedby="icon" multiple accept="image/png, image/jpeg, image/jpg" onchange="verifyImage(this);">
                        <span class="text-danger" id="imageErrorMsg"></span>

                        <!-- exibir preview das imagens -->
                        <h4 class="text-info d-none mt-4" id="obsImgPreview">Imagens novas</h4>
                        <div id="divImgPreview">

                        </div>

                        <div style="clear: both"></div>

                        <!-- botão de excluir imagens novas -->
                        <button type="button" class="btn btn-danger d-none" id="deleteImages" onclick="removePreviewImages()"> <i class="fas fa-trash"></i> Excluir imagens </button>

                        <h4 class="text-info mt-4" id="obsOriginalImgPreview">Imagens atuais</h4>
                        <div id="divOriginalImgPreview">
                            <?php foreach ($serviceData['serviceIMG'] as $img) {?>
                                <div class="btnImage" id="originalImg<?=$img['id_imagem']?>">
                                    <img class="originalImgPreview" src="../../assets/images/users/<?=$img['dir_servico_imagem']?>" alt="nova imagem do serviço">
                                    <button type="button" class="btn btn-danger deleteBtn" onclick="deleteOriginalImg('<?=$img['id_imagem']?>')"><i class="fas fa-minus"></i></button>
                                    <input type="hidden" class="originalImgInput" name="oldImages[][id_imagem]" value="<?=$img['id_imagem']?>">
                                </div>
                            <?php }?>
                        </div>

                        <div style="clear: both"></div>

                    </div>
                </section>
            </div>
            <!--FIM 4. Etapa de definição de imagens do projeto -->

            <hr class="horizontalLine d-md-none">

            <!-- 5. Revisão e finalização -->
            <div class="row">
                <!-- info -->
                <section class="col-md-4">
                    <div class="row d-flex">
                        <div class="col-3">
                            <span class="big_number">5</span>
                        </div>
                        <div class="col-9 align-self-center">
                            <h6>Revisão e finalização</h6>
                            <p>Não esqueça de verificar tudo e confirme</p>
                        </div>
                    </div>
                </section>

                <!-- Div -->
                <section class="col-md-6 ml-5 d-flex align-items-center p-0">
                    <div class="formItems">

                        <div class="card" id="revisionCard">
                            <h5 class="card-header">Serviço</h5>
                            <div class="card-body">
                                <h5 class="card-title" id="cardServiceName"></h5>
                                <p class="card-text text-dark">
                                    <strong>Tipo: </strong> <span id="cardServiceType"></span> <br>
                                    <strong>Categorias: </strong> <span id="cardServiceCategory"></span> <br>
                                    <strong>Descrição: </strong> <label id="cardServiceDescription" class="m-0 p-0 text-dark my-2"></label> <br>
                                    <strong>Pagamento: </strong> <span id="cardServicePayment"></span> <br>
                                </p>
                                <button type="button" class="myBtn myBtnGreen mb-3" id="confirmService" onclick="createServiceValidation()">Editar serviço</button> <br>
                                <button type="button" class="myBtn myBtnRed" id="cancelService" onclick="confirm('Você tem certeza que deseja sair? As informações trocadas do serviço não serão salvas') ? location.href = '../EncontrarProfissional/VisualizarServico/visuaizarServico.php?serviceID=<?=$_POST['serviceID']?>' : '#';">Cancelar edição</button> <br>
                                <strong class="text-danger" id="createServiceErrorMsg"></strong>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <!--FIM 5. Revisão e finalização -->

        </form>
    </div>
</div>

<!-- footer -->
<footer id="myMainFooter">
    <div id="myMainFooterContainer" class="container-fluid">
        <div class="my-main-footer-logo">
            <img src="../../assets/images/dumb-footer.png" alt="Tá por Aqui" class="my-footer-img">
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
</footer>
<!-- /footer -->
</body>

</html>