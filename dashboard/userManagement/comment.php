<?php
require "../assets/getData.php";
$commentReport = new CommentReport($_GET['id']);

$banMsg = "";
if (isset($_POST['changeCommentStatus']) && $_POST['changeCommentStatus'] == "ban"){
    $banMsg = $commentReport->banThisComment();
} else if (isset($_POST['changeCommentStatus']) && $_POST['changeCommentStatus'] == "unban"){
    $banMsg = $commentReport->unbunThisComment();
}
$changeComplainMsg = "";
if (isset($_POST['changeComplainStatus'])){
    $changeComplainMsg = $commentReport->changeComplainStatus(intval($_POST['changeComplainStatus']), intval($_POST['complainId']));
} else if (isset($_POST['changeComplainStatus']) && $_POST['changeComplainStatus'] == "resolve"){
    $changeComplainMsg = $commentReport->changeComplainStatus(intval($_POST['changeComplainStatus']), intval($_POST['complainId']));
}

$commentInfo = $commentReport->getCommentInfo();
$commentComplains = $commentReport->getConplainsToThisComment();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tá por aqui - Dashboard</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/bootstrap/bootstrap-4.5.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../style.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
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

            $('.listDiv').on('click', ()=>{
                location.href = "comment.php"
            })
        })
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

            </li>

            <li data-toggle="collapse" data-target="#gerenciamentoUsuarios" class="collapsed active">
                <div class="moreItems"><i class="fas fa-users sidebar-icon"></i> Gerenciamento usuários <span class="arrow"><i class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="gerenciamentoUsuarios">
                <li><a href="userReport.php"><i class="fa fa-angle-right"></i> Relatório de usuários</a></li>
                <li class="active"><a href="commentComplaint.php"><i class="fa fa-angle-right"></i> Denúncias de comentários</a></li>
                <li><a href="contactReport.php"><i class="fa fa-angle-right"></i> Fale conosco</a></li>
            </ul>

            <li data-toggle="collapse" data-target="#gerenciamentoServicos" class="collapsed">
                <div class="moreItems"><i class="fas fa-people-carry sidebar-icon"></i> Gerenciamento serviços <span class="arrow"><i class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="gerenciamentoServicos">
                <li><a href="../serviceManagement/serviceReport.php"><i class="fa fa-angle-right"></i> Relatório de serviços</a></li>
            </ul>

            <li data-toggle="collapse" data-target="#appControl" class="collapsed">
                <div class="moreItems"><i class="fas fa-cog sidebar-icon"></i> Controle do app <span class="arrow"><i class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="appControl">
                <li><a href="../appControl/addCategory.php"><i class="fa fa-angle-right"></i> Adicionar categorias</a></li>
            </ul>
        </ul>
    </div>
</div>

<!-- paginas -->
<div class="main" id="pagina">
    <h2>Denúncias de comentários - comentário do Natan (1)</h2>

    <a href="commentComplaint.php"> <i class="fas fa-arrow-left"></i> voltar </a>

    <?php if ($banMsg !== "") { ?>
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert" style="max-width: 500px">
            <span><?=$banMsg?></span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php }?>

    <?php if ($changeComplainMsg !== "") { ?>
        <div class="alert alert-info alert-dismissible fade show mt-3" role="alert" style="max-width: 500px">
            <span><?=$changeComplainMsg?></span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php }?>

    <table class="table table-hover mt-3" style="max-width: 900px">
        <thead class="thead-dark">
        <tr>
            <th colspan="2" class="text-center">Informações gerais do comentário</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th>Id do comentário:</th>
            <td><?=$_GET['id']?></td>
        </tr>
        <tr>
            <th>Usuário que comentou:</th>
            <td><?=$commentInfo['nome_usuario']?> <?=$commentInfo['sobrenome_usuario']?> (id<?=$commentInfo['id_usuario']?>) </td>
        </tr>
        <tr>
            <th>Serviço avaliado:</th>
            <td><?=$commentInfo['nome_servico']?> (id <?=$commentInfo['id_servico']?>)</td>
        </tr>
        <tr>
            <th>Nota da avaliação:</th>
            <td><?=$commentInfo['nota_comentario']?></td>
        </tr>
        <tr>
            <th>Data do comentário:</th>
            <?php
            $data_comen = new DateTime($commentInfo['data_comentario']);
            ?>
            <td><?=$data_comen->format('d/m/Y')?></td>
        </tr>
        <tr>
            <th>status:</th>
            <td><?=$commentInfo['status_comentario'] == 1 ? "exibido" : "ocultado"?></td>
        </tr>
        <tr>
            <th>Quantidade de denúncias:</th>
            <td><?=$commentReport->getComComplains($commentInfo['id_comentario'])?></td>
        </tr>
        <tr>
            <th>comentário:</th>
            <td><?=$commentInfo['desc_comentario']?></td>
        </tr>
        </tbody>
    </table>

    <?php if ($commentInfo['status_comentario'] == 1) {?>
        <form action="comment.php?id=<?=$_GET['id']?>" method="post">
            <input type="hidden" name="changeCommentStatus" value="ban">
            <button type="submit" class="btn btn-danger btn-lg mt-3">Banir comentário</button>
        </form>
    <?php } else if ($commentInfo['status_comentario'] == 0){?>
        <form action="comment.php?id=<?=$_GET['id']?>" method="post">
            <input type="hidden" name="changeCommentStatus" value="unban">
            <button type="submit" class="btn btn-danger btn-lg mt-3">Desbanir comentário</button>
        </form>
    <?php }?>

    <button type="button" class="btn btn-primary d-block mt-4" data-toggle="collapse" data-target="#complains"
            aria-expanded="false" aria-controls="complains">Listar denúncias desse comentário
    </button>

    <div class="collapse mt-3" id="complains">
        <div class="row">
            <?php foreach ($commentComplains as $complain) {?>
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
                            <td><?=$complain['id_denuncia_comentario']?></td>
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
                            <td><?=$complain['desc_denuncia_comen']?></td>
                        </tr>
                        <tr>
                            <th>Data:</th>
                            <?php
                            $data_denuncia = new DateTime($complain['data_denuncia_comen']);
                            ?>
                            <td><?=$data_denuncia->format('d/m/Y')?></td>
                        </tr>
                        <tr>
                            <th>status:</th>
                            <td><?=$complain['status_denuncia_comen'] == 0 ? "Não resolvido" : "em análise"?></td>
                        </tr>
                        <tr>
                            <th>Marcar como:</th>
                            <td>
                                <?php if ($complain['status_denuncia_comen'] != 1) {?>
                                    <form action="comment.php?id=<?=$_GET['id']?>" method="post" class="d-inline">
                                        <input type="hidden" name="changeComplainStatus" value="1">
                                        <input type="hidden" name="complainId" value="<?=$complain['id_denuncia_comentario']?>">
                                        <button type="submit" class="btn btn-secondary btn-sm">Em análise</button> |
                                    </form>
                                <?php }?>
                                <form action="comment.php?id=<?=$_GET['id']?>" method="post" class="d-inline">
                                    <input type="hidden" name="changeComplainStatus" value="2">
                                    <input type="hidden" name="complainId" value="<?=$complain['id_denuncia_comentario']?>">
                                    <button type="submit" class="btn btn-success btn-sm">Resolvido</button>
                                </form>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            <?php }
            if (count($commentComplains) === 0){
                echo "<span class='text-info'>Não há denúncias para esse comentário</span>";
            }
            ?>
        </div>
    </div>
</div>

</body>

</html>