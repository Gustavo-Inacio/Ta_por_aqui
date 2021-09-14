$(document).ready(()=>{
    $('.showMidiaBtn').on('click', e => {
        $(e.target).toggleClass('off')
    })
<<<<<<< HEAD
})
=======

    $('#userInfo').on('click', e => {
        if ($('#chatThirdColumn').hasClass('closed')){
            openUserInfo()
            if (window.innerWidth < 767){
                $('#chatSecondColumn').addClass('closed')
            }
        } else {
            closeUserInfo()
            if (window.innerWidth < 767){
                $('#chatSecondColumn').removeClass('closed')
            }
        }
    })

    $('.userDiv').on('click', () => {
        if (window.innerWidth < 767){
            $('#chatFirstColumn').addClass('closed')
            $('#chatSecondColumn').removeClass('closed')
        }
    })

    if (window.innerWidth < 767){
        cellphoneScreen()
    }

    window.onresize = () => {
        if (window.innerWidth === 767){
            cellphoneScreen()
        } else if (window.innerWidth === 768) {
            returnDesktopScreen()
        }
    }
})

function openUserInfo(){
    //diminuindo chat
    $('#chatSecondColumn').removeClass('col-md-9').addClass('col-md-6')

    //expandindo userInfo
    $('#chatThirdColumn').removeClass('closed')
}

function closeUserInfo(){
    //diminuindo chat
    $('#chatSecondColumn').removeClass('col-md-6').addClass('col-md-9')

    //expandindo userInfo
    $('#chatThirdColumn').addClass('closed')
}

function cellphoneScreen(){
    $('#chatSecondColumn').addClass('closed')
    $('#chatThirdColumn').addClass('closed')
}

function returnDesktopScreen(){
    $('#chatSecondColumn').removeClass('closed')
    $('#chatThirdColumn').removeClass('closed')
}
>>>>>>> 4246741... bugs e erros gramaticais consertador
