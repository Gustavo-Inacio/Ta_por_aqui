//permitir que o usuário clique nos botões de salvar e cancelar e edite seu perfil
function changeButtonColor(){
    let saveButton = document.getElementById("buttonSave")
    let cancelButton = document.getElementById("buttonCancel")

    saveButton.className = 'saveEdit'
    saveButton.disabled = ''
    cancelButton.className = 'cancelEdit'
    cancelButton.disabled = ''

    let name = document.getElementById("userName")
    let lastName = document.getElementById("userLastName")
    let cell = document.getElementById("userCell")
    let email = document.getElementById("userEmail")
    let site = document.getElementById("userSite")
    let description = document.getElementById("userDescription")

    name.removeAttribute('readonly')
    name.style.color = 'black'
    name.focus()

    lastName.removeAttribute('readonly')
    lastName.style.color = 'black'

    cell.removeAttribute('readonly')
    cell.style.color = 'black'

    email.removeAttribute('readonly')
    email.style.color = 'black'

    site.removeAttribute('readonly')
    site.style.color = 'black'

    description.removeAttribute('readonly')
    description.style.color = 'black'
}

//editar o nome das redes sociais
function editaRedes(){
    let instagram = document.getElementById('instagram')
    let facebook = document.getElementById('facebook')
    let twitter = document.getElementById('twitter')
    let botaoEditar = document.getElementById('socialMediaEdit')
    let botaoSalvar = document.getElementById('btnSalvarRedes')
    let botaoCancelar = document.getElementById('btnCancelarRedes')

    botaoEditar.className = 'd-none'
    botaoSalvar.classList.remove('d-none')
    botaoCancelar.classList.remove('d-none')

    instagram.removeAttribute('readonly')
    facebook.removeAttribute('readonly')
    twitter.removeAttribute('readonly')
    instagram.focus()
}