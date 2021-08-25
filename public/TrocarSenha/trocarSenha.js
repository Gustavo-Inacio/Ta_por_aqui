function validateNewPass(sessionPass) {
    let oldPass = document.getElementById('oldPass').value
    let newPass = document.getElementById('newPass').value
    let confirmNewPass = document.getElementById('confirmNewPass').value
    let valid = true
    let msgError = ""

    const regexnum = /[0-9]/
    const regexword = /[a-zA-Z]/

    //senha não colidem
    if (newPass !== confirmNewPass){
        valid = false
        msgError = "As senhas não batem"
    }

    //A senha deve ter 8 caracteres e conter letras e números
    if (newPass.length < 8 || !regexnum.test(newPass) || !regexword.test(newPass)){
        valid = false
        msgError = "Digite uma senha com pelo menos 8 caracteres contendo letras e números"
    }

    //senha igual a atual
    if (oldPass === newPass){
        valid = false
        msgError = "Senha antiga igual a nova"
    }

    //senha atual incorreta
    if (oldPass !== sessionPass){
        valid = false
        msgError = "Senha antiga errada"
    }

    //Campos vazios
    if (oldPass === "" || newPass === "" || confirmNewPass === ""){
        valid = false
        msgError = "Não deixe nenhum campo nulo"
    }

    if (valid){
        document.getElementById("changePassForm").submit()
    } else {
        document.getElementById('alertError').classList.remove('d-none')

        document.getElementById("msgErro").innerText = msgError
    }
}