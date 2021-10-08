<?php
    require "assets/getData.php";

    session_start();
    if (empty($_SESSION['idAdm']) || empty($_SESSION['emailAdm']) || empty($_SESSION['senhaAdm'])){
        header('location:index.php');
        exit();
    }

    $year = $_GET['year'] ?? "";
    $chartData = new AnalisysChartData($year);

    $mostPopularServices = $chartData->getMostPopularServices($year);
    $mostChosenCategories = $chartData->getMostChosenCategories($year);
    $mostCommonUserExit = $chartData->getMostCommonUserExit($year);
    $mostCommonServComplains = $chartData->getMostCommonServComplains($year);
    $mostCommonComenComplains = $chartData->getMostCommonComenComplains($year);
    $contactReason = $chartData->getContactReason($year);
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Tá por aqui - Dashboard</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/2a19bde8ca.js" crossorigin="anonymous" defer></script>
        <script src="assets/chart.js/chart.js"></script>
        <script src="script.js" defer></script>
	</head>

	<body onload="createUserClassChart(<?=$chartData->__get('clients')?>, <?=$chartData->__get('providers')?>);
		    createUserSexChart(<?=$chartData->__get('men')?>,<?=$chartData->__get('women')?>,<?=$chartData->__get('otherSex')?>);
		    createServicesChart(<?=$chartData->__get('presencialServices')?>, <?=$chartData->__get('remoteServices')?>);
		    createContractsChart(<?=$chartData->__get('pendingContracts')?>, <?=$chartData->__get('acceptContracts')?>, <?=$chartData->__get('rejectedContracts')?>);
		    createTopServicesChart(<?php foreach ($mostPopularServices as $s) { echo "'".$s['nome_servico']."'" . ', ';}?> <?php foreach ($mostPopularServices as $key => $s) { echo $key !== 4 ? $s['qntContratos'] . ', ' : $s['qntContratos'];}?>);
		    createTopCategoriesChart(<?php foreach ($mostChosenCategories as $c) { echo "'".$c['nome_categoria']."'" . ', ';}?> <?php foreach ($mostChosenCategories as $key => $c) { echo $key !== 4 ? $c['qntEscolhas'] . ', ' : $c['qntEscolhas'];}?>);
		    createMostCommonExitsChart(<?php foreach ($mostCommonUserExit as $r) { echo "'".$r['del_motivo']."'" . ', ';}?> <?php foreach ($mostCommonUserExit as $key => $r) { echo $key !== 4 ? $r['qntEscolhas'] . ', ' : $r['qntEscolhas'];}?>);
		    createMostCommonServiceComplainsChart(<?php foreach ($mostCommonServComplains as $c) { echo "'".$c['denuncia_motivo']."'" . ', ';}?> <?php foreach ($mostCommonServComplains as $key => $c) { echo $key !== 4 ? $c['qntDenuncias'] . ', ' : $c['qntDenuncias'];}?>);
		    createMostCommonCommentComplainsChart(<?php foreach ($mostCommonComenComplains as $c) { echo "'".$c['denuncia_motivo']."'" . ', ';}?> <?php foreach ($mostCommonComenComplains as $key => $c) { echo $key !== 4 ? $c['qntDenuncias'] . ', ' : $c['qntDenuncias'];}?>);
		    createContactsChart(<?=$contactReason['elogios']?>, <?=$contactReason['sugestoes']?>, <?=$contactReason['reclamacoes']?>, <?=$contactReason['bugs']?>, <?=$contactReason['ban_contests']?>, <?=$contactReason['outros']?>);">

		<!-- menu -->
		<div class="nav-side-menu">
		    <div class="brand py-2"><img src="../assets/images/dumb-brand.png" alt="logo"></div>
		    <i class="fa fa-bars fa-2x toggle-btn" data-bs-toggle="collapse" data-bs-target="#menu-content"></i>

		        <div class="menu-list">

		            <ul id="menu-content" class="menu-content collapse out">
		                <li class="active">
		                  <a href="analisys.php"><i class="fas fa-chart-bar sidebar-icon"></i> Estatísticas do site</a>
		                </li>

		                <li data-bs-toggle="collapse" data-bs-target="#gerenciamentoUsuarios" class="collapsed">
		                    <div class="moreItems"><i class="fas fa-users sidebar-icon"></i> Gerenciamento usuários <span class="arrow"><i class="fa fa-angle-down"></i></span></div>
		                </li>
		                <ul class="sub-menu collapse" id="gerenciamentoUsuarios">
							<li><a href="userManagement/userReport.php"><i class="fa fa-angle-right"></i> Relatório de usuários</a></li>
							<li><a href="userManagement/commentComplaint.php"><i class="fa fa-angle-right"></i> Denúncias de comentários</a></li>
							<li><a href="userManagement/contactReport.php"><i class="fa fa-angle-right"></i> Fale conosco</a></li>
		                </ul>

						<li data-bs-toggle="collapse" data-bs-target="#gerenciamentoServicos" class="collapsed">
							<div class="moreItems"><i class="fas fa-people-carry sidebar-icon"></i> Gerenciamento serviços <span class="arrow"><i class="fa fa-angle-down"></i></span></div>
						</li>
						<ul class="sub-menu collapse" id="gerenciamentoServicos">
							<li><a href="serviceManagement/serviceReport.php"><i class="fa fa-angle-right"></i> Relatório de serviços</a></li>
						</ul>

						<li data-bs-toggle="collapse" data-bs-target="#appControl" class="collapsed">
							<div class="moreItems"><i class="fas fa-cog sidebar-icon"></i> Controle do app <span class="arrow"><i class="fa fa-angle-down"></i></span></div>
						</li>
						<ul class="sub-menu collapse" id="appControl">
							<li><a href="appControl/addCategory.php"><i class="fa fa-angle-right"></i> Adicionar categorias</a></li>
                            <li><a href="appControl/addComplainReason.php"><i class="fa fa-angle-right"></i> Adicionar denúncias motivos</a></li>
                            <li><a href="appControl/addExitReason.php"><i class="fa fa-angle-right"></i> Adicionar saída motivos</a></li>
						</ul>
		            </ul>
		     </div>
		</div>

		<!-- paginas -->
		<div class="main" id="pagina">
            <form action="analisys.php" method="get" id="yearForm">
                <label for="analisysYear">Ano de análise: </label>
                <select name="year" id="analisysYear" onchange="document.getElementById('yearForm').submit()" >
                    <option value="" <?php if (isset($_GET['year']) and $_GET['year'] == "") {echo 'selected';}?>>Sempre</option>
                    <option value="2021" <?php if (isset($_GET['year']) and $_GET['year'] == 2021) {echo 'selected';}?>>2021</option>
                    <option value="2022" <?php if (isset($_GET['year']) and $_GET['year'] == 2022) {echo 'selected';}?>>2022</option>
                    <option value="2023" <?php if (isset($_GET['year']) and $_GET['year'] == 2023) {echo 'selected';}?>>2023</option>
                </select>
            </form>

            <h1>Estatísticas do site</h1> <br>

            <h3 class="divTitle">Estatísticas de usuários</h3>
            <div class="row">
                <div class="col-md-6 mb-3 columnBorder">
                    <div class="row">
                        <div class="col-4">
                            <div class="card">
                                <h6 class="card-header">Total usuários</h6>
                                <div class="card-body">
                                    <div class="analisysNum"><?=$chartData->__get('totalUsers')?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card">
                                <h6 class="card-header">Total prestadores</h6>
                                <div class="card-body">
                                    <div class="analisysNum"><?=$chartData->__get('providers')?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card">
                                <h6 class="card-header">Total clientes</h6>
                                <div class="card-body">
                                    <div class="analisysNum"><?=$chartData->__get('clients')?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 offset-md-2 col-12">
                            <canvas id="userClassChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="row">
                        <div class="col-4">
                            <div class="card">
                                <h6 class="card-header">Usuários femininos</h6>
                                <div class="card-body">
                                    <div class="analisysNum"><?=$chartData->__get('women')?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card">
                                <h6 class="card-header">Usuários masculinos</h6>
                                <div class="card-body">
                                    <div class="analisysNum"><?=$chartData->__get('men')?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card">
                                <h6 class="card-header">Usuários de outros sexos</h6>
                                <div class="card-body">
                                    <div class="analisysNum"><?=$chartData->__get('otherSex')?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 offset-md-2 col-12">
                            <canvas id="userSexChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <br><br>

            <h3 class="divTitle">Estatísticas de serviços</h3>
            <div class="row">
                <div class="col-md-6 mb-3 columnBorder">
                    <div class="row">
                        <div class="col-4">
                            <div class="card">
                                <h6 class="card-header">Total Serviços</h6>
                                <div class="card-body">
                                    <div class="analisysNum"><?=$chartData->__get('totalServices')?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card">
                                <h6 class="card-header">Serviços presenciais</h6>
                                <div class="card-body">
                                    <div class="analisysNum"><?=$chartData->__get('presencialServices')?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card">
                                <h6 class="card-header">Serviços remotos</h6>
                                <div class="card-body">
                                    <div class="analisysNum"><?=$chartData->__get('remoteServices')?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 offset-md-2 col-12">
                            <canvas id="serviceChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="row">
                        <div class="col-4">
                            <div class="card">
                                <h6 class="card-header">Serviços banidos</h6>
                                <div class="card-body">
                                    <div class="analisysNum"><?=$chartData->__get('bannedServices')?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card">
                                <h6 class="card-header">Média de views</h6>
                                <div class="card-body">
                                    <div class="analisysNum"><?=$chartData->__get('viewsAverage')?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card">
                                <h6 class="card-header">Média de notas</h6>
                                <div class="card-body">
                                    <div class="analisysNum"><?=$chartData->__get('ratingAverage')?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <br><br>

            <h3 class="divTitle">Estatísticas de contrato</h3>
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="row">
                        <div class="col-3">
                            <div class="card">
                                <h6 class="card-header">Total Contratos</h6>
                                <div class="card-body">
                                    <div class="analisysNum"><?=$chartData->__get('totalContracts')?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="card">
                                <h6 class="card-header">Contratos pendentes</h6>
                                <div class="card-body">
                                    <div class="analisysNum"><?=$chartData->__get('pendingContracts')?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="card">
                                <h6 class="card-header">Contratos aceitos</h6>
                                <div class="card-body">
                                    <div class="analisysNum"><?=$chartData->__get('acceptContracts')?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="card">
                                <h6 class="card-header">Contratos rejeitados</h6>
                                <div class="card-body">
                                    <div class="analisysNum"><?=$chartData->__get('rejectedContracts')?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 offset-md-3 col-12">
                            <canvas id="contractChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <br><br>

            <h3 class="divTitle">Serviços mais populares da plataforma</h3>
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="row d-flex justify-content-center">
                        <?php foreach ($mostPopularServices as $service) {?>
                            <div class="col-2">
                                <div class="card">
                                    <h6 class="card-header"><?=$service['nome_servico']?></h6>
                                    <div class="card-body">
                                        <div class="analisysNum"><?=$service['qntContratos']?> </div> <div class="text-center">contratos</div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-md-8 col-12">
                            <canvas id="topServicesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <br><br>

            <h3 class="divTitle">Categorias mais escolhidas da plataforma</h3>
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="row d-flex justify-content-center">
                        <?php foreach ($mostChosenCategories as $category) {?>
                            <div class="col-2">
                                <div class="card">
                                    <h6 class="card-header"><?=$category['nome_categoria']?></h6>
                                    <div class="card-body">
                                        <div class="analisysNum"><?=$category['qntEscolhas']?> </div> <div class="text-center">escolhas</div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-md-8 col-12">
                            <canvas id="topCategoriesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <br><br>

            <h3 class="divTitle">Motivos comuns de saída de usuários</h3>
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="row d-flex justify-content-center">
                        <?php foreach ($mostCommonUserExit as $reason) {?>
                            <div class="col-2">
                                <div class="card">
                                    <h6 class="card-header allowTextOverflow" data-container="body" data-bs-toggle="popover" data-placement="top" data-trigger="hover" data-content="<?=$reason['del_motivo']?>"><?=$reason['del_motivo']?></h6>
                                    <div class="card-body">
                                        <div class="analisysNum"><?=$reason['qntEscolhas']?> </div> <div class="text-center">escolhas</div>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                        <div class="col-md-8 col-12">
                            <canvas id="mostCommonExitsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <br><br>

            <h3 class="divTitle">Motivos mais comuns de denúncia de serviços</h3>
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="row d-flex justify-content-center">
                        <?php foreach ($mostCommonServComplains as $complain) {?>
                            <div class="col-2">
                                <div class="card">
                                    <h6 class="card-header"><?=$complain['denuncia_motivo']?></h6>
                                    <div class="card-body">
                                        <div class="analisysNum"><?=$complain['qntDenuncias']?> </div> <div class="text-center">denúncias</div>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                        <div class="col-md-8 col-12">
                            <canvas id="mostCommonServiceComplainsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <br><br>

            <h3 class="divTitle">Motivos mais comuns de denúncia de comentários</h3>
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="row d-flex justify-content-center">
                        <?php foreach ($mostCommonComenComplains as $complain) {?>
                            <div class="col-2">
                                <div class="card">
                                    <h6 class="card-header"><?=$complain['denuncia_motivo']?></h6>
                                    <div class="card-body">
                                        <div class="analisysNum"><?=$complain['qntDenuncias']?> </div> <div class="text-center">denuncias</div>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                        <div class="col-md-8 col-12">
                            <canvas id="mostCommonCommentComplainsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <br><br>

            <h3 class="divTitle">Motivos de contato</h3>
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="row d-flex justify-content-center">
                        <div class="col-3">
                            <div class="card">
                                <h6 class="card-header">Elogios</h6>
                                <div class="card-body">
                                    <div class="analisysNum"><?=$contactReason['elogios']?> </div> <div class="text-center">contatos</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="card">
                                <h6 class="card-header">Sugestões</h6>
                                <div class="card-body">
                                    <div class="analisysNum"><?=$contactReason['sugestoes']?> </div> <div class="text-center">contatos</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="card">
                                <h6 class="card-header">Reclamações</h6>
                                <div class="card-body">
                                    <div class="analisysNum"><?=$contactReason['reclamacoes']?> </div> <div class="text-center">contatos</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="card">
                                <h6 class="card-header">Problemas/bugs</h6>
                                <div class="card-body">
                                    <div class="analisysNum"><?=$contactReason['bugs']?> </div> <div class="text-center">contatos</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 mt-3">
                            <div class="card">
                                <h6 class="card-header">Contestação de banimento</h6>
                                <div class="card-body">
                                    <div class="analisysNum"><?=$contactReason['ban_contests']?> </div> <div class="text-center">contatos</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 mt-3">
                            <div class="card">
                                <h6 class="card-header">Outros motivos</h6>
                                <div class="card-body">
                                    <div class="analisysNum"><?=$contactReason['outros']?> </div> <div class="text-center">contatos</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 col-12">
                            <canvas id="contactsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</body>
</html>