<?php
require "../assets/getData.php";

session_start();
if (empty($_SESSION['idAdm']) || empty($_SESSION['emailAdm']) || empty($_SESSION['senhaAdm'])){
    header('location:../index.php');
    exit();
}

$serviceReport = new ServiceReport($_GET['id']);

$banMsg = "";
if (isset($_POST['changeServiceStatus']) && $_POST['changeServiceStatus'] == "ban"){
    $banMsg = $serviceReport->banThisService();
} else if (isset($_POST['changeServiceStatus']) && $_POST['changeServiceStatus'] == "unban"){
    $banMsg = $serviceReport->unbunThisService();
}

$changeComplainMsg = "";
if (isset($_POST['changeComplainStatus'])){
    $changeComplainMsg = $serviceReport->changeComplainStatus(intval($_POST['changeComplainStatus']), intval($_POST['complainId']));
}

$serviceInfo = $serviceReport->getServiceInfo();
$serviceMasterCategory = $serviceReport->getServiceMasterCategory();
$serviceSubCategories = $serviceReport->getServiceSubCategories();
$serviceComplain = $serviceReport->getComplainsToThisService();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tá por aqui - Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/2a19bde8ca.js" crossorigin="anonymous" defer></script>
    <script src="../assets/chart.js/chart.js"></script>
    <script src="../script.js" defer></script>

    <script>
        //remover transição do collapse quando a página carrega e devolve-la quando clicado
        $(document).ready(() => {
            let bsGerenciamentoServicos = new bootstrap.Collapse(document.getElementById('gerenciamentoServicos'))
            bsGerenciamentoServicos.show()
            $('#gerenciamentoServicos').removeClass('collapsing')
            $('#gerenciamentoServicos').on("click", () => {
                $('#gerenciamentoServicos').addClass('collapsing')
            })

            $('.listDiv').on('click', ()=>{
                location.href = "service.php"
            })
        })
    </script>
</head>

<body>

<!-- menu -->
<div class="nav-side-menu">
    <div class="brand py-2"><img src="../../assets/images/dumb-brand.png" alt="logo"></div>
    <i class="fa fa-bars fa-2x toggle-btn" data-bs-toggle="collapse" data-bs-target="#menu-content"></i>

    <div class="menu-list">

        <ul id="menu-content" class="menu-content collapse out">
            <li>
                <a href="../analisys.php"><i class="fas fa-chart-bar sidebar-icon"></i> Estatísticas do site</a>
            </li>

            <li data-bs-toggle="collapse" data-bs-target="#gerenciamentoUsuarios" class="collapsed">
                <div class="moreItems"><i class="fas fa-users sidebar-icon"></i> Gerenciamento usuários <span class="arrow"><i class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="gerenciamentoUsuarios">
                <li><a href="../userManagement/userReport.php"><i class="fa fa-angle-right"></i> Relatório de usuários</a></li>
                <li><a href="../userManagement/commentComplaint.php"><i class="fa fa-angle-right"></i> Denúncias de comentários</a></li>
                <li><a href="../userManagement/contactReport.php"><i class="fa fa-angle-right"></i> Fale conosco</a></li>
            </ul>

            <li data-bs-toggle="collapse" data-bs-target="#gerenciamentoServicos" class="collapsed active">
                <div class="moreItems"><i class="fas fa-people-carry sidebar-icon"></i> Gerenciamento serviços <span class="arrow"><i class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="gerenciamentoServicos">
                <li class="active"><a href="serviceReport.php"><i class="fa fa-angle-right"></i> Relatório de serviços</a></li>
            </ul>

            <li data-bs-toggle="collapse" data-bs-target="#appControl" class="collapsed">
                <div class="moreItems"><i class="fas fa-cog sidebar-icon"></i> Controle do app <span class="arrow"><i class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="appControl">
                <li><a href="../appControl/addCategory.php"><i class="fa fa-angle-right"></i> Adicionar categorias</a></li>
                <li><a href="../appControl/addComplainReason.php"><i class="fa fa-angle-right"></i> Adicionar denúncias motivos</a></li>
                <li><a href="../appControl/addExitReason.php"><i class="fa fa-angle-right"></i> Adicionar saída motivos</a></li>
            </ul>
        </ul>
    </div>
</div>

<!-- paginas -->
<div class="main" id="pagina">
    <h1>Relatório de serviços - <?=$serviceInfo['nome_servico']?></h1>

    <a href="serviceReport.php"> <i class="fas fa-arrow-left"></i> voltar </a>

    <?php if ($banMsg !== "") { ?>
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert" style="max-width: 500px">
            <span><?=$banMsg?></span>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
    <?php }?>

    <?php if ($changeComplainMsg !== "") { ?>
        <div class="alert alert-info alert-dismissible fade show mt-3" role="alert" style="max-width: 500px">
            <span><?=$changeComplainMsg?></span>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
    <?php }?>

    <table class="table table-hover mt-3" style="max-width: 900px">
        <thead class="thead-dark">
        <tr>
            <th colspan="2" class="text-center">Informações gerais do serviço</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th>Id do serviço:</th>
            <td><?=$_GET['id']?></td>
        </tr>
        <tr>
            <th>Nome:</th>
            <td><?=$serviceInfo['nome_servico']?></td>
        </tr>
        <tr>
            <th>Prestador:</th>
            <td><?=$serviceInfo['nome_usuario']?> <?=$serviceInfo['sobrenome_usuario']?> (id <?=$serviceInfo['id_prestador_servico']?>)</td>
        </tr>
        <tr>
            <th>Categoria mestre:</th>
            <td><?=$serviceMasterCategory['nome_categoria']?> id (<?=$serviceMasterCategory['id_categoria']?>)</td>
        </tr>
        <tr>
            <th>Subcategorias:</th>
            <td>
                <?php foreach ($serviceSubCategories as $subCategory) {

                    echo $subCategory['nome_subcategoria'] . " (" . $subCategory['id_subcategoria'] . ") - ";
                }?>
            </td>
        </tr>
        <tr>
            <th>Tipo de serviço:</th>
            <td><?=$serviceInfo['tipo_servico'] == 1? "presencial" : "remoto"?></td>
        </tr>
        <tr>
            <th>Descrição:</th>
            <td><?=$serviceInfo['desc_servico']?></td>
        </tr>
        <tr>
            <th>Preço:</th>
            <td>
                <?php if($serviceInfo['orcamento_servico'] == ""){
                    echo "A definir orçamento";
                } else {
                    echo "R$ " . $serviceInfo['orcamento_servico'] . " " . $serviceInfo['crit_orcamento_servico'];
                }?>
            </td>
        </tr>
        <tr>
            <th>Nota média:</th>
            <td><?=$serviceInfo['nota_media_servico']?>/5.0</td>
        </tr>
        <tr>
            <th>Contratos:</th>
            <td><?=$serviceReport->getQntContracts()?></td>
        </tr>
        <tr>
            <th>Status:</th>
            <td>
                <?php
                switch ($serviceInfo['status_servico']){
                    case 0:
                        echo "<span class='text-secondary'>Serviço Suspenso</span>";
                        break;
                    case 1:
                        echo "<span class='text-success'>Serviço Ativo</span>";
                        break;
                    case 2:
                        echo "<span class='text-danger'>Serviço Banido</span>";
                        break;
                    case 3:
                        echo "<span class='text-secondary'>Serviço ocultado pelo usuário</span>";
                        break;
                }
                ?>
            </td>
        </tr>
        <tr>
            <th>Quantidade de denúncias:</th>
            <td><?=$serviceReport->getQntComplains()?></td>
        </tr>
        </tbody>
    </table>

    <?php if ($serviceInfo['status_servico'] == 1) {?>
        <form action="service.php?id=<?=$_GET['id']?>" method="post">
            <input type="hidden" name="changeServiceStatus" value="ban">
            <button type="submit" class="btn btn-danger btn-lg mt-3">Banir serviço</button>
        </form>
    <?php } else if ($serviceInfo['status_servico'] == 2){?>
        <form action="service.php?id=<?=$_GET['id']?>" method="post">
            <input type="hidden" name="changeServiceStatus" value="unban">
            <button type="submit" class="btn btn-danger btn-lg mt-3">Desbanir serviço</button>
        </form>
    <?php }?>

    <hr>

    <button type="button" class="btn btn-primary d-block" data-bs-toggle="collapse" data-bs-target="#complains"
            aria-expanded="false" aria-controls="complains">Listar denúncias desse serviço
    </button>

    <div class="collapse mt-3" id="complains">
        <div class="row">
            <?php foreach ($serviceComplain as $complain) {?>
                <div class="col-md-4 mt-md-0 mt-3">
                    <table class="table table-hover table-sm mt-3">
                        <thead class="table-danger">
                        <tr>
                            <th colspan="2" class="text-center">Detalhes da denúncia</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th>Id da denúncia:</th>
                            <td><?=$complain['id_denuncia_servico']?></td>
                        </tr>
                        <tr>
                            <th>Usuário que denunciou</th>
                            <td><?=$complain['nome_usuario']?> <?=$complain['sobrenome_usuario']?> (id <?=$complain['id_usuario']?>)</td>
                        </tr>
                        <tr>
                            <th>Motivo:</th>
                            <td><?=$complain['denuncia_motivo']?></td>
                        </tr>
                        <tr>
                            <th>Descrição</th>
                            <td><?=$complain['desc_denuncia_serv']?></td>
                        </tr>
                        <tr>
                            <th>Data:</th>
                            <?php
                            $data_denuncia = new DateTime($complain['data_denuncia_serv']);
                            ?>
                            <td><?=$data_denuncia->format('d/m/Y')?></td>
                        </tr>
                        <tr>
                            <th>status:</th>
                            <td><?=$complain['status_denuncia_serv'] == 0 ? "Não resolvido" : "em análise"?></td>
                        </tr>
                        <tr>
                            <th>Marcar como:</th>
                            <td>
                                <?php if ($complain['status_denuncia_serv'] != 1) {?>
                                    <form action="service.php?id=<?=$_GET['id']?>" method="post" class="d-inline">
                                        <input type="hidden" name="changeComplainStatus" value="1">
                                        <input type="hidden" name="complainId" value="<?=$complain['id_denuncia_servico']?>">
                                        <button type="submit" class="btn btn-secondary btn-sm">Em análise</button> |
                                    </form>
                                <?php }?>
                                <form action="service.php?id=<?=$_GET['id']?>" method="post" class="d-inline">
                                    <input type="hidden" name="changeComplainStatus" value="2">
                                    <input type="hidden" name="complainId" value="<?=$complain['id_denuncia_servico']?>">
                                    <button type="submit" class="btn btn-success btn-sm">Resolvido</button>
                                </form>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            <?php }
            if (count($serviceComplain) === 0){
                echo "<span class='text-info'>Não há denúncias para esse Serviço</span>";
            }
            ?>
        </div>
    </div>
</div>

</body>

</html>