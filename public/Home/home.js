/* -- Suggestion Bar Comeco--*/

let suggestionList = document.getElementsByClassName("my-services-suggestion-bar")[0];
let suggestionController = { // estas sao as setas laterais da lista
    left: document.getElementById("mySuggestionBarControllerLeft"),
    right: document.getElementById("mySuggestionBarControllerRight")
}

let services = document.getElementsByClassName("my-service-item");

let scroll = 0

const loadSuggestionItems = () => {
    let itemsQuantity = 40;

    template_elem = document.getElementById("myServiceItemTemplate"); // elemnto template

    let a = template_elem.content.querySelectorAll("a")[0]; // este e a tag a do item (template)
    let icon = a.children["myServiceItemIcon"]; // este e o icone do item (template)
    let p = a.children["myServiceItemText"]; // este e o texto/titulo do item ((template))

    for(let i = 0; i < itemsQuantity; i++){ // neste for, os valores do template sao modificados e inseridos na lista 
        a.href = "www.youtube.com"; // este e o link do item
        p.textContent = "Titulo do Item " + i; // este e o texto do item

        let newItem = document.importNode(template_elem.content, true) // este e o item sem o template
        suggestionList.appendChild(newItem); // inserindo o item na lista
    }
}

loadSuggestionItems();

const setSuggestionBarScroll = () => { // aqui a variavel 'scroll' que controla o movimento eh aplicada a lista
    suggestionList.style.marginLeft = scroll + "px";  
}

suggestionController.left.onclick = () => { // ao clicar para a esquerda a lista move para a direita
    scroll += Math.floor(window.innerWidth / 2);
    if(scroll > 0) scroll = 0; // se o usuario clicar para a esquerda, e a lista já estiver no fim, ele reestabelece para a posicao 0;
    setSuggestionBarScroll();
}

suggestionController.right.onclick = () => { // ao clicar na seta para a direita a lista move para a esquerda
    scroll -= Math.floor(window.innerWidth / 2);

    let end = services[services.length - 1].getBoundingClientRect().right + services[services.length - 1].getBoundingClientRect().width - window.innerWidth / 2; // esse sera a distancia da esqueda da tela ate o fim da lista

    if(end < window.innerWidth){ // se o usuario clicar na seta para a direita mesmo que ja estiver no final, ele mantem a sua posicao 
        scroll += window.innerWidth - end;
    }

    setSuggestionBarScroll();

}

/* -- Suggestion Bar Fim--*/