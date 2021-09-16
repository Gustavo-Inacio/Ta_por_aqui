$(document).ready(()=>{
    //abrindo ou fechando divs dependendo da tela.
    window.onload = () => {
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

        //abrindo um chat específico se o usuário foi redirecionado para essa página pela de um serviço específico
        let url = new URL(window.location.href)
        if (url.searchParams.get('directChat') !== null){
            loadConversation(url.searchParams.get('directChat'))
        }
    }

    //Colocando botão de voltar ou não dependendo da tela
    if (window.innerWidth < 767){
        $('.returnArrow').removeClass('closed')
    }

    //abrindo ou fechando divs ao redimentsionar tela
    window.onresize = () => {
        if (window.innerWidth > 768){
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
function loadConversation(userId){
    $('#loadAssyncData').innerHTML = "";
    //abrindo um chat específico no mobile
    if (window.innerWidth < 767){
        $('#chatFirstColumn').removeClass('opened').addClass('closed')
        $('#chatSecondColumn').removeClass('closed').addClass('opened')
    }

    //requisitando assincronamente a segunda coluna
    $('#loadAssyncConversation').load(`getConversation.php?idc=${userId}`)

    //requisitando assincronamente a terceira coluna
    $('#loadAssyncUserInfo').load(`getUserInfo.php?idu=${userId}`)

    //Colocando o contato como ativo
    $('.userDiv').removeClass('active')
    $(`[userId='${userId}']`).addClass('active')
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