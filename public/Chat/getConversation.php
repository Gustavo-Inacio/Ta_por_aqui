<?php
require "../../logic/DbConnection.php";
$con = new DbConnection();
$con = $con->connect();
?>
<head>
    <script src="chat.js"></script>
</head>
<body style="position: relative">
<div class="px-3 pb-0 pt-0 pt-md-3" style="height: calc(100vh - 157px)">
    <div class="returnArrow closed" onclick="returnToContacts()">
        <i class="fas fa-chevron-left"></i> Voltar
    </div>
    <div class="userInfo row" id="userInfo" onclick="loadUserInfo()">
        <div class="col-2 d-flex">
            <img src="../../assets/images/users/no_picture.jpg" alt="Imagem do usuário" class="userImg">
        </div>

        <div class="col-10">
            <div class="userName">Nome do usuário (<?= $_GET['idc'] ?>)</div>
            <div class="userService">Serviço da conversa</div>
        </div>
    </div>

    <div class="chatMessages">
        <div class="chatDate">Ontem</div>

        <div class="message myMessage">
            <div class="messageText">Lorem ipsum dolor sit amet, consectetur adipisicing elit. At eveniet ipsam
                laborum nam nobis perferendis rerum ullam, velit. Aut dicta ducimus incidunt itaque nihil,
                officia placeat praesentium quisquam sint voluptatum.
            </div>
            <div class="messageTime">16:00</div>
        </div>

        <div class="message itsMessage">
            <div class="messageText">Lorem ipsum dolor sit amet, consectetur adipisicing elit. At eveniet ipsam
                laborum nam nobis perferendis rerum ullam, velit. Aut dicta ducimus incidunt itaque nihil,
                officia placeat praesentium quisquam sint voluptatum.
            </div>
            <div class="messageTime">16:00</div>
        </div>

        <div class="chatDate">Ontem</div>

        <div class="message myMessage">
            <div class="messageText">Lorem ipsum dolor sit amet, consectetur adipisicing elit. At eveniet ipsam
                laborum nam nobis perferendis rerum ullam, velit. Aut dicta ducimus incidunt itaque nihil,
                officia placeat praesentium quisquam sint voluptatum.
            </div>
            <div class="messageTime">16:00</div>
        </div>

        <div class="message itsMessage">
            <div class="messageText">Lorem ipsum dolor sit amet, consectetur adipisicing elit. At eveniet ipsam
                laborum nam nobis perferendis rerum ullam, velit. Aut dicta ducimus incidunt itaque nihil,
                officia placeat praesentium quisquam sint voluptatum.
            </div>
            <div class="messageTime">16:00</div>
        </div>

        <div class="chatDate">Ontem</div>

        <div class="message myMessage">
            <div class="messageText">Lorem ipsum dolor sit amet, consectetur adipisicing elit. At eveniet ipsam
                laborum nam nobis perferendis rerum ullam, velit. Aut dicta ducimus incidunt itaque nihil,
                officia placeat praesentium quisquam sint voluptatum.
            </div>
            <div class="messageTime">16:00</div>
        </div>

        <div class="message itsMessage">
            <div class="messageText">Lorem ipsum dolor sit amet, consectetur adipisicing elit. At eveniet ipsam
                laborum nam nobis perferendis rerum ullam, velit. Aut dicta ducimus incidunt itaque nihil,
                officia placeat praesentium quisquam sint voluptatum.
            </div>
            <div class="messageTime">16:00</div>
        </div>

        <div class="chatDate">Ontem</div>

        <div class="message myMessage">
            <div class="messageText">Lorem ipsum dolor sit amet, consectetur adipisicing elit. At eveniet ipsam
                laborum nam nobis perferendis rerum ullam, velit. Aut dicta ducimus incidunt itaque nihil,
                officia placeat praesentium quisquam sint voluptatum.
            </div>
            <div class="messageTime">16:00</div>
        </div>

        <div class="message itsMessage">
            <div class="messageText">Lorem ipsum dolor sit amet, consectetur adipisicing elit. At eveniet ipsam
                laborum nam nobis perferendis rerum ullam, velit. Aut dicta ducimus incidunt itaque nihil,
                officia placeat praesentium quisquam sint voluptatum.
            </div>
            <div class="messageTime">16:00</div>
        </div>

        <div class="chatDate">Ontem</div>

        <div class="message myMessage">
            <div class="messageText">Lorem ipsum dolor sit amet, consectetur adipisicing elit. At eveniet ipsam
                laborum nam nobis perferendis rerum ullam, velit. Aut dicta ducimus incidunt itaque nihil,
                officia placeat praesentium quisquam sint voluptatum.
            </div>
            <div class="messageTime">16:00</div>
        </div>

        <div class="message itsMessage">
            <div class="messageText">Lorem ipsum dolor sit amet, consectetur adipisicing elit. At eveniet ipsam
                laborum nam nobis perferendis rerum ullam, velit. Aut dicta ducimus incidunt itaque nihil,
                officia placeat praesentium quisquam sint voluptatum.
            </div>
            <div class="messageTime">16:00</div>
        </div>
    </div>
</div>

    <div class="communicationBar row">
        <div class="col-1 d-flex justify-content-center">
            <button type="button" class="formatBtn" id="useEmojiMsg"><i class="far fa-laugh chatIcon"></i></button>
        </div>

        <div class="col-1 d-flex justify-content-center align-items-center">
            <label for="midiaInput" class="formatBtn d-flex" id="showMidiainput" data-bs-container="body" data-bs-trigger="hover" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Clique aqui para enviar documentos ou fotos"><i class="fas fa-paperclip chatIcon"></i></label>
        </div>

        <div class="col-9 d-flex">
            <div class="input-group" id="chatMessageInputGroup">
                <textarea class="form-control chatMessageInput" placeholder="Digite uma mensagem" rows="2" id="chatMessageInput"></textarea>
                <button class="input-group-text chatMessageSend" type="button" id="sendMessage"><i class="fas fa-paper-plane"></i></button>
            </div>

            <div class="input-group d-none align-self-center" id="midiaInputGroup">
                <input type="file" id="midiaInput" class="form-control" onchange="changeInput()" aria-describedby="sendFile">
                <button class="input-group-text chatMessageSend" type="button" id="sendFile"><i class="fas fa-paper-plane"></i></button>
                <button class="input-group-text ml-2" id="deleteFile" onclick="deleteFile()"><i class="fas fa-trash text-danger"></i></button>
            </div>
        </div>

        <div class="col-1 d-flex justify-content-center">
            <button type="button" class="formatBtn"><i class="fas fa-microphone chatIcon"></i></button>
        </div>
    </div>
</body>
