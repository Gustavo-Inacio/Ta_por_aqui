<?php
require "../assets/getData.php";

session_start();
if (empty($_SESSION['idAdm']) || empty($_SESSION['emailAdm']) || empty($_SESSION['senhaAdm'])){
    header('location:../index.php');
    exit();
}

$contactReport = new ContactReport($_GET['id']);
$changeContactMsg = "";
if (isset($_POST['changeContactStatus'])){
    $changeContactMsg = $contactReport->changeContactStatus(intval($_POST['changeContactStatus']));
}

$contactInfo = $contactReport->getContactInfo();

$sendMailMsg = "";
if (isset($_POST['assunto']) && isset($_POST['msgAnterior']) && isset($_POST['msgResposta'])){
    $sendMailMsg = $contactReport->sendRespForUser($contactInfo['email_contato'], $_POST['assunto'], $_POST['msgAnterior'], $_POST['msgResposta']);
}
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
            let bsgGerenciamentoUsuarios = new bootstrap.Collapse(document.getElementById('gerenciamentoUsuarios'))
            bsgGerenciamentoUsuarios.show()
            $('#gerenciamentoUsuarios').removeClass('collapsing')
            $('#gerenciamentoUsuarios').on("click", () => {
                $('#gerenciamentoUsuarios').addClass('collapsing')
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

            <li data-bs-toggle="collapse" data-bs-target="#gerenciamentoUsuarios" class="collapsed active">
                <div class="moreItems"><i class="fas fa-users sidebar-icon"></i> Gerenciamento usuários <span class="arrow"><i class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="gerenciamentoUsuarios">
                <li><a href="userReport.php"><i class="fa fa-angle-right"></i> Relatório de usuários</a></li>
                <li><a href="commentComplaint.php"><i class="fa fa-angle-right"></i> Denúncias de comentários</a></li>
                <li class="active"><a href="contactReport.php"><i class="fa fa-angle-right"></i> Fale conosco</a></li>
            </ul>

            <li data-bs-toggle="collapse" data-bs-target="#gerenciamentoServicos" class="collapsed">
                <div class="moreItems"><i class="fas fa-people-carry sidebar-icon"></i> Gerenciamento serviços <span class="arrow"><i class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="gerenciamentoServicos">
                <li><a href="../serviceManagement/serviceReport.php"><i class="fa fa-angle-right"></i> Relatório de serviços</a></li>
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
    <h1>Fale conosco</h1>

    <a href="contactReport.php"> <i class="fas fa-arrow-left"></i> voltar </a>

    <?php if ($changeContactMsg !== "") { ?>
        <div class="alert alert-info alert-dismissible fade show mt-3" role="alert" style="max-width: 500px">
            <span><?=$changeContactMsg?></span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php }?>


    <?php if ($sendMailMsg !== "") { ?>
        <div class="alert alert-info alert-dismissible fade show mt-3" role="alert" style="max-width: 500px">
            <span><?=$sendMailMsg?></span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php }?>

    <table class="table table-hover mt-3" style="max-width: 900px">
        <thead class="thead-dark">
        <tr>
            <th colspan="2" class="text-center">Informações do contato</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th>Id do contato:</th>
            <td><?=$_GET['id']?></td>
        </tr>
        <tr>
            <th>Nome do usuário:</th>
            <td><?=$contactInfo['nome_contato']?></td>
        </tr>
        <tr>
            <th>Email:</th>
            <td><?=$contactInfo['email_contato']?></td>
        </tr>
        <tr>
            <th>Telefone:</th>
            <td><?=$contactInfo['fone_contato']?></td>
        </tr>
        <tr>
            <th>Data de envio:</th>
            <?php
            $data_envio = new DateTime($contactInfo['data_contato']);
            ?>
            <td><?=$data_envio->format('d/m/Y')?></td>
        </tr>
        <tr>
            <th>Motivo do contato:</th>
            <?php
            $motivo = "";
            switch ($contactInfo['motivo_contato']){
                case 1:
                    $motivo = "<span class='text-success'>Elogio</span>";
                    break;
                case 2:
                    $motivo = "<span class='text-info'>Sugestão</span>";
                    break;
                case 3:
                    $motivo = "<span class='text-danger'>Reclamação</span>";
                    break;
                case 4:
                    $motivo = "<span class='text-warning'>Problemas/bugs</span>";
                    break;
                case 5:
                    $motivo = "<span class='text-secondary'>Outro motivo</span>";
                    break;
                case 6:
                    $motivo = "<span class='text-danger'>Contestação de banimento</span>";
                    break;
            }
            ?>
            <td><?=$motivo?></td>
        </tr>
        <tr>
            <th>Mensagem:</th>
            <td><?=$contactInfo['msg_contato']?></td>
        </tr>
        <tr>
            <th>status:</th>
            <?php
            $status = "";
            switch ($contactInfo['status_contato']){
                case 0:
                    $status = "<span class='text-primary'>Não visto</span>";
                    break;
                case 1:
                    $status = "<span class='text-secondary'>Ignorado</span>";
                    break;
                case 2:
                    $status = "<span class='text-info'>Resolvendo</span>";
                    break;
                case 3:
                    $status = "<span class='text-success'>Resolvido</span>";
                    break;
            }
            ?>
            <td><?=$status?></td>
        </tr>
        <tr>
            <th>Marcar como:</th>
            <td>
                <?php if ($contactInfo['status_contato'] != 1) {?>
                    <form action="contact.php?id=<?=$_GET['id']?>" method="post" class="d-inline">
                        <input type="hidden" name="changeContactStatus" value="1">
                        <button type="submit" class="btn btn-secondary btn-sm">Ignorado</button> |
                    </form>
                <?php } if($contactInfo['status_contato'] != 2) {?>
                    <form action="contact.php?id=<?=$_GET['id']?>" method="post" class="d-inline">
                        <input type="hidden" name="changeContactStatus" value="2">
                        <button type="submit" class="btn btn-info btn-sm">Resolvendo</button>
                    </form>
                <?php } if($contactInfo['status_contato'] != 3) {?>
                    | <form action="contact.php?id=<?=$_GET['id']?>" method="post" class="d-inline">
                        <input type="hidden" name="changeContactStatus" value="3">
                        <button type="submit" class="btn btn-success btn-sm">Resolvido</button>
                    </form>
                <?php }?>
            </td>
        </tr>
        </tbody>
    </table>

    <hr>

    <h3>Enviar email de resposta para usuário</h3>
    <form action="contact.php?id=<?=$_GET['id']?>" method="post">
        <div class="mb-3"><label for="empEmail">O mensagem será enviada do email da empresa: </label> <a
                    href="mailto:contato.taporaqui@gmail.com" id="empEmail">contato.taporaqui@gmail.com</a></div>
        <div class="mb-3">
            <label for="assunto">Assunto: </label> <br>
            <input type="text" id="assunto" name="assunto" required>
        </div>

        <div class="mb-3 me-3 float-start">
            <label for="msgAnterior">Mensagem anterior do usuário:</label> <br>
            <textarea name="msgAnterior" id="msgAnterior" cols="50" rows="7" readonly required><?=$contactInfo['msg_contato']?></textarea>
        </div>

        <div class="mb-3 float-start">
            <label for="msgResposta">Resposta:</label> <br>
            <textarea name="msgResposta" id="msgResposta" cols="50" rows="7" required></textarea>
        </div>
        <div class="clearfix"></div>

        <button type="submit">Enviar mensagem</button>
    </form>
</div>

</body>

</html>