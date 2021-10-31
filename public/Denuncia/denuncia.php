<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tá por aqui - Denúncia</title>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous"> -->

  <!--  <link rel="stylesheet" href="./denuncia.css">-->
</head>
<body>
    <section id="myReportSection">
        <div class="my-report-header">
            <h1 class="my-report-section-title">Denúncia</h1>

            <!--<div class="service-report-title">Denunciar o serviço: <label id="myServiceReportName">Teste</label></div>
            <div class="person-report-title">Prestador: <label id="myPersonReportName">Teste</label></div>-->
        </div>
        <div class="report-alert-div alert alert-danger" role="alert">
            Selecione um motivo, e escreva um comentário sobre a denúncia!
        </div>

        <div class="report-reason">
            <h1 class="report-reason-title">Motivo da denúncia: </h1>
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" id="btnDropdownReport" data-bs-toggle="dropdown" aria-expanded="false">
                    Selecione
                </button>

                <label class="my-report-reason-drop-item dropdown-item" style="display: none;">Action</label>

                <div class="my-reason-dropdrown dropdown-menu" aria-labelledby="btnDropdownReport">

                </div>
            </div>
        </div>

        <div class="my-report-info">
            <p class="other-reason-title other-reason-toggle">Motivo:</p>
            <textarea class="my-other-reason-text other-reason-toggle"></textarea>

            <p class="my-comment-title">Comentário: </p>
            <textarea class="my-comment-text"></textarea>
        </div>

        <p class="required-legend mb-3">Obrigatório!</p>
        <div class="my-form-footer">
            <button id="btn-dismiss" class="mybtn mybtn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button id="btnSend" class="my-submit-btn" type="button">Enviar Denúncia</button>
        </div>

    </section>

    <section id="myVerificationSection" style="display: none;">
        <?php
        //pegar url absoluta para enviar a denúncia independente de onde esse modal é inserido
        $haveSSl = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $currentUrl = "$haveSSl://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $absolutePath = explode('public', $currentUrl);
        $pathToSendComplain = $absolutePath[0] . 'logic/denuncia_enviar.php';
        ?>
        <form action="#" method="post" id="complainForm">
            <div class="my-report-header-section">
                <h1 class="my-report-section-title m-0">Denúncia</h1>
    
                <p class="my-report-verification-section-subtitle" id="my-report-verification-section-subtitle">Você realmente deseja denunciar este serviço?</p>
            </div>


            <div class="my-report-verification-body">
                <div id="data-confirm">
                    <p class="my-report-verificatio-title">Confirme os dados da denúncia abaixo:</p>
                    <div class="my-report-header">
                        <!-- <div class="service-report-title">Denunciar o serviço: <label id="myServiceReportName">Teste</label></div>
                         <div class="person-report-title">Prestador: <label id="myPersonReportName">Teste</label></div> -->
                    </div>

                    <div class="my-report-info mt-3">
                        <p class="other-reason-erification-title">Motivo: </p>
                        <p class="my-reason-text-verification"> Motivo 1</p>

                        <label class="my-comment-title">Comentário: </label>
                        <p class="my-comment-verification">Cras et varius diam. Donec varius consequat ex, nec ullamcorper leo pellentesque at. Morbi nec tincidunt odio. Duis eu justo posuere purus auctor placerat. Donec porta condimentum risus. Aliquam eu leo augue. Mauris imperdiet lectus augue, at rhoncus justo faucibus at. Maecenas vehicula rutrum hendrerit. Integer justo purus, convallis vel est id, ultrices sagittis ex.</p>

                    </div>

                    <span>
                        <input type="hidden" hidden name="reportType" class="reportType_form">
                        <input type="hidden" hidden name="providerName" class="providerName_form">
                        <input type="hidden" hidden name="serviceName" class="serviceName_form">
                        <input type="hidden" hidden name="serviceId" class="serviceId_form">
                        <input type="hidden" hidden name="smallBusiness" class="smallBusiness_form">
                        <input type="hidden" hidden name="reason" class="reason_form">
                        <input type="hidden" hidden name="reasonId" class="reasonId_form">
                        <input type="hidden" hidden name="comment" class="comment_form">
                        <input type="hidden" hidden name="commentUser" class="commentUser_form">
                        <input type="hidden" hidden name="commentId" class="commentId_form">
                        <input type="hidden" hidden name="commentPublishDate" class="commentPublishDate_form">
                        <input type="hidden" hidden name="commentSequncialNumber" class="commentSequncialNumber_form">
                        <textarea hidden name="reportDesc" class="reportDesc_form" cols="30" rows="10"></textarea>
                        <input type="hidden" hidden name="currentUrl" class="currentUrl_form">
                        <input type="hidden" hidden name="pathToSendComplain" id="pathToSendComplain" value="<?=$pathToSendComplain?>">
                    </span>
                </div>

                <div class="my-form-footer">
                    <button class="my-edit-report-btn" type="button">Editar</button>
                    <!-- <button class="my-cancel-report-btn" type="button">Cancelar</button> -->
                    <button class="my-submit-btn" type="submit" id="submitComplain">Enviar Denúncia</button>
                </div>

            </div>
        </form>
        
    </section>
</body>
</html>