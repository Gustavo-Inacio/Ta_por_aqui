<?php
require "../../logic/DbConnection.php";
$con = new DbConnection();
$con = $con->connect();
?>
<head>
    <script src="chat.js"></script>
</head>
<body>
    <div class="returnArrow closed" onclick="returnToContacts()">
        <i class="fas fa-chevron-left"></i> Voltar
    </div>
    <div class="userInfo row" id="userInfo" onclick="loadUserInfo()">
        <div class="col-2 d-flex">
            <img src="../../assets/images/users/no_picture.jpg" alt="Imagem do usuário" class="userImg">
        </div>

        <div class="col-8">
            <div class="userName">Nome do usuário (<?=$_GET['idc']?>)</div>
            <div class="userService">Serviço da conversa</div>
        </div>

        <div class="col-2 d-flex justify-content-end align-items-center">
            <div class="dropleft" id="dropdownContent">
                <button type="button" class="formatBtn" id="moreActions" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                <div class="dropdown-menu" aria-labelledby="moreActions">
                    <a class="dropdown-item" href="#"><i class="fas fa-star"></i> Adicionar aos favoritos</a>
                    <a class="dropdown-item text-danger" href="#"><i class="fas fa-user-slash"></i> Bloquear</a>
                    <a class="dropdown-item text-danger" href="#"><i class="fas fa-ban"></i> Denunciar
                        Serviço</a>
                    <a class="dropdown-item text-danger" href="#"><i class="fas fa-trash"></i> Apagar
                        conversa</a>
                </div>
            </div>
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

    <div class="communicationBar row">
        <div class="col-1 d-flex justify-content-center">
            <button type="button" class="formatBtn" id="useEmojiMsg"><i class="far fa-laugh chatIcon"></i></button>
        </div>

        <div class="col-1 d-flex justify-content-center">
            <button type="button" class="formatBtn"><i class="fas fa-paperclip chatIcon"></i></button>
        </div>

        <div class="col-9 d-flex">
            <div class="input-group">
                            <textarea class="form-control chatMessageInput" placeholder="Digite uma mensagem"
                                      rows="2" id="chatMessageInput"></textarea>
                <div class="input-group-append">
                    <button class="input-group-text chatMessageSend" type="button" id="searchUser"><i
                                class="fas fa-paper-plane"></i></button>
                </div>
            </div>
        </div>

        <div class="col-1 d-flex justify-content-center">
            <button type="button" class="formatBtn"><i class="fas fa-microphone chatIcon"></i></button>
        </div>
    </div>
</body>
