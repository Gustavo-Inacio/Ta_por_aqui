let aux = 0
function showPass(){
    let loginPass = document.getElementById('loginPass')
    let eye = document.getElementById('eye')

    if(aux%2 == 0){
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