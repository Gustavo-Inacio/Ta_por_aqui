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

    //configurando emoji picker
    let emojiPicker = new FgEmojiPicker({
        trigger: ['#useEmojiMsg'],
        removeOnSelection: false,
        closeButton: false,
        position: ['top', 'right'],
        preFetch: true,
        insertInto: document.getElementById('chatMessageInput')
    });

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
let updateChat
function loadConversation(chatId, userId, classif){
    //verificando se o ID existe
    if ($(`[chatId='${chatId}']`).length > 0){
        $('#loadAssyncData').innerHTML = "";

        //abrindo um chat específico no mobile
        if (window.innerWidth < 767){
            $('#chatFirstColumn').removeClass('opened').addClass('closed')
            $('#chatSecondColumn').removeClass('closed').addClass('opened')
        }

        //requisitando assincronamente a segunda coluna
        $('#loadAssyncConversation').load(`getConversation.php?chatId=${chatId}&userId=${userId}&show=${classif}`)

        //requisitando assincronamente a terceira coluna
        $('#loadAssyncUserInfo').load(`getUserInfo.php?chatId=${chatId}&userId=${userId}&show=${classif}`)

        //Colocando o contato como ativo
        $('.userDiv').removeClass('active')
        $(`[chatId='${chatId}']`).addClass('active')

        //exibindo a barra de comunicação
        $('#communicationBar').removeClass('d-none')

        //atualizando conversa dinamicamente
        clearInterval(updateChat)
        updateChat = setInterval(() => {
            $('#loadAssyncConversation').load(`getConversation.php?chatId=${chatId}&userId=${userId}&show=${classif}`)
        },1000)

        //preenchendo os inputs escondidos com as informações da conversa/chat atual
        $('#id_chat_contato').val(chatId)
        $('#id_destinatario').val(userId)
    }
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

function deleteFile(){
    $('#chatMessageInputGroup').removeClass('d-none')
    $('#midiaInputGroup').addClass('d-none')
    $('midiaInput').value = "";
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

function sendMessage() {
    $.ajax({
        method: 'POST',
        url: '../../logic/chat/chat_enviarMensagem.php',
        data: {
            id_chat_contato: $('#id_chat_contato').val(),
            id_remetente_usuario: $('#id_remetente').val(),
            id_destinatario_usuario: $('#id_destinatario').val(),
            mensagem_chat: $('#chatMessageInput').val()
        }
    }).done(()=>{
        $('#chatMessageInput').val('')
    })
}