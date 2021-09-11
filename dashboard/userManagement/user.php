<?php
require "../assets/getData.php";
$userReport = new UserReport($_GET['id']);

$banMsg = "";
if (isset($_POST['changeUserStatus']) && $_POST['changeUserStatus'] == "ban"){
    $banMsg = $userReport->banThisUser();
} else if (isset($_POST['changeUserStatus']) && $_POST['changeUserStatus'] == "unban"){
    $banMsg = $userReport->unbanThisUser();
}

$userInfo = $userReport->getUserInfo();
$userComments = $userReport->getUserComments();
$userServices = $userReport->getUserServices();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tá por aqui - Dashboard</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/bootstrap/bootstrap-4.5.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../style.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="../../assets/bootstrap/popper.min.js" defer></script>
    <script src="../../assets/bootstrap/bootstrap-4.5.3-dist/js/bootstrap.min.js" defer></script>

    <script src="../script.js" defer></script>

    <script>
        //remover transição do collapse quando a página carrega e devolve-la quando clicado
        $(document).ready(() => {
            $('#gerenciamentoUsuarios').collapse('show')
            $('#gerenciamentoUsuarios').removeClass('collapsing')
            $('#gerenciamentoUsuarios').on("click", () => {
                $('#gerenciamentoUsuarios').addClass('collapsing')
            })
        })

        function redirecionaPagina(pag, param){
            location.href = `${pag}?id=${param}`
        }
    </script>
</head>

<body>

<!-- menu -->
<div class="nav-side-menu">
    <div class="brand py-2"><img src="../../assets/images/dumb-brand.png" alt="logo"></div>
    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

    <div class="menu-list">

        <ul id="menu-content" class="menu-content collapse out">
            <li>
                <a href="../index.php"><i class="fas fa-chart-bar sidebar-icon"></i> Estatísticas do site</a>
            </li>

            <li data-toggle="collapse" data-target="#gerenciamentoUsuarios" class="collapsed active">
                <div class="moreItems"><i class="fas fa-users sidebar-icon"></i> Gerenciamento usuários <span
                            class="arrow"><i class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="gerenciamentoUsuarios">
                <li class="active"><a href="userReport.php"><i class="fa fa-angle-right"></i> Relatório de usuários</a>
                </li>
                <li><a href="commentComplaint.php"><i class="fa fa-angle-right"></i> Denúncias de comentários</a></li>
                <li><a href="contactReport.php"><i class="fa fa-angle-right"></i> Fale conosco</a></li>
            </ul>

            <li data-toggle="collapse" data-target="#gerenciamentoServicos" class="collapsed">
                <div class="moreItems"><i class="fas fa-people-carry sidebar-icon"></i> Gerenciamento serviços <span
                            class="arrow"><i class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="gerenciamentoServicos">
                <li><a href="../serviceManagement/serviceReport.php"><i class="fa fa-angle-right"></i> Relatório de
                        serviços</a></li>
            </ul>

            <li data-toggle="collapse" data-target="#appControl" class="collapsed">
                <div class="moreItems"><i class="fas fa-cog sidebar-icon"></i> Controle do app <span class="arrow"><i
                                class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="appControl">
                <li><a href="../appControl/addCategory.php"><i class="fa fa-angle-right"></i> Adicionar categorias</a>
                </li>
            </ul>
        </ul>
    </div>
</div>

<!-- paginas -->
<div class="main" id="pagina">
    <h2>Relatório de usuários - Natan Barbosa (3)</h2>
    <a href="userReport.php"> <i class="fas fa-arrow-left"></i> voltar </a> <br>

    <?php if ($banMsg !== "") { ?>
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert" style="max-width: 500px">
            <span><?=$banMsg?></span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php }?>

    <div class="row mt-5">
        <div class="col-md-6">
            <table class="table table-hover">
                <thead class="thead-dark">
                <tr>
                    <th colspan="2" class="text-center">Informações importantes do usuário</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="2"><img src="../../assets/images/users/<?=$userInfo['imagem_usuario']?>" alt="imagem do usuário"
                                         class="userPicture"></td>
                </tr>
                <tr>
                    <th>Id do usuário:</th>
                    <td><?=$userInfo['id_usuario']?></td>
                </tr>
                <tr>
                    <th>Nome:</th>
                    <td><?=$userInfo['nome_usuario']?> <?=$userInfo['sobrenome_usuario']?></td>
                </tr>
                <tr>
                    <th>Email cadastrado:</th>
                    <td><?=$userInfo['email_usuario']?></td>
                </tr>
                <tr>
                    <th>Senha:</th>
                    <td><?=$userInfo['senha_usuario']?></td>
                </tr>
                <tr>
                    <th>Classificação:</th>
                    <?php
                    $class = "";
                    switch ($userInfo['classif_usuario']){
                        case 0:
                            $class = "Cliente";
                            break;
                        case 1:
                            $class = "Prestador";
                            break;
                        case 2:
                            $class = "Pequeno Negócio";
                            break;
                    }
                    ?>
                    <td><?=$class?></td>
                </tr>
                <tr>
                    <th>Nota média:</th>
                    <td><?=$userInfo['nota_media_usuario']?>/5.0</td>
                </tr>
                <tr>
                    <th>Status:</th>
                    <?php
                    $status = "";
                    switch ($userInfo['status_usuario']){
                        case 0:
                            $status = "Suspenso";
                            break;
                        case 1:
                            $status = "Ativo";
                            break;
                        case 2:
                            $status = "Banido";
                            break;
                    }
                    ?>
                    <td><?=$status?></td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="col-md-6 mt-3 mt-md-0">
            <table class="table table-hover">
                <thead class="thead-dark">
                <tr>
                    <th colspan="2" class="text-center">Outras informações do usuário</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th>Telefone de contato:</th>
                    <td><?=$userInfo['fone_usuario']?></td>
                </tr>
                <tr>
                    <th>Data de nascimento:</th>
                    <?php
                    $data_nasc = new DateTime($userInfo['data_nasc_usuario']);
                    ?>
                    <td><?=$data_nasc->format('d/m/Y')?></td>
                </tr>
                <tr>
                    <th>Sexo:</th>
                    <td><?=$userInfo['sexo_usuario']?></td>
                </tr>
                <tr>
                    <th>Localização:</th>
                    <td><?=$userInfo['uf_usuario']?>, <?=$userInfo['cidade_usuario']?></td>
                </tr>
                <tr>
                    <th>Classificação:</th>
                    <td><?php echo $userInfo['classif_usuario'] === 0 ? "Cliente" : "Prestador"?></td>
                </tr>
                <tr>
                    <th>Data de cadastro:</th>
                    <?php
                    $data_nasc = new DateTime($userInfo['data_entrada_usuario']);
                    ?>
                    <td><?=$data_nasc->format('d/m/Y')?></td>
                </tr>
                <tr>
                    <th>Site inserido:</th>
                    <td><a href="www.kekw.com"><?=$userInfo['site_usuario']?></a></td>
                </tr>
                <tr>
                    <th>Descrição inserida:</th>
                    <td>
                        <?=$userInfo['desc_usuario']?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <?php if ($userInfo['status_usuario'] == 1) {?>
        <form action="user.php?id=<?=$_GET['id']?>" method="post">
            <input type="hidden" name="changeUserStatus" value="ban">
            <button type="submit" class="btn btn-danger btn-lg mt-3">Banir usuário</button>
        </form>
    <?php } else if ($userInfo['status_usuario'] == 2){?>
        <form action="user.php?id=<?=$_GET['id']?>" method="post">
            <input type="hidden" name="changeUserStatus" value="unban">
            <button type="submit" class="btn btn-danger btn-lg mt-3">Desbanir usuário</button>
        </form>
    <?php }?>

    <hr>

    <h4>Ações</h4>
    <button type="button" class="btn btn-primary d-block" data-toggle="collapse" data-target="#userComments"
            aria-expanded="false" aria-controls="userComments">Listar comentários do usuário
    </button>
    <div class="collapse mt-3" id="userComments">
        <?php foreach ($userComments as $comment) {?>
            <div class="row my-2">
                <div class="col-md-12 col-lg-10">
                    <div class="listDiv commentDiv row my-3" onclick="redirecionaPagina('comment.php', 1)">
                        <div class="col-sm-2 mb-3 mb-sm-0">
                            <div class="text-center">Id comentário:</div>
                            <div class="text-center font-weight-bold"><?=$comment['id_comentario']?></div>
                        </div>
                        <div class="col-sm-3 mb-3 mb-sm-0">
                            <div>Feito no serviço</div>
                            <div class="font-weight-bold"><?=$comment['nome_servico']?> (id <?=$comment['id_servico']?>)</div>
                        </div>
                        <div class="col-sm-4 mb-3 mb-sm-0">
                            <div>Comentário</div>
                            <div class="font-weight-bold allowTextOverflow"><?=$comment['desc_comentario']?></div>
                        </div>
                        <div class="col-sm-3 mb-3 mb-sm-0">
                            <div>Quantidade de denúncias</div>
                            <div class="font-weight-bold text-center"><?php echo $userReport->getComComplains($comment['id_comentario'])?></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
        echo count($userComments) === 0 ? "Esse usuário não fez nenhum comentário" : "";
        ?>
    </div>

    <button type="button" class="btn btn-secondary d-block mt-4" data-toggle="collapse" data-target="#userServices"
            aria-expanded="false" aria-controls="userServices">Listar serviços do usuário
    </button>
    <div class="collapse mt-3" id="userServices">
        <div class="row my-2">
            <?php foreach ($userServices as $service) {?>
                <div class="col-md-12 col-lg-10">
                    <div class="listDiv row my-3" onclick="redirecionaPagina('../serviceManagement/service.php', <?=$service['id_servico']?>)">
                        <div class="col-sm-1 mr-2 mb-3 mb-sm-0">
                            <img src="../../assets/images/dumb-brand.png" alt="imagem do serviço" class="userPicture">
                        </div>
                        <div class="col-sm-3 mb-3 mb-sm-0">
                            <span><?=$service['nome_servico']?> (id <?=$service['id_servico']?>)</span> <br>
                            <span class="text-secondary"><?=$service['nome_usuario']?> (id <?=$service['id_prestador_servico']?>)</span>
                        </div>
                        <div class="col-sm-4 mb-3 mb-sm-0">
                            <span><?=$service['tipo_servico'] == 1? "Remoto" : "Presencial"?></span> <br>
                            <span class="text-secondary">nota média: <?=$service['nota_media_servico']?>/5</span>
                        </div>
                        <div class="col-sm-3 mb-3 mb-sm-0">
                            <?php
                            $status = "";
                            switch ($service['status_servico']){
                                case 0:
                                    $status = "<span class='text-secondary'>Serviço suspenso</span>";
                                    break;
                                case 1:
                                    $status = "<span class='text-success'>Serviço ativo</span>";
                                    break;
                                case 2:
                                    $status = "<span class='text-danger'>Serviço banido</span>";
                                    break;
                            }
                            echo $status
                            ?> <br>
                            <span>Denúncias: <?= $userReport->getServComplains($service['id_servico'])?></span>
                        </div>
                    </div>
                </div>
            <?php }
            echo count($userServices) === 0 ? "Esse usuário não tem nenhum serviço" : "";
            ?>
        </div>
    </div>
</div>

</body>

</html>