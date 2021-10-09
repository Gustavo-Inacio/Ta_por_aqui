//abrindo ou fechando divs dependendo da tela.
$(document).ready(() => {
    if (window.innerWidth > 768){
        $('#chatFirstColumn').addClass('opened')
        $('#chatSecondColumn').addClass('opened')
        $('#chatThirdColumn').addClass('closed')
        $('.returnArrow').addClass('closed')
    } else{
        $('#chatFirstColumn').addClass('opened')
        $('#chatSecondColumn').addClass('closed')
        $('#chatThirdColumn').addClass('closed')
        $('.returnArrow').addClass('opened')
    }

    //Carregando a listagem de contatos e atualizando ela dinamicamente
    let url = new URL(window.location.href)
    let idChatAtivoUrl = url.searchParams.get('directChat')
    if (url.searchParams.get('directChat') !== null){
        $('#loadAssyncContacts').load(`getContacts.php?active=${idChatAtivoUrl}`, () => {
            $(`[chatId='${idChatAtivoUrl}']`).click()
        });
    } else {
        $('#loadAssyncContacts').load(`getContacts.php?active=${idChatAtivoUrl}`);
    }

    //configurando emoji picker
    let emojiPicker = new FgEmojiPicker({
        trigger: ['#useEmojiMsg'],
        removeOnSelection: false,
        closeButton: false,
        position: ['top', 'right'],
        preFetch: true,
        insertInto: document.getElementById('chatMessageInput')
    });

    //triggers para enviar mensagem
    $('#sendMessage').on('click', () => {
        sendMessage()
    })
    $('#chatMessageInput').on('keydown', e => {
        enterPressed(e)
    })

    //habilitar popover
    let popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    let popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl)
    })

    //upload de arquivos
    $(document).on('submit', '#midiaForm', e => {
        e.preventDefault()
        let formData = new FormData(document.getElementById('midiaForm'));

        //verificando se o input não está vazio
        let midiaInput = document.getElementById('midiaInput')
        let fileExtension = midiaInput.value.split('.').pop()

        if (midiaInput.value == ""){
            let popover = new bootstrap.Popover(midiaInput, {
                content: "Selecione algum arquivo antes de enviar",
                template: '<div class="popover border border-danger" role="tooltip"><div class="popover-arrow"></div><h3 class="popover-header"></h3><div class="popover-body text-danger "></div></div>'
            })
            popover.enable()
            popover.show()
            setTimeout(() => {
                popover.hide()
                popover.disable()
            }, 2000)
        } else if(midiaInput.files[0].size > 40000000){
            let popover = new bootstrap.Popover(midiaInput, {
                content: "Arquivo muito grande (máx: 35MB)",
                template: '<div class="popover border border-danger" role="tooltip"><div class="popover-arrow"></div><h3 class="popover-header"></h3><div class="popover-body text-danger "></div></div>'
            })
            popover.enable()
            popover.show()
            setTimeout(() => {
                popover.hide()
                popover.disable()
            }, 2000)
        } else {
            $.ajax({
                method: 'POST',
                url: '../../logic/chat/chat_enviarArquivo.php',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: () => {
                    $('#sendFile').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>')

                    //desabilitar botão
                    $('#sendFile').attr('disabled', true)
                    $('#midiaInput').attr('disabled', true)
                },
                complete: () => {
                    //Devolvendo o ícone de enviar
                    $('#sendFile').html('<i class="fas fa-paper-plane"></i>')

                    //habilitar botão
                    $('#sendFile').attr('disabled', false)
                    $('#midiaInput').attr('disabled', false)
                },
                success: function(data) {
                    console.log(data)
                }
            }).done(()=>{
                $('#midiaInput').val('')
                $('#midiaInputGroup').addClass('d-none')
                $('#chatMessageInputGroup').removeClass('d-none')
            })
        }
    })
})

function enterPressed(e){
    if (e.code === "Enter" && !e.shiftKey){
        e.preventDefault()
    }
    if(!e.shiftKey){
        if (e.code === "Enter"){
            sendMessage()
        }
    }
}

function sendMessage() {
    //verificando se o input não está vazio
    let messageInput = document.getElementById('chatMessageInput')
    let popover = new bootstrap.Popover(messageInput, {
        content: "Digite algo antes de enviar",
        placement: "top",
        template: '<div class="popover border border-danger" role="tooltip"><div class="popover-arrow"></div><h3 class="popover-header"></h3><div class="popover-body text-danger "></div></div>'
    })

    popover.disable()

    if (messageInput.value.replace(/\s+/g, '') === ""){
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
            },
            beforeSend: () => {
                //ta carregando mano, se acalme. Vc não pode enviar uma mensagem antes de terminar de enviar a outra
                $('#sendMessage').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>')
                $('#sendMessage').attr('disabled', true)
                $('#chatMessageInput').attr('disabled', true)

                //tratando emojis
            }
        }).done(()=>{
            $('#sendMessage').html('<i class="fas fa-paper-plane"></i>')
            $('#sendMessage').attr('disabled', false)
            $('#chatMessageInput').attr('disabled', false)
            $('#chatMessageInput').val('')
        })
    }
}

//abrindo ou fechando divs ao redimentsionar tela
var width = $(window).width();
$(window).on('resize', function() {
    if ($(this).width() !== width) {
        width = $(this).width();

        if ($(this).width() > 768){
            $('#chatFirstColumn').removeClass('closed').addClass('opened')
            $('#chatSecondColumn').removeClass('closed').addClass('opened')
            $('#chatThirdColumn').removeClass('opened').addClass('closed')

            //aumentando chat
            $('#chatSecondColumn').removeClass('col-md-6').addClass('col-md-9')

            //seta de retorno
            $('.returnArrow').removeClass('opened').addClass('closed')
        } else{
            $('#chatFirstColumn').removeClass('closed').addClass('opened')
            $('#chatSecondColumn').removeClass('opened').addClass('closed')
            $('#chatThirdColumn').removeClass('opened').addClass('closed')

            //seta de retorno
            $('.returnArrow').removeClass('closed').addClass('opened')
        }
    }
});