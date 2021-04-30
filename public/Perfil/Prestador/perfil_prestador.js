//permitir que o usuário clique nos botões de salvar e cancelar
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