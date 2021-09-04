//remover transição do collapse quando a página carrega e devolve-la quando clicado
$(document).ready(() => {
    $('#appControl').collapse('show')
    $('#appControl').removeClass('collapsing')
    $('#appControl').on("click", () => {
        $('#appControl').addClass('collapsing')
    })
})

