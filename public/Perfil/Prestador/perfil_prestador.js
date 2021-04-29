//permitir que o usuário clique nos botões de salvar e cancelar
function changeButtonColor(){
    let saveButton = document.getElementById("buttonSave")
    let cancelButton = document.getElementById("buttonCancel")

    saveButton.className = 'saveEdit'
    saveButton.disabled = ''
    cancelButton.className = 'cancelEdit'
    cancelButton.disabled = ''

    document.getElementById("userName").removeAttribute('readonly')
    document.getElementById("userLastName").removeAttribute('readonly')
    document.getElementById("userCell").removeAttribute('readonly')
    document.getElementById("userEmail").removeAttribute('readonly')
    document.getElementById("userSite").removeAttribute('readonly')
    document.getElementById("userDescription").removeAttribute('readonly')

}