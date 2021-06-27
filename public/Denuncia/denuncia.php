<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tá por aqui</title>
    
    <script src="../../assets/bootstrap/jquery-3.5.1.slim.min.js" defer></script>
    <script src="../../assets/bootstrap/popper.min.js" defer></script>
    <script src="../../assets/bootstrap/bootstrap-4.5.3-dist/js/bootstrap.min.js" defer></script>

  <!-- <link rel="stylesheet" href="../../assets/bootstrap/bootstrap-4.5.3-dist/css/bootstrap.min.css">--> 

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
                <button class="btn dropdown-toggle" type="button" id="btnDropdownReport" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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


        <div class="my-form-footer">
            <p class="required-legend">Obrigatório!</p>
            <button id="btnSend" class="my-submit-btn" type="button">Enviar Denúncia</button>
        </div>
        
    </section>

    <section id="myVerificationSection" style="display: none;">
        <form action="#" method="post">
            <div class="my-report-header-section">
                <h1 class="my-report-section-title m-0">Denúncia</h1>
    
                <p class="my-report-verification-section-subtitle">Você realmente deseja denunciar este serviço?</p>
            </div>


            <div class="my-report-verification-body">
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
                    <input type="hidden" hidden name="smallBusiness" class="smallBusiness_form">
                    <input type="hidden" hidden name="reason" class="reason_form">
                    <input type="hidden" hidden name="comment" class="comment_form">
                    <input type="hidden" hidden name="commentUser" class="commentUser_form">
                    <input type="hidden" hidden name="commentPublishDate" class="commentPublishDate_form">
                    <input type="hidden" hidden name="commentSequncialNumber" class="commentSequncialNumber_form">
                    
                </span>


                <div class="my-form-footer">
                    <button class="my-edit-report-btn" type="button">Editar</button>
                    <button class="my-cancel-report-btn" type="button">Cancelar</button>
                    <button class="my-submit-btn" type="submit">Enviar Denúncia</button>
                </div>

            </div>
        </form>
        
    </section>
</body>
</html>