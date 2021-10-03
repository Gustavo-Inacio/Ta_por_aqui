$(document).ready(()=>{
    //habilitar popover
    let popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    let popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl)
    })

    //estilizando botão de mostrar mídia e documentos
    $('.showMidiaBtn').on('click', e => {
        $(e.target).toggleClass('off')
    })

    //abrindo um chat específico se o usuário foi redirecionado para essa página pela de um serviço específico
    let url = new URL(window.location.href)
    if (url.searchParams.get('directChat') !== null){
        $(`[chatId='${url.searchParams.get('directChat')}']`).click()
    }
})

//programando as setas de retorno
function returnToChat(){
    $('#chatThirdColumn').removeClass('opened').addClass('closed')
    $('#chatSecondColumn').removeClass('closed').addClass('opened')
}

function returnToContacts() {
    $('#chatSecondColumn').removeClass('opened').addClass('closed')
    $('#chatFirstColumn').removeClass('closed').addClass('opened')
}

//carregar conversa
var updateChat
var lastMessageId
function loadConversation(chatId, userId){
    //verificando se o ID existe
    if ($(`[chatId='${chatId}']`).length > 0){
        $('#loadAssyncData').innerHTML = "";

        //abrindo um chat específico no mobile
        if (window.innerWidth < 767){
            $('#chatFirstColumn').removeClass('opened').addClass('closed')
            $('#chatSecondColumn').removeClass('closed').addClass('opened')
        }

        //requisitando assincronamente a segunda coluna
        $('#loadAssyncConversation').load(`getConversation.php?chatId=${chatId}&userId=${userId}`, () => {
            //depois de pegar corretamente a conversa, ela ira fazer as seguintes ações:

            //scrollando para o fim da conversa
            let objDiv = document.getElementsByClassName("chatMessages")[0];
            objDiv.scrollTop = objDiv.scrollHeight;

            //atualizando as mensagens dinamicamente
            let selector = document.getElementsByClassName('message')
            lastMessageId = selector[selector.length - 1].id
            clearInterval(updateChat)
            updateChat = setInterval(() => {
                //pegando o id da ultima mensagem
                updateConversation(chatId, userId, lastMessageId)
            },500)
        })

        //requisitando assincronamente a terceira coluna
        $('#loadAssyncUserInfo').load(`getUserInfo.php?chatId=${chatId}&userId=${userId}`)

        //Colocando o contato como ativo
        $('.userDiv').removeClass('active')
        $(`[chatId='${chatId}']`).addClass('active')

        //exibindo a barra de comunicação
        $('#communicationBar').removeClass('d-none')

        //preenchendo os inputs escondidos com as informações da conversa/chat atual
        $('#id_chat_contato').val(chatId)
        $('#id_destinatario').val(userId)
    }
}

//Atualizando conversa dinamicamente puxando a ultima mensagem do banco de dados e inserindo na conversa a cada 0.5s
function updateConversation(getChatId, getUserId, getLastMsgId) {
    let selector = document.getElementsByClassName('message')
    lastMessageId = selector[selector.length - 1].id

    let mydata = {
        chatId: getChatId,
        lastMsgId: getLastMsgId,
        idRemetente: getUserId
    }

    $.ajax({
        url: '../../logic/chat/getNewMessage.php',
        method: 'POST',
        data: mydata,
        success: result => {
            if (result != "sameMsg"){
                loadConversation(getChatId, getUserId)
                //scrollando para o fim da conversa
                let objDiv = document.getElementsByClassName("chatMessages")[0];
                objDiv.scrollTop = objDiv.scrollHeight;
            }
        }
    })
}

//abrindo os detalhes do usuário
function loadUserInfo(){
    if ($('#chatThirdColumn').hasClass('closed')){
        if (window.innerWidth < 767){
            //abrindo detalhes do usuário no celular
            $('#chatSecondColumn').removeClass('opened').addClass('closed')
        }

        //openUserInfo()
        //diminuindo chat
        $('#chatSecondColumn').removeClass('col-md-9').addClass('col-md-6')

        //expandindo userInfo
        $('#chatThirdColumn').removeClass('closed').addClass('opened')
    } else {
        if (window.innerWidth < 767){
            //abrindo detalhes do usuário no celular
            $('#chatSecondColumn').removeClass('closed').addClass('opened')
        }
        //closeUserInfo()
        //aumentando chat
        $('#chatSecondColumn').removeClass('col-md-6').addClass('col-md-9')

        //expandindo userInfo
        $('#chatThirdColumn').removeClass('opened').addClass('closed')
    }
}

function changeInput(){
    $('#chatMessageInputGroup').addClass('d-none')
    $('#midiaInputGroup').removeClass('d-none')
}

function favoriteUser(favToggle, user, chatContact) {
    let toggleFavorito = ''
    toggleFavorito = favToggle.checked === true ? 'favoritar' : 'desfavoritar'

    $.ajax({
        method: 'POST',
        url: '../../logic/chat/chat_favoritarUsuario.php',
        data: {
            idUsuario: user,
            idChatContato: chatContact,
            acao: toggleFavorito
        }
    }).done(() => {
        $('#loadAssyncContacts').load('getContacts.php')
        $('.userDiv').removeClass('active')
        $(`[chatId='${chatContact}']`).addClass('active')
    })
}

function searchUser() {
    let search = document.getElementById('searchedUser').value
    $('#loadAssyncContacts').load('getContacts.php', {param: search})
}

function toggleBlockUser(status, chatContact, user) {
    $.ajax({
        method: 'POST',
        url: '../../logic/chat/chat_bloquearUsuario.php',
        data: {
            statusContato: status,
            idChatContato: chatContact,
            idUsuario: user
        }
    }).done(() => {
        //recarregando contatos
        $('#loadAssyncContacts').load('getContacts.php')

        //limpando carregamento dinâmico
        clearInterval(updateChat)

        //limpando div de conversa e colocando a mensagem padrão (nenhum contato selecionado)
        $('#loadAssyncConversation').html(
            `<div class="noConversationSelected">
                <div class="d-flex flex-column text-center mt-auto mb-auto">
                    <img src="../../assets/images/user_not_found.png" alt="selecionar um usuário" class="align-self-center">
                    <hr>
                    <h3>Se comunique eficazmente</h3>
                    <p>Use nosso chat para conversar com seu prestador ou cliente do serviço contratado. Seja educado &#x1F609;</p>
                </div>
            </div>`)

        //limpando div de informações do usuário
        $('#loadAssyncUserInfo').html('')

        //ajeitando visualização das colunas
        $('#chatThirdColumn').removeClass('opened')
        $('#chatThirdColumn').addClass('closed')
        $('#chatSecondColumn').removeClass('col-md-6')
        $('#chatSecondColumn').addClass('col-md-9')

        //ajeitando a visualização das colunas no celular
        if (window.innerWidth < 768){
            $('#chatSecondColumn').removeClass('opened')
            $('#chatSecondColumn').addClass('closed')
            $('#chatFirstColumn').removeClass('closed')
            $('#chatFirstColumn').addClass('opened')
        }
    })

    //exibindo a barra de comunicação
    $('#communicationBar').addClass('d-none')
}

function enterPressed(e){
    if(!e.shiftKey){
        if (e.code === "Enter"){
            sendMessage()
        }
    }
}

function sendMessage() {
    //verificando se o input não está vazio
    let messageInput = document.getElementById('chatMessageInput')
    let popover = new bootstrap.Popover(messageInput)

    if (messageInput.value === ""){
        popover.enable()
        popover.show()
        setTimeout(() => {
            popover.hide()
            popover.disable()
        }, 2000)
    } else {
        $.ajax({
            method: 'POST',
            url: '../../logic/chat/chat_enviarMensagem.php',
            data: {
                id_chat_contato: $('#id_chat_contato').val(),
                id_remetente_usuario: $('#id_remetente').val(),
                id_destinatario_usuario: $('#id_destinatario').val(),
                mensagem_chat: messageInput.value
            }
        }).done(()=>{
            $('#chatMessageInput').val('')
        })
    }
}

//A função de enviar arquivos está no script de chat.php

function delFile(){
    $('#chatMessageInputGroup').removeClass('d-none')
    $('#midiaInputGroup').addClass('d-none')
    $('#midiaInput').value = "";
}