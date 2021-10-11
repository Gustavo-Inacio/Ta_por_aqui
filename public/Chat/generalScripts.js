$(document).ready(()=>{
    //estilizando botão de mostrar mídia e documentos
    $('.showMidiaBtn').on('click', e => {
        $(e.target).toggleClass('off')
    })
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
var updateUserStatus;
var lastMessageId
function loadConversation(chatId, userId, changeConversationLoad = true, serviceName, providerName){
    //verificando se o ID existe
    if ($(`[chatId='${chatId}']`).length > 0){
        $('#loadAssyncData').innerHTML = "";

        //abrindo um chat específico no mobile
        if (window.innerWidth < 767){
            $('#chatFirstColumn').removeClass('opened').addClass('closed')
            $('#chatSecondColumn').removeClass('closed').addClass('opened')
        }

        //preenchendo os inputs escondidos com as informações da conversa/chat atual
        $('#id_chat_contato').val(chatId)
        $('#id_destinatario').val(userId)
        $('#nome_servico').val(serviceName)
        $('#nome_prestador').val(providerName)

        //requisitando assincronamente a segunda coluna
        $.ajax({
            url: 'getConversation.php',
            method: 'GET',
            data: {
                chatId: chatId,
                userId: userId
            },
            beforeSend: () => {
                if (changeConversationLoad){
                    $('#communicationBar').addClass('d-none')
                    $('#loadAssyncConversation').css('height', 'calc(100vh - 90px)')
                    $('#loadAssyncConversation').html("<div class='d-flex h-100 flex-row align-items-center justify-content-center'><div class='spinner-border' role='status' style='width: 100px; height: 100px'></div></div>")
                }
            },
            success: result => {
                $('#loadAssyncConversation').html(result)

                //depois de pegar corretamente a conversa, ela ira fazer as seguintes ações:
                $('#loadAssyncConversation').css('height', 'auto')

                //scrollando para o fim da conversa
                let objDiv = document.getElementsByClassName("chatMessages")[0];
                objDiv.scrollTop = objDiv.scrollHeight;

                //exibindo a barra de comunicação
                $('#communicationBar').removeClass('d-none')

                //atualizando as mensagens dinamicamente
                let selector = document.getElementsByClassName('message')
                if (selector.length === 0){
                    lastMessageId = 0
                } else {
                    lastMessageId = selector[selector.length - 1].id
                }
                clearInterval(updateChat)
                updateChat = setInterval(() => {
                    //pegando o id da ultima mensagem
                    updateConversation(chatId, userId, lastMessageId)
                },1000)

                //Toda vez que a conversa é carregada, será solicitado um script para marcar as conversas do destinatário como lidas
                $.ajax({
                    url: '../../logic/chat/chat_lerMsg.php',
                    method: 'POST',
                    data: {
                        id_contato: chatId
                    }
                })

                //online ou offline?
                clearInterval(updateUserStatus)
                updateUserStatus = setInterval(() => {
                    $.ajax({
                        url: '../../logic/chat/chat_getUserStatus.php',
                        method: 'GET',
                        data: {id_usuario: userId},
                        success: status => {
                            if (status == '1'){
                                $('#statusOnlineUser').html('<span class="text-success"><i class="fas fa-circle" style="font-size: 13px"></i> Online</span>')
                            } else {
                                $('#statusOnlineUser').html('<span class="text-secondary"><i class="fas fa-circle" style="font-size: 13px"></i> Offline</span>')
                            }
                        }
                    })
                }, 5000)
            }
        })
        /*$('#loadAssyncConversation').load(`getConversation.php?chatId=${chatId}&userId=${userId}`, () => {

        })*/

        //requisitando assincronamente a terceira coluna
        $('#loadAssyncUserInfo').load(`getUserInfo.php?chatId=${chatId}&userId=${userId}`)

        //Colocando o contato como ativo
        $('.userDiv').removeClass('active')
        $(`[chatId='${chatId}']`).addClass('active')
    }
}

//Atualizando conversa dinamicamente puxando a ultima mensagem do banco de dados e inserindo na conversa a cada 0.5s
function updateConversation(getChatId, getUserId, getLastMsgId) {
    let selector = document.getElementsByClassName('message')
    if (selector.length === 0){
        lastMessageId = 0
    } else {
        lastMessageId = selector[selector.length - 1].id
    }

    let mydata = {
        chatId: getChatId,
        lastMsgId: getLastMsgId,
        idDestinatario: getUserId
    }

    //usuários recebem mensagem dinamicamente
    $.ajax({
        url: '../../logic/chat/getNewMessage.php',
        method: 'POST',
        data: mydata,
        success: result => {
            if (result === "differentMsg" || result === "noMsg"){
                loadConversation(getChatId, getUserId, false)
                //scrollando para o fim da conversa
                let objDiv = document.getElementsByClassName("chatMessages")[0];
                objDiv.scrollTop = objDiv.scrollHeight;

                //atualizando a listagem de contatos
                $('#loadAssyncContacts').load('getContacts.php?active='+getChatId);
            }
        }
    })

    //Ler mensagem dinamicamente caso o chat esteja aberto
    $.ajax({
        url: '../../logic/chat/chat_lerMsg.php',
        method: 'POST',
        data: {
            id_contato: getChatId
        }
    })

    //Marcar mensagem como lida dinamicamente
    $.ajax({
        url: '../../logic/chat/chat_atualizarMsgLida.php',
        method: 'POST',
        data: {
            id_contato: getChatId
        },
        success: result => {
            if (result === '1'){
                $('.msgRead .fas').remove()
                $('.msgRead').append('<i class="fas fa-check-double text-primary"></i>')
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

        //diminuindo chat
        $('#chatSecondColumn').removeClass('col-md-9').addClass('col-md-6')

        //expandindo userInfo
        $('#chatThirdColumn').removeClass('closed').addClass('opened')
    } else {
        if (window.innerWidth < 767){
            //abrindo detalhes do usuário no celular
            $('#chatSecondColumn').removeClass('closed').addClass('opened')
        }
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
        },
        beforeSend: () => {
            $('#loadAssyncContacts').html('<strong class="me-3">Atualizando contatos...</strong> <div class="spinner-border" role="status"></div>')
        }
    }).done(() => {
        $('#loadAssyncContacts').load('getContacts.php?active='+chatContact)
    })
}

function searchUser() {
    let search = document.getElementById('searchedUser').value
    let idChatAtivo = $('.active').attr('chatid')
    $.ajax({
        url: 'getContacts.php',
        method: 'GET',
        data: {
            param: search,
            active: idChatAtivo
        },
        beforeSend: () => {
            $('#loadAssyncContacts').html('<strong class="me-3">Carregando pesquisa...</strong> <div class="spinner-border" role="status"></div>')
        },
        success: result => {
            $('#loadAssyncContacts').html(result)
        }
    })
}

function toggleBlockUser(status, chatContact, user) {
    $.ajax({
        method: 'POST',
        url: '../../logic/chat/chat_bloquearUsuario.php',
        data: {
            statusContato: status,
            idChatContato: chatContact,
            idUsuario: user
        },
        beforeSend: () => {
            $('#loadAssyncContacts').html('<strong class="me-3">Atualizando contatos...</strong> <div class="spinner-border" role="status"></div>')
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

//A função de enviar arquivos está no script de chat.php

function delFile(){
    $('#chatMessageInputGroup').removeClass('d-none')
    $('#midiaInputGroup').addClass('d-none')
    $('#midiaInput').value = "";
}