<?php
require "../../logic/DbConnection.php";
$con = new DbConnection();
$con = $con->connect();
?>
<head>
    <script src="chat.js"></script>
</head>
<body>
    <div class="returnArrow mt-4 ml-4 closed" onclick="returnToChat()">
        <i class="fas fa-chevron-left"></i> Voltar
    </div>
    <div class="userDetailedInfo">
        <img src="../../assets/images/users/no_picture.jpg" alt="Imagem do usuário" class="userImg userImg-lg">
        <div class="userName userName-lg">Nome do usuário (<?=$_GET['idu']?>)</div>
        <div class="userService">Nome do serviço</div>
    </div>

    <div class="chatMidia">
        <button type="button" class="showMidiaBtn" data-toggle="collapse" data-target="#chatMidiaItems" aria-expanded="false" aria-controls="collapseExample">Exibir Mídia <i class="far fa-folder-open"></i> </button>
        <div class="collapse mt-3" id="chatMidiaItems">

            <button type="button" class="btnToggle btnPhotos d-flex justify-content-around align-items-center" data-toggle="collapse" data-target="#chatMidiaList" aria-expanded="false" aria-controls="chatMidiaList">
                <i class="far fa-file-image"></i> Formatos de mídia (5) <i class="fas fa-sort-down"></i>
            </button>
            <div class="collapse" id="chatMidiaList">
                <img src="../../assets/images/users/user1/service_images/service4/1629844731612574fb386b6.jpg" alt="" class="chatMidiaItem">
            </div>

            <button type="button" class="btnToggle btnDocs d-flex justify-content-around align-items-center" data-toggle="collapse" data-target="#chatDocList" aria-expanded="false" aria-controls="chatDocList">
                <i class="far fa-file-pdf"></i> Documentos (17) <i class="fas fa-sort-down"></i>
            </button>
            <div class="collapse" id="chatDocList">
                <div class="formatBtn chatDocItem">
                    <i class="far fa-file-pdf"></i> <span class="docName">nome do arquivo</span> <i class="fas fa-download"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="chatOptions">
        <div class="addFavorite">
            Adicionar aos favoritos
            <label class="switch">
                <input type="checkbox">
                <span class="slider round"></span>
            </label>
        </div>
        <hr>
        <div class="dangerOption dangerFakeLine">Bloquear <i class="fas fa-user-slash"></i></div>
        <div class="dangerOption dangerFakeLine">Denunciar serviço <i class="fas fa-ban"></i></div>
        <div class="dangerOption">Apagar conversa <i class="fas fa-trash"></i></div>
    </div>
</body>
