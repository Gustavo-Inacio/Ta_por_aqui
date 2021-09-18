let aux = 0
function showPass(rec){
    let loginPass = document.getElementById('loginPass')
    let eye = document.getElementById('eye')

    if(aux % 2 == 0){
        //mostrar senha
        loginPass.type = "text"
        eye.className = "fas fa-eye-slash"
    } else{
        //esconder senha
        loginPass.type = "password"
        eye.className = "fas fa-eye"
    }
    
    aux++
}

let aux2 = 0
function showRecPass(){
    let loginPass = document.getElementById('recoverPass')
    let eye = document.getElementById('recEye')

    if(aux2 % 2 == 0){
        //mostrar senha
        loginPass.type = "text"
        eye.className = "fas fa-eye-slash"
    } else{
        //esconder senha
        loginPass.type = "password"
        eye.className = "fas fa-eye"
    }

    aux2++
}

document.addEventListener("DOMContentLoaded", function(event) {
    let url = new URL(location.href)
    if(url.searchParams.get('status_usuario') === "suspenso"){
        let cancelSuspensionModal = new bootstrap.Modal(document.getElementById('cancelSuspensionModal'))
        cancelSuspensionModal.show()
    }if(url.searchParams.get('status_usuario') === "banido"){
        let bannedUserModal = new bootstrap.Modal(document.getElementById('bannedUserModal'))
        bannedUserModal.show()
    }
});