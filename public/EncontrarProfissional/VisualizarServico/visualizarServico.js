import ReportInterface from '../../Denuncia/denuncia.js';

const descriptionHandler = () => {
    const btnToggler = document.getElementById("myDescriptionToggleLabel");
    let description_e = document.getElementById("myDescriptionText");
    const txtDescription = description_e.innerText;

    let maxCaracter = 200; // numero maximo de caracteres por fatia do texto
    maxCaracter = window.innerHeight * 0.5;
    let btnStatus = 0; // e o campo do array que sera mostrado

    let splitText = []; // este array comporta em cada campo uma fatia do texto determinada pelo maxCaracter
    const splitQuantity = Math.floor(txtDescription.length / maxCaracter); 
    for(let i = 0; i < splitQuantity; i++){
        let textInitial = (i + 1) * splitQuantity;
        splitText[i] = txtDescription.slice(textInitial, textInitial + maxCaracter + 1);
    }

    description_e.innerText = splitText[0]; // esta e a primeira a ser rodada, com o maxCaracter

    btnToggler.onclick = () => {
        if(btnStatus == splitText.length - 1){ // se a ultima fatia ja estiver sendo mostrada
            btnStatus = 0; // determina a primeira fatia
            description_e.innerText = splitText[btnStatus]; // retorne a primeira fatia
            btnToggler.innerText = "Ler mais";
        }
        else{
            btnStatus++;
            description_e.innerText += splitText[btnStatus]; // adiciona a proxima fatia 
            
            if(btnStatus == splitText.length - 1){ // caso essa seja a ultima fatia
                btnToggler.innerText = "Ocultar";
            }
        }
    }
}

const writeCommentResizeTextArea = () => { // esta funcao evita que o textarea tenha scroll, pois aumenta seu tamenho de acodo com o texto
    let textarea_e = document.getElementById("myWriteComentTextArea");

    textarea_e.onkeydown = () => {
        textarea_e.style.height = '1px';
        textarea_e.style.minHeight = '1px';
        textarea_e.style.maxHeight = '1px';

        textarea_e.style.minHeight = (textarea_e.scrollHeight) + "px";
        textarea_e.style.maxHeight = (25 + textarea_e.scrollHeight) + "px";
        textarea_e.style.height = ( textarea_e.scrollHeight) + "px";
    }
}

const dotOptionsHandler = () => {
    let toggler = document.getElementsByClassName("service-3dot");
    for(let i = 0; i < toggler.length; i++){
        toggler[i].onclick = () => [
            document.getElementById("serviceMenuOptions").classList.toggle("show")
        ]
    }
} 

const reportHandler = () => {
    let iframe_e = document.getElementById("myReportIframe");

    let modal = document.getElementById("myReportModalBody");

    let reportInterface = new ReportInterface(iframe_e);
    let test = reportInterface.getInfo(
       /* {
            serviceName: 'nome_do_servico', providerName : 'nome_do_provedor', reportReason: ['a', 'b', 'c', 'd']
        }*/
       {
            smallBusiness: 'nome_do_negocio', reportReason: ['a']
        }
    );

    let structure = reportInterface.getStructure()[0];
    console.log(structure)
   
     modal.appendChild(structure)
}

writeCommentResizeTextArea();

descriptionHandler();

reportHandler();

dotOptionsHandler();