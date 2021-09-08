<!-- PHP Geral -->
<?php
session_start();

require "../../logic/DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

//puxando novamente informações do usuário
$query = "SELECT * FROM usuarios where id_usuario = " . $_GET['user'];
$stmt = $con->query($query);
$user = $stmt->fetch(PDO::FETCH_OBJ);

if ($_GET['servicetype'] === "requestedServices") {
    //serviços requisitados para esse prestador
    $query = "SELECT * FROM contratos WHERE id_prestador = " . $_GET['user'] . " ORDER BY status_contrato ASC";
    $stmt = $con->query($query);
    $asProviderRequestedServices = $stmt->fetchAll(PDO::FETCH_OBJ);
    ?>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Serviços solicitados para você</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row" id="requestedServicesCardsModal">

                <?php foreach ($asProviderRequestedServices as $service) {
                    //nome do cliente que solicitou
                    $query = "SELECT nome_usuario FROM usuarios WHERE id_usuario = $service->id_cliente";
                    $stmt = $con->query($query);
                    $client_name = $stmt->fetch(PDO::FETCH_OBJ);

                    //detalhes do serviço que foi solicitado
                    $query = "SELECT nome_servico, crit_orcamento_servico, orcamento_servico FROM servicos WHERE id_servico = $service->id_servico";
                    $stmt = $con->query($query);
                    $service_details = $stmt->fetch(PDO::FETCH_OBJ);

                    //data do serviço
                    $date = new DateTime($service->data_contrato);
                    ?>
                    <div class="col-lg-4 col-sm-6 mt-3">
                        <div class="card myCard2 mx-3 tinyCard">
                            <div class="card-header myCardHeader2">
                                Seu serviço foi solicitado por <a
                                        href="perfil.php?id=<?= $service->id_cliente ?>"><?= $client_name->nome_usuario ?></a>
                            </div>
                            <div class="card-body">
                                <h3 class="card-title"><?= $service_details->nome_servico ?></h3>
                                <p class="card-text">
                                    <strong>Informações básicas:</strong> <br>
                                    <strong>Orçamento:</strong> R$ <?=$service_details->orcamento_servico?> <?=$service_details->crit_orcamento_servico?> <br>
                                    <strong>Data da solicitação:</strong> <?=$date->format('d/m/Y')?>
                                </p>

                                <a href="../EncontrarProfissional/VisualizarServico/visuaizarServico.php?serviceID=<?= $service->id_servico ?>"
                                   class="text-primary">Mais detalhes</a>

                            </div>
                            <div class="card-footer">
                                <?php if ($service->status_contrato == 0) { ?>
                                    <button class="btn myCardAccept my-1"
                                            onclick="acceptRejectService('accept', <?= $service->id_contrato ?>, '<?= $client_name->nome_usuario ?>')">
                                        Aceitar
                                    </button>
                                    <button class="btn myCardReject my-1"
                                            onclick="acceptRejectService('reject', <?= $service->id_contrato ?>, '<?= $client_name->nome_usuario ?>')">
                                        Rejeitar
                                    </button>
                                <?php } else if ($service->status_contrato == 1) { ?>
                                    <div class="alert alert-success" role="alert">Serviço aceito</div>
                                <?php } else if ($service->status_contrato == 2) { ?>
                                    <div class="alert alert-danger" role="alert">Serviço rejeitado</div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="mybtn mybtn-secondary" data-dismiss="modal">Fechar</button>
        </div>
    </div>

    <!-- Selecionando os serviços que o prestador em questão adicionou -->
<?php } else if ($_GET['servicetype'] === "availableServices") {
    $query = "SELECT id_servico, nome_servico, tipo_servico, orcamento_servico, crit_orcamento_servico, data_public_servico FROM servicos WHERE id_prestador_servico = " . $_GET['user'] . " ORDER BY nome_servico ASC";
    $stmt = $con->query($query);
    $userServices = $stmt->fetchAll(PDO::FETCH_OBJ);
    ?>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Serviços disponibilizados</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row" id="serviceCardsModal">
                <?php foreach ($userServices as $key => $service) { ?>
                    <div class="col-sm-6 col-lg-4 mt-3">
                        <div class="card myCard mx-3 availableServiceCards tinyCard">
                            <div class="card-header myCardHeader">
                                Serviço <?= $service->tipo_servico == 0 ? "remoto" : "presencial" ?>
                            </div>
                            <div class="card-body">
                                <h3 class="card-title"><?= $service->nome_servico ?></h3>
                                <p class="card-text">
                                    <strong>Informações básicas:</strong> <br>
                                    <strong>Orçamento:</strong> R$ <?=$service->orcamento_servico?> <?=$service->crit_orcamento_servico?> <br>
                                    <?php if ($service->tipo_servico == 1) { ?>
                                        <strong>Localização:</strong> <?= $user->cidade_usuario ?>, <?= $user->uf_usuario ?>
                                    <?php } else { ?>
                                        <strong>Serviço remoto</strong>
                                    <?php } ?>
                                </p>
                                <a href="../EncontrarProfissional/VisualizarServico/visuaizarServico.php?serviceID=<?= $service->id_servico ?>"
                                   class="btn myCardButton">+ detalhes</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="mybtn mybtn-secondary" data-dismiss="modal">Fechar</button>
        </div>
    </div>


<?php } else if ($_GET['servicetype'] === "servicesRequestedByYou") {
    //serviços que você requisitou como cliente
    $query = "SELECT * FROM contratos WHERE id_cliente = " . $_SESSION['idUsuario'] . " ORDER BY status_contrato DESC";
    $stmt = $con->query($query);
    $asClientRequestedServices = $stmt->fetchAll(PDO::FETCH_OBJ);
    ?>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Serviços Requisitados por você</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row" id="savedCardsModal">

                <?php foreach ($asClientRequestedServices as $service) {
                    //nome do cliente que solicitou
                    $query = "SELECT nome_usuario FROM usuarios WHERE id_usuario = $service->id_cliente";
                    $stmt = $con->query($query);
                    $client_name = $stmt->fetch(PDO::FETCH_OBJ);

                    //detalhes do serviço que foi solicitado
                    $query = "SELECT nome_servico, orcamento_servico, crit_orcamento_servico FROM servicos WHERE id_servico = $service->id_servico";
                    $stmt = $con->query($query);
                    $service_details = $stmt->fetch(PDO::FETCH_OBJ);

                    //data do contrato
                    $date = new DateTime($service->data_contrato);
                    ?>
                    <div class="col-lg-4 col-md-6 mt-3">
                        <div class="card myCard2 mx-3 tinyCard">
                            <div class="card-header myCardHeader2">
                                Você solicitou o serviço de <a href="perfil.php?id=<?= $service->id_cliente ?>" class="text-light"><?= $client_name->nome_usuario ?></a>
                            </div>
                            <div class="card-body">
                                <h3 class="card-title"><?= $service_details->nome_servico ?></h3>
                                <p class="card-text">
                                    <strong>Informações básicas:</strong> <br>
                                    <strong>Orçamento:</strong> R$ <?=$service_details->orcamento_servico?> <?=$service_details->crit_orcamento_servico?> <br>
                                    <strong>Data da solicitação:</strong> <?= $date->format('d/m/Y') ?>
                                </p>

                                <a href="../EncontrarProfissional/VisualizarServico/visuaizarServico.php?serviceID=<?= $service->id_servico ?>"
                                   class="text-primary">Mais detalhes</a>

                            </div>
                            <div class="card-footer">
                                <?php if ($service->status_contrato == 0) { ?>
                                    <div class="alert alert-secondary" role="alert">Serviço pendente</div>
                                <?php } else if ($service->status_contrato == 1) { ?>
                                    <div class="alert alert-success" role="alert">Serviço aceito</div>
                                <?php } else if ($service->status_contrato == 2) { ?>
                                    <div class="alert alert-danger" role="alert">Serviço rejeitado</div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="mybtn mybtn-secondary" data-dismiss="modal">Fechar</button>
        </div>
    </div>

<!-- Selecionando os serviços salvos -->
<?php } else if ($_GET['servicetype'] === "savedServices") {
    //puxando os serviços salvos
    $query = "SELECT * FROM servicos_salvos WHERE id_usuario = " . $_GET['user'] . " ORDER BY id_servico_salvo DESC";
    $stmt = $con->query($query);
    $userSavedServices = $stmt->fetchAll(PDO::FETCH_OBJ);
    ?>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Serviços salvos</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row" id="savedCardsModal">
                <?php foreach ($userSavedServices as $service) {
                    $query = "SELECT nome_servico, tipo_servico, orcamento_servico, crit_orcamento_servico, data_public_servico FROM servicos WHERE id_servico = " . $service->id_servico;
                    $stmt = $con->query($query);
                    $savedService = $stmt->fetch(PDO::FETCH_OBJ);
                    ?>
                    <div class="col-lg-4 col-md-6 mt-3">
                        <div class="card myCard mx-3 tinyCard">
                            <div class="card-header myCardHeader">
                                Serviço <?= $savedService->tipo_servico == 0 ? "remoto" : "presencial" ?>
                            </div>
                            <div class="card-body">
                                <h3 class="card-title"><?= $savedService->nome_servico ?></h3>
                                <p class="card-text">
                                    <strong>Informações básicas:</strong> <br>
                                    <strong>Orçamento:</strong> R$ <?=$savedService->orcamento_servico?> <?=$savedService->crit_orcamento_servico?> <br>
                                    <strong>Data de publicação:</strong> <?= $savedService->data_public_servico ?>
                                </p>
                                <a href="../EncontrarProfissional/VisualizarServico/visuaizarServico.php?serviceID=<?= $service->id_servico ?>"
                                   class="text-primary">Mais detalhes</a> <br>
                            </div>
                            <div class="card-footer">
                                <a href="../../logic/perfil_remover_servicosalvo.php?id=<?= $savedService->id_servico_salvo ?>"
                                   class="btn myCardReject">Remover</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="mybtn mybtn-secondary" data-dismiss="modal">Fechar</button>
        </div>
    </div>

<?php } else if($_GET['servicetype'] === "recentServices") {
    //serviços que você contratou e foram aceitos
    $query = "SELECT * FROM contratos WHERE id_cliente = " . $_GET['user']  . " AND status_contrato = 1  ORDER BY id_contrato DESC";
    $stmt = $con->query($query);
    $contractedServicesHistory = $stmt->fetchAll(PDO::FETCH_OBJ);
?>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Serviços contratados recentemente</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row" id="savedCardsModal">

                <?php foreach ($contractedServicesHistory as $key => $service) {
                        //nome, número e foto do prestador que solicitou
                        $query = "SELECT nome_usuario, fone_usuario, imagem_usuario, uf_usuario, cidade_usuario FROM usuarios WHERE id_usuario = $service->id_prestador";
                        $stmt = $con->query($query);
                        $provider_info = $stmt->fetch(PDO::FETCH_OBJ);

                        //detalhes do serviço que foi solicitado
                        $query = "SELECT nome_servico, orcamento_servico, crit_orcamento_servico, tipo_servico FROM servicos WHERE id_servico = $service->id_servico";
                        $stmt = $con->query($query);
                        $service_details = $stmt->fetch(PDO::FETCH_OBJ);

                        //data do contrato
                        $date = new DateTime($service->data_contrato);
                        ?>
                        <div class="col-lg-4 col-md-6 mt-3">
                            <div class="card myCard3 mx-3 tinyCard">
                                <div class="card-header myCardHeader3">
                                    Serviço contratado em: <strong><?=$date->format('d/m/Y')?></strong>
                                </div>
                                <div class="card-body">
                                    <h3 class="card-title"><?=$service_details->nome_servico?></h3>
                                    <p class="card-text">
                                        <strong>Informações básicas:</strong> <br>
                                        <strong>Orçamento:</strong> R$ <?=$service_details->orcamento_servico?> <?=$service_details->crit_orcamento_servico?> <br>
                                        <strong>Localização:</strong> <?=$service_details->tipo_servico == 0 ? "Serviço remoto" : $provider_info->uf_usuario . ', ' . $provider_info->cidade_usuario?>
                                    </p>

                                    <a href="../EncontrarProfissional/VisualizarServico/visuaizarServico.php?serviceID=<?=$service->id_servico?>" class="text-primary">Mais detalhes</a>
                                    <hr>
                                    <div class="row">
                                        <div class="col-12">
                                            <a href="perfil.php?id=<?=$service->id_prestador?>" class="font-weight-bold text-dark"><?=$provider_info->nome_usuario?></a> <br>
                                            <?=$provider_info->fone_usuario?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php }?>

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="mybtn mybtn-secondary" data-dismiss="modal">Fechar</button>
        </div>
    </div>
<?php }?>
