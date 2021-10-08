let serviceState = {
    allservices : [],
    servicesToAdd: [],
    maxDistance : 0,
    endedSearch: false
}

function rearrangeServices(){
    let servicesList_e = document.querySelectorAll(".service-card-link");
    let servicesToAdd = [];
    let serviceID_DOM = [];
    serviceID_DOM = servicesList_e.map(elem => elem.getAttribute("serviceID"));
}

function refreshServices ()  {
    serviceState.allservices = serviceState.allservices.concat(serviceState.servicesToAdd);
    serviceCardsRender(serviceState.servicesToAdd);
}

function setServiceState(data) {
    if(!typeof data === 'object') {
        console.log("[setServiceState] -> wrong type of data");
        return;
    }

    for(let i in data){
        serviceState[i] = data[i];
    }

    refreshServices();
}


let searachState = {
    tag : [
        // {
        //     id : null,
        //     name :''
        // }
    ],
    write : []
};

const removeSearchTag = (index) => { // cuida da remocao da tag ao clicar no close dela. Recebe o id da subCategoria
    tagTemp = searachState.tag; 
    let arrayIndex;
    tagTemp.forEach((tag, i) => { // acha o index da tag dentro do array
        if(tag.id == index) arrayIndex = i;
    });

    tagTemp.splice(arrayIndex, 1); // elimina aquela posicao do array
    setSearchState({tag: tagTemp}); // atualiza as categorias na pesquisa
}

const addSearchTag = (tagName, index) => { // cuida de add uma atg na pesquisa 
    tagTemp = searachState.tag; // copia o estado atual
    tagTemp.push({ // adiciona o nome da tag e o seu id (id_subcategoria)
        id: index,
        name: tagName
    });

    setSearchState({tag: tagTemp}); // atualizao estado atual
}

const refreshTagsArea = () => { // cuida de recaregar toda a area das tags
    let section = document.querySelector("#searchTagSection"); // sectiin das tags
    
    if(searachState.tag.length <= 0 || !searachState.tag.length){ // se nao tiver nehuma tag, esconde a section
        section.style.display = "none";
    }
    else{
        section.style.display = "flex";
        
        let searchTagPath = document.querySelector(".tags-div");

        //btn close e todas as tags
        searchTagPath.innerHTML = `
        <div class="clear-tags-div">
            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0)">
                <path d="M14 1.75C10.7511 1.75 7.63526 3.04062 5.33794 5.33794C3.04062 7.63526 1.75 10.7511 1.75 14C1.75 17.2489 3.04062 20.3647 5.33794 22.6621C7.63526 24.9594 10.7511 26.25 14 26.25C17.2489 26.25 20.3647 24.9594 22.6621 22.6621C24.9594 20.3647 26.25 17.2489 26.25 14C26.25 10.7511 24.9594 7.63526 22.6621 5.33794C20.3647 3.04062 17.2489 1.75 14 1.75ZM14 0C17.713 0 21.274 1.47499 23.8995 4.1005C26.525 6.72601 28 10.287 28 14C28 17.713 26.525 21.274 23.8995 23.8995C21.274 26.525 17.713 28 14 28C10.287 28 6.72601 26.525 4.10051 23.8995C1.475 21.274 0 17.713 0 14C0 10.287 1.475 6.72601 4.10051 4.1005C6.72601 1.47499 10.287 0 14 0Z" fill="black"/>
                <path d="M8.13011 19.8694C8.21139 19.9509 8.30795 20.0155 8.41425 20.0596C8.52056 20.1038 8.63452 20.1265 8.74961 20.1265C8.8647 20.1265 8.97867 20.1038 9.08497 20.0596C9.19127 20.0155 9.28783 19.9509 9.36911 19.8694L13.9996 15.2372L18.6301 19.8694C18.7115 19.9508 18.808 20.0153 18.9143 20.0593C19.0206 20.1033 19.1346 20.126 19.2496 20.126C19.3647 20.126 19.4786 20.1033 19.5849 20.0593C19.6912 20.0153 19.7878 19.9508 19.8691 19.8694C19.9505 19.788 20.015 19.6915 20.059 19.5852C20.1031 19.4789 20.1257 19.365 20.1257 19.2499C20.1257 19.1348 20.1031 19.0209 20.059 18.9146C20.015 18.8083 19.9505 18.7118 19.8691 18.6304L15.2369 13.9999L19.8691 9.3694C19.9505 9.28805 20.015 9.19147 20.059 9.08517C20.1031 8.97888 20.1257 8.86495 20.1257 8.7499C20.1257 8.63485 20.1031 8.52092 20.059 8.41463C20.015 8.30834 19.9505 8.21175 19.8691 8.1304C19.7878 8.04905 19.6912 7.98451 19.5849 7.94049C19.4786 7.89646 19.3647 7.8738 19.2496 7.8738C19.1346 7.8738 19.0206 7.89646 18.9143 7.94049C18.808 7.98451 18.7115 8.04905 18.6301 8.1304L13.9996 12.7627L9.36911 8.1304C9.28776 8.04905 9.19118 7.98451 9.08488 7.94049C8.97859 7.89646 8.86466 7.8738 8.74961 7.8738C8.63456 7.8738 8.52063 7.89646 8.41434 7.94049C8.30805 7.98451 8.21146 8.04905 8.13011 8.1304C8.04876 8.21175 7.98422 8.30834 7.94019 8.41463C7.89617 8.52092 7.8735 8.63485 7.8735 8.7499C7.8735 8.86495 7.89617 8.97888 7.94019 9.08517C7.98422 9.19147 8.04876 9.28805 8.13011 9.3694L12.7624 13.9999L8.13011 18.6304C8.04862 18.7117 7.98397 18.8082 7.93986 18.9145C7.89575 19.0208 7.87305 19.1348 7.87305 19.2499C7.87305 19.365 7.89575 19.479 7.93986 19.5853C7.98397 19.6916 8.04862 19.7881 8.13011 19.8694Z" fill="black"/>
                </g>
                <defs>
                <clipPath id="clip0">
                <rect width="28" height="28" fill="white" transform="matrix(1 0 0 -1 0 28)"/>
                </clipPath>
                </defs>
            </svg>
        </div>
        `;

        let clearAllTags = document.querySelector(".clear-tags-div");
        clearAllTags.onclick = () => { // acao de eliminar todas as tags juntas
            setSearchState({tag: []});
        };  

        const addFunctions = (node, index) => { // add a funcao de fechar as tags
            node.querySelector(".search-tag-clear-tag").onclick = () => {
                removeSearchTag(index);
            };
        }

        searachState.tag.forEach((tag, index) => { // coloca as atgs na DOM
            let searchTagTemplate = document.importNode((document.querySelector(".search-tags-template")).content, true);
            searchTagTemplate.querySelector(".search-tag-title").innerHTML = tag.name;
            addFunctions(searchTagTemplate, index);
            searchTagPath.appendChild(searchTagTemplate);
        })
    }
} 

const requestServices = async () => { // cuida da requisaicao de servicos
    let idToExlucde = [];
    let maxDist = 0;
    console.log(serviceState.allservices)

    serviceState.allservices.forEach((elem) => {
        if(elem.distance > maxDist){
            maxDist = elem.distance;
            idToExlucde = [elem.serviceID];
        }
        else if(elem.distance === maxDist){
            idToExlucde.push(elem.serviceID);
        }
    });

    console.log(idToExlucde)
 

    let req = new XMLHttpRequest(); 

    let subCatid = []; // array responsavel por copiar os ids das subcategorias selecionadas, para enviar na requisicao
    searachState.tag.forEach(elem => {
        subCatid.push(elem.id);
    });

    const config = { // configuracoes de requisicao
        getServices: true,
        dataServices: {
            quantity : 5,
            maxDist: 100000000000000000000,
            minDist: maxDist,
            myLat: -23.87669,
            myLng: -46.77125,
            subCat: subCatid,
            searchWords: searachState.write,
            service_idToExlucde : idToExlucde || []
        }
        
    };

    

    req.onload = () => {
        // console.groupCollapsed('response');
        // console.log(req.response);
        // console.log(JSON.parse(req.response))
        // console.groupEnd();



        

        let responseData = JSON.parse(req.response);
        let responseInfo =  responseData.services.statusInfo;
        responseData = responseData.services.data;

        let gottenServices = [];

        for(let prop in responseData){ // percorre todos os elemtnos da requisicao
            let elem = responseData[prop];

            let nota_media = elem.nota_media_servico;
            if(!((typeof elem.nota_media_servico === "number") || (typeof elem.nota_media_servico === "string"))) nota_media = 0;

            gottenServices.push({ // adiciona os dados dos servicos recebidos ao array que sera enviado para impressao na DOM
                serviceID: elem.id_servico,
                imgSRC: `../../../assets/images/users/${elem.imagem_usuario}`,
                location: `${elem.uf_usuario}, ${elem.cidade_usuario}, ${elem.bairro_usuario}`,
                serviceName: elem.nome_servico,
                providerName: elem.nome_usuario,
                avaliation: nota_media,
                avaliationQuant: 1,
                price: `${elem.orcamento_servico} ${elem.crit_orcamento_servico}`,
                distance: Number(elem.distance)
            });
        }
        
        //atualiza o estado dos servicos
        // let allServicesTemp = servicesSate.allServices;
        // allServicesTemp = allServicesTemp.concat(gottenServices);
        // servicesSate.allServices = allServicesTemp;

        // console.groupCollapsed("before-aferter-all-services")
        // console.log(gottenServices)
        // console.log(servicesSate.allServices)
        // console.log(allServicesTemp)
        // console.log(`were excluded ->> ${servicesSate.service_idToExlucde}` )
        // console.log(`State service ->> `)
        // console.log(servicesSate);
        // console.groupCollapsed('response');
        // console.log(req.response);
        // console.log(JSON.parse(req.response))
        // console.groupEnd();
        // console.groupEnd();

        // setServiceState({services: gottenServices, lastDistance: responseInfo.maxDistance, endedResult: responseInfo.ended});
        console.log(gottenServices);
        setServiceState(
            {
                servicesToAdd: gottenServices,
                lastDistance: responseInfo.maxDistance,
                endedSearch: responseInfo.ended
            }
        );

                  
       // console.log("response bruta", req.response)
        console.log("response", JSON.parse(req.response))
        console.log("state", serviceState)

      

       
        const requestUntilScroll = () => { // faz requisicoes ate preencher a tela e gerar um scroll. 
            let contentSection = document.querySelector("#contentSection");
            let serviceCardsPath = document.querySelector(".service-cards-path");
            let viewHeight = contentSection.clientHeight - document.querySelector("#mySearchBarSection").clientHeight -  document.querySelector("#searchTagSection").clientHeight - document.querySelector("#filterSection").clientHeight;
            // viweHieght eh o tamanho que a div ocupa na tela na visualizacao

            if(!servicesSate.endedResult && (viewHeight >= serviceCardsPath.clientHeight)){ // se nao acabaram os servicos, e se a altura a ser ocupada ainda eh maior que a real altura
                setTimeout(requestServices, 500);
                // requestServices();
            //     console.groupCollapsed("Resquest More")
            //     console.log(`[!servicesSate.endedResult ->> ] ${!servicesSate.endedResult}`);
            //     console.log(`[viewHeight ->> ] ${viewHeight}`);
            //     console.log(`[serviceCardsPath.clientHeight ->> ] ${serviceCardsPath.clientHeight}`);
            //    console.groupEnd();
            }
            else{
            //    console.groupCollapsed("RNOT REQUEST MORE!!!!")
            //     console.log(`[!servicesSate.endedResult ->> ] ${!servicesSate.endedResult}`);
            //     console.log(`[viewHeight ->> ] ${viewHeight}`);
            //     console.log(`[serviceCardsPath.clientHeight ->> ] ${serviceCardsPath.clientHeight}`);
            //    console.groupEnd();
            }
        }
       

        // requestUntilScroll();
        //console.log(servicesSate)

    }

    req.open("POST", './getAsyncDataList.php');

    req.send(JSON.stringify(config));
}

let maxSearchScrool = 0;
const handleScroolSearch = () => { // cuida de fazer novas requisicoes ao scrollar a pg
    
    let section = document.querySelector("#serviceCadsSection");
    section.onscroll = () => {
        if((section.scrollTop + section.clientHeight > section.scrollHeight - 300) && !serviceState.endedSearch){
            // o tanto que a pessoa scrollou + a altura do conteiner recisa cjhegar ao fim para fazer uma nova requisicao.
            requestServices();
        }
        else{
            // console.groupCollapsed("TERMINOU OS SERVICOS");
            // console.log(`[Section Scroll top] ->> ${section.scrollTop}`);
            // console.log(`[Section cleint height] ->> ${section.clientHeight}`);
            // console.log(`[Section Scroll height] ->> ${section.scrollHeight}`);
            // console.groupEnd();
            console.log("TERMINOU!!!!!!!!!!!!!!!!!!!!")
            console.log(serviceState)
        }
       
    }
}
handleScroolSearch();

const refreshSearch = () => {
    refreshTagsArea();
    let serviceCadrPath_e = document.querySelector('.service-cards-path');

    // servicesSate.service_idToExlucde = [];
    // servicesSate.lastDistance =0;

    // setServicesSate({
    //     services :[],
    //     lastDistance : 0,
    //     endedResult: false , 
    //     service_idToExlucde: [],
    //     allServices: []
    // });
    setServiceState({
        allservices :[],
        lastDistance : 0,
        endedSearch: false , 
        service_idToExlucde: [],
        allservices: []
    });

    
    if(!(searachState.tag.length ==0 && searachState.write == ""))
    requestServices();

}

function setSearchState(data){
    if(! typeof data === "object") {
        console.log("[setSearchState] --> wrong type of data");
        return;
    }

    for(let i in data){
        searachState[i] = data[i];
    }

    // setServicesSate({allServices : [], services :[]});

    refreshSearch();
}

const toggleCategoriesSidebar = () => {
    let state = {
        selected: false
    };
    let backdrop = document.querySelector('.categories-backdrop');
    let sidebar = document.querySelector('.categoriesSection');
    let btnToggler = document.querySelectorAll('.my-categories-toggle-btn');
    let body = document.querySelector('body');

    const refresShowSidebar = () => {
       
        if(state.selected){
            sidebar.classList.add('show-sidebar');
            sidebar.classList.remove('hide-sidebar');

            backdrop.classList.add('show');
            body.style.overflow = "hidden";
        }
        else{
            sidebar.classList.add('hide-sidebar');
            sidebar.classList.remove('show-sidebar');

            backdrop.classList.remove('show');
            body.style.overflow = "auto";
        }
    }

    refresShowSidebar();

    const refreshAll = () => {
        console.log(state)
        refresShowSidebar();
    }

    const setState = (obj) => {
        if(!typeof obj === 'object')
            return;

        for(let i in obj){
            state[i] = obj[i]
        }

        refreshAll();
    }

    const btnTogglerHandler = () => {
        let tempSate = !state.selected;
        setState({selected: tempSate});

        document.querySelector('.categoriesSection').style.transition = "transform 0.5s";
    }

    backdrop.onclick = () => {
        let tempState = state.selected;
        setState({selected: !tempState});
    }

    btnToggler.forEach((toggler) => {
        toggler.onclick = btnTogglerHandler;
    });

};

toggleCategoriesSidebar();

const categoriesScrollHandler = () => {
    document.querySelector(".categoriesSection").scrollTop = 0;
    document.querySelector(".categoriesSectionBody").scrollTop = 0;
    
}

const mediumScreen = window.matchMedia("(min-width: 768px)");
categoriesScrollHandler();
mediumScreen.addListener(categoriesScrollHandler);

const fillCategories = (data) => {
    if(!typeof data === 'array') return;

    let listPath = document.querySelector('.categoriesSectionBody');

    const categorieItem = (item) => {
        let categorieNode = document.importNode(document.querySelector("#myCategorieItemTemplate").content, true);
        let subCategorieNode = document.importNode(document.querySelector("#mySUBCategorieItemTemplate").content, true);

        if(! typeof item === 'object') return;

        let DOM = {
            categorie : {
                name: categorieNode.querySelector('.categorieName'),
                arrow: categorieNode.querySelector('.categorieArrow')
            },
            subCategorie: {
                title: subCategorieNode.querySelector('.subCategorie-section-title'), 
                body: subCategorieNode.querySelector('.subCategorieBody'),
                subItem: subCategorieNode.querySelector('.subCategorie-item'),
                subItemTitle: subCategorieNode.querySelector('.subCategorie-title')
            }
        }

        DOM.categorie.name.innerHTML = item.categorie.title;
        DOM.subCategorie.title.innerHTML = item.categorie.title;
        let subCategorieItems = [];

        const addSubItemsFunction = (subItem, index) => {
            subItem.onclick = () => {
                
                let subTitle = subItem.querySelector('.subCategorie-title').innerHTML;
                let subCtaegorieID = item.categorie.subItems[index].id;

                let tagExists = false;
                searachState.tag.forEach((elem) => {
                    if(elem.id == subCtaegorieID) tagExists = true;
                });

                if(tagExists){
                    removeSearchTag(subCtaegorieID);
                    subItem.classList.remove("sucategorie-selected");
                }
                else{
                    addSearchTag(subTitle, subCtaegorieID);
                    subItem.classList.add("sucategorie-selected");
                }
            }
            
        }
        
        item.categorie.subItems.forEach((subItem, index) => {
            let subItem_e = document.importNode(DOM.subCategorie.subItem, true);
            let subTitle_e = subItem_e.querySelector('.subCategorie-title');
            
            subTitle_e.innerHTML = subItem.title;
            if((index + 1) % 2 === 0){
                subTitle_e.classList.add('right-col');
                subTitle_e.classList.remove('left-col');
            }
            else{
                subTitle_e.classList.add('left-col');
                subTitle_e.classList.remove('right-col');
            }

            addSubItemsFunction(subItem_e, index);
            subCategorieItems.push(subItem_e);
        });

        const addFunctions = (item) => {
            let categorieDiv = item.querySelector('.categorie-item');
            let subCategorieDiv = item.querySelector('.subcategorie-container');
            let arrow = item.querySelector('.categorieArrow');

            categorieDiv.onclick = () => {
                let active = false;
                if(subCategorieDiv.classList.contains('subcategorie-active')){
                    active = true;
                }

                let DOMsubcategories = document.querySelectorAll('.subcategorie-container');
                DOMsubcategories.forEach((elem) => {
                    elem.classList.remove('subcategorie-active');
                });
                let DOMcategories = document.querySelectorAll('.categorie-item');
                DOMcategories.forEach((elem) => {
                    elem.classList.remove('categorie-item-active');
                });
                let DOMarrows = document.querySelectorAll('.categorieArrow');
                DOMarrows.forEach((elem) => {
                    elem.classList.remove('rotate-categorie-item');
                });

                if(!active){
                    subCategorieDiv.classList.add('subcategorie-active');
                    categorieDiv.classList.add('categorie-item-active');
                    arrow.classList.add('rotate-categorie-item')
                }

                
            }
        }
        

        DOM.subCategorie.body.innerHTML = "";
        subCategorieItems.forEach((elem) => {
            DOM.subCategorie.body.appendChild(elem);
        });

        let wrapper = document.createElement('div');
        wrapper.classList.add('wrapper-categorie-subcategorie');
        wrapper.append(categorieNode, subCategorieNode);

        addFunctions(wrapper);

        return wrapper;
    }

    /*const bla = [
        {
            categorie : {
                title: "categorieName",
                subItems : [
                    {title: 'subCategorie1'},
                    {title: 'subCategorie1'},
                    {title: 'subCategorie1'},
                ]
            }
        }
    ]*/

    data.forEach((item) => {
        listPath.appendChild(categorieItem(item));
    });
}

const serviceCardsRender = (data) => {
    if(! (typeof data === 'object')){
        console.log('[serviceCardsRender] --> wrong type of data');
        return;
    }

    let serviceCard_e = document.querySelector('#serviceCardTemplate').content;
    let serviceCadrPath_e = document.querySelector('.service-cards-path');

    const serviceCard = (info) => {
        if(! (typeof info === 'object')){
            console.log('[serviceCard] --> wrong type of data');
            return;
        }

        let node = document.importNode(serviceCard_e, true);

        let structureDOM = {
            providerName: node.querySelector('.service-card-provider-name'),
            serviceName: node.querySelector('.service-card--service-name'),
            location: node.querySelector('.service-location'),
            price: node.querySelector('.service-card--price')
        };

        let structureData = {
            serviceID: '',
            imgSRC: '',
            avaliation: 0,
        }

        const dataHandler = () => {
            let nodeLink = node.querySelector('.service-card-link');
            let link = `../VisualizarServico/visuaizarServico.php?serviceID=${structureData.serviceID}`;
            nodeLink.href = link;
            nodeLink.setAttribute("serviceID", structureData.serviceID);

            let stars = node.querySelectorAll('.service-card--rate-stars path');

            stars.forEach(star => {
                star.setAttribute('fill', '#ccc');
            })
            for(let i = 0; i < Math.round(structureData.avaliation) && i < stars.length; i++){
                stars[i].setAttribute('fill', '#FF9839');
            }
            node.querySelector('.service-card--avaliation-quantity').innerHTML = `(${parseFloat(structureData.avaliation).toFixed(2)})`;

            const imgHandler = () => {
                let profileIMG = new Image();
                profileIMG.classList.add('service-card--profile-img');
                let imgDiv = node.querySelector('.service-card--profile-img-div');

                profileIMG.onload = () => {
                    imgDiv.innerHTML = "";
                    imgDiv.appendChild(profileIMG);
                    imgDiv.classList.remove('loading');
                };

                profileIMG.src = structureData.imgSRC;

            }

            imgHandler();
        }

        const fillData = () => {
            for(let i in structureData){
                if(info[i]) structureData[i] = info[i];
            }

            dataHandler();
        }

        for(let i in structureDOM){
            if(info[i]) structureDOM[i].innerHTML = info[i];
        }

        fillData();

        return node;
        
    }

    data.forEach(item => {
        let node = serviceCard(item);
        serviceCadrPath_e.appendChild(node);
    });

}
/*
const serviceCardData = [
    {
        serviceID: '10',
        imgSRC: 'https://picsum.photos/2000?random=1',
        location: 'rua pequetita vila olimpia',
        serviceName: 'nome do servico kk',
        providerName: 'nome do cara lá',
        avaliation: 2.49,
        avaliationQuant: 90,
        price: '30 por cabeça'
    },
];

const emptyServiceData = {
    serviceID: '10',
    imgSRC: ' ',
    location: ' ',
    serviceName: ' ',
    providerName: ' ',
    avaliation: 1,
    avaliationQuant: 0,
    price: ' '
}
*/
/*
const categories = [
    {
        categorie : {
            title: "pato",
            subItems : [
                {title: 'sub pato wsub pato wsub pato wsub pato wsub pato wsub pato wsub pato wsub pato w'},
                {title: 'sub pato 2'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
            ]
        }
    },
    {
        categorie : {
            title: "pato",
            subItems : [
                {title: 'sub pato w'},
                {title: 'sub pato 2'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
            ]
        }
    }
];*/

const prepareCatgories = (resp_cat) => {
    resp_cat = resp_cat.categoires

    let cat = [];

    for(let i in resp_cat){
        cat.push({
            categorie :{
                title: resp_cat[i].title,
                id: i,
                subItems : []
            }
        });

        for(let subItemIndex in resp_cat[i]["sub"]){
            cat[cat.length - 1].categorie.subItems.push({
                title : resp_cat[i].sub[subItemIndex],
                id : subItemIndex
            });
        }
    }
    fillCategories(cat);
   
}


const getCategoriesName = () => {
    let req = new XMLHttpRequest();

    const config = {
        getCategories: true
    };

    req.onload =() => {
        console.log(req.response);
        prepareCatgories((JSON.parse(req.response)));
    }

    req.open("POST", './getAsyncDataList.php');

    req.send(JSON.stringify(config));
}

document.querySelector("#searchButton").onclick = () => {
    let text = document.querySelector("#searchBar").value;
    text = text.trim();

    let spliText = text.split(" ")
    if(text == "") spliText = [];   

    let serviceCardsPath = document.querySelector(".service-cards-path");
    serviceCardsPath.innerHTML = "";

    setSearchState({write : spliText});
    
};

var servicesSate = {
    services :[],
    lastDistance : 0,
    endedResult: false , 
    service_idToExlucde: [],
    allServices: []
};

const getService_idToExclude = () => { // gurda os ids dos ervicos que possuem a distancia == maxDistance. Isso serve para excluir sua busca na proxima requisicao 
    let services = servicesSate.allServices;

    let maxDistance = 0;
    let service_idToExlucdeTemp = [];
    services.forEach((elem) => {
        // console.log(elem)
        if(elem.distance > maxDistance){
            maxDistance = elem.distance;
            service_idToExlucdeTemp = [elem.serviceID];

            // console.groupCollapsed("else")
            // console.log(elem.distance)
            // console.log(maxDistance)
            // console.log(maxDistance - elem.distance)
            // console.groupEnd();
        }
        else if(elem.distance == maxDistance){
            service_idToExlucdeTemp.push(elem.serviceID);
        }
        else{
            
        }

        // console.groupCollapsed("a")
        // console.log(elem.distance)
        // console.log(maxDistance)
        // console.log(elem.serviceID)
        // console.groupEnd();
    });

    console.groupCollapsed("id-to-exclude-function")
    console.log(service_idToExlucdeTemp)
    console.groupEnd();

    servicesSate.service_idToExlucde = service_idToExlucdeTemp;
}


/*
const refreshServicesAll = (refresh) => {
    refresh.forEach((elem) => {
        if(elem == "services")
            serviceCardsRender(servicesSate.services);
    });

    
    getService_idToExclude();
    
}

function setServicesSate (data)  {
    let stateToRefresh = [];

    for(let i in data){
        stateToRefresh.push(i);

        servicesSate[i] = data[i]
    }

    refreshServicesAll(stateToRefresh);
}*/

getCategoriesName();

