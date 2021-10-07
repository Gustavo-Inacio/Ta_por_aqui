/* --- NavBar Comeco -- */
const setNavbarConfiguration = () => {
    let toggler = document.getElementById("myMainTopNavbarToggler");
    let backdrop = document.getElementById("myMainTopNavbarNavBackdrop");
    let NavbarNav = document.getElementById("myMainTopNavbarNav");
    
    toggler.onclick = () => {
        backdrop.classList.toggle("show");  
    }

    backdrop.onclick = () => {
        backdrop.classList.remove("show");
        NavbarNav.classList.toggle("show");
    }
}
/* --- NavBar Fim -- */

setNavbarConfiguration();

function getQntMessages() {
    let element = document.getElementsByClassName('qntNonReadMsg')[0];

    //requisitando o script que conta as mensagens
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.open('GET', '../../logic/chat/chat_qntMsgNaoLida.php', true);
    xmlhttp.onreadystatechange = () => {
        if (xmlhttp.readyState === 4) {
            if (xmlhttp.status === 200){
                if (Number(xmlhttp.responseText) > 0){
                    document.getElementById('navChatLink').innerHTML = `Chat <span class="qntNonReadMsg">${xmlhttp.responseText}</span>`
                }
            }
        }
    }
    xmlhttp.send();
}

getQntMessages()

function onlineUser() {
    //configurando o POST
    let formData = new FormData()
    formData.append('setUser', 'online')

    //requisitando o script que bota o user como online
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.open('POST', '../../logic/userOnline.php', true);
    xmlhttp.send(formData);
}

onlineUser()

function offlineUser() {
    //configurando o POST
    let formData = new FormData()
    formData.append('setUser', 'offline')

    //requisitando o script que bota o user como online
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.open('POST', '../../logic/userOnline.php', true);
    xmlhttp.send(formData);
}

window.addEventListener('beforeunload', (e) => {
    offlineUser()
});
