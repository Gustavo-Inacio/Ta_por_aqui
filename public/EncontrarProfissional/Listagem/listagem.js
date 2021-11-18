var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl)
})

var permitSearch = true; // tem a funcao de permitar que uma nova requisicao seja feita somente depois que for terminada a requisicao atual

let apiKey = '2BHqTlrrRZyJOYbFEl47yRbagjjwSaY-Eu3iriuEgvY';

let filterState = {
    type : 0 // 0 = filtrar por proximidade | 1 = filtrar por avaliacao
}

const refreshFilter = () => {
    if(filterState.type == 0){
        document.querySelector("#filterCloser").classList.remove("active");
        document.querySelector("#filterBestAva").classList.add('active');
    }
    else{
        document.querySelector("#filterBestAva").classList.remove("active");
        document.querySelector("#filterCloser").classList.add('active');
    }

    setSearchState({});
}

const setFilterState = (data) => {
    for(let i in data){
        filterState[i] = data[i];
    }

    refreshFilter();
}

document.querySelector("#filterBestAva").onclick = () => {
    // setFilterState({type: 1});
    setSearchState({bestAvaliation: 1});
}
document.querySelector("#filterCloser").onclick = () => {
    // setFilterState({type: 0});
    setSearchState({bestAvaliation: 0});
}

let serviceState = {
    allservices : [],
    servicesToAdd: [],
    maxDistance : 0,
    endedSearch: false
}

let tempPosition = {
    tempLat: false,
    tempLng: false,
    logradouro: false
}

function setTempPosition(data) {
    for (let i in data){
        tempPosition[i] = data[i]
    }

    if (tempPosition.tempLat !== false || !tempPosition.tempLng !== false){
        //pegar nome da rua apartir da coordenada
        let xhr = new XMLHttpRequest()
        xhr.open('GET', `https://revgeocode.search.hereapi.com/v1/revgeocode?at=${tempPosition.tempLat},${tempPosition.tempLng}&apiKey=${apiKey}`)
        xhr.onreadystatechange = () => {
            if (xhr.readyState == 4 && xhr.status == 200){
                let tempLocation = JSON.parse(xhr.response)
                // console.log(tempLocation)
                document.getElementById('showTempLocation').innerHTML = `<span>Usando localização temporária: </span> <strong>${tempLocation.items[0].address.label}</strong>`
            }
        }
        xhr.send()
    }
}

function refreshServices ()  {
    serviceState.allservices = serviceState.allservices.concat(serviceState.servicesToAdd);
    serviceCardsRender(serviceState.servicesToAdd);
    serviceState.servicesToAdd = [];
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

    console.log('[setServiceState]')
}

let searachState = {
    tag : [
        // {
        //     id : null,
        //     name :''
        // }
    ],
    write : [],
    bestAvaliation: 0
};


const removeSearchTag = (index) => { // cuida da remocao da tag ao clicar no close dela. Recebe o id da subCategoria
    let tagTemp = searachState.tag; 
    let arrayIndex;
    tagTemp.forEach((tag, i) => { // acha o index da tag dentro do array
        if(tag.id == index) arrayIndex = i;
    });

    tagTemp.splice(arrayIndex, 1); // elimina aquela posicao do array
    setSearchState({tag: tagTemp}); // atualiza as categorias na pesquisa
}

const addSearchTag = (index, tagName) => { // cuida de add uma atg na pesquisa 
    let tagTemp = searachState.tag; // copia o estado atual
    tagTemp.push({ // adiciona o nome da tag e o seu id (id_subcategoria)
        id: index,
        name: tagName
    });

    setSearchState({tag: tagTemp}); // atualizao estado atual
}

const toggleSearchTag = ({index, name}) => {
    // console.log(searachState)
    if(searachState.tag.length > 0){
        let alreadyExists = false;
        for(let i in searachState.tag){

            if(searachState.tag[i].id == index){
                alreadyExists = true;
            }
        }

        if(alreadyExists){
            removeSearchTag(index);
        }
        else{
            addSearchTag(index, name);
        }
    }
    else{
        addSearchTag(index, name);
        // console.log(index, name)
    }

    if ((searachState.tag.length) === 0){
        document.querySelector('.service-cards-path').innerHTML = '<div class="beforeSearch">\n' +
            '                            <h3>Para fazer uma pesquisa</h3>\n' +
            '\n' +
            '                            <ul>\n' +
            '                                <li>Faça o uso da <strong>barra de pesquisa</strong> ou <strong>tabela de categorias</strong></li>\n' +
            '                                <li><strong>Filtre por:</strong> <span>Mais próximos <i class="fas fa-long-arrow-alt-up"></i></span> <span>Melhor avaliado <i class="fas fa-long-arrow-alt-up"></i></span> para que tenha a <strong>melhor escolha custo benefício</strong></li>\n' +
            '                            </ul>\n' +
            '                        </div>'
    }
}

const paintSelectedSubcat = () =>{
    let selectedIDs = [];

    searachState.tag.forEach((elem) => {
        selectedIDs.push(elem.id);
    });


    document.querySelectorAll('.subcat-item').forEach((subcat) => {
        let selected = false;
        selectedIDs.forEach((id) => {
            if(subcat.getAttribute('id') == id){
                selected = true;
            }
        });

        if(selected) subcat.classList.add("selected");
        else subcat.classList.remove("selected");
        
    });
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
            <i class="fas fa-trash"></i>

            <label>limpar Seleção</label>
        </div>
        `;

        let clearAllTags = document.querySelector(".clear-tags-div");
        clearAllTags.onclick = () => { // ação de eliminar todas as tags juntas e voltar msg de query vazia
            setSearchState({tag: []});
            document.querySelector('.service-cards-path').innerHTML = '<div class="beforeSearch">\n' +
                '                            <h3>Para fazer uma pesquisa</h3>\n' +
                '\n' +
                '                            <ul>\n' +
                '                                <li>Faça o uso da <strong>barra de pesquisa</strong> ou <strong>tabela de categorias</strong></li>\n' +
                '                                <li><strong>Filtre por:</strong> <span>Mais próximos <i class="fas fa-long-arrow-alt-up"></i></span> <span>Melhor avaliado <i class="fas fa-long-arrow-alt-up"></i></span> para que tenha a <strong>melhor escolha custo benefício</strong></li>\n' +
                '                            </ul>\n' +
                '                        </div>'
        };  

        const addFunctions = (node, index) => { // add a funcao de fechar as tags
            node.querySelector(".search-tag-clear-tag").onclick = () => {
                removeSearchTag(index);

                if (searachState.tag.length === 0){
                    document.querySelector('.service-cards-path').innerHTML = '<div class="beforeSearch">\n' +
                        '                            <h3>Para fazer uma pesquisa</h3>\n' +
                        '\n' +
                        '                            <ul>\n' +
                        '                                <li>Faça o uso da <strong>barra de pesquisa</strong> ou <strong>tabela de categorias</strong></li>\n' +
                        '                                <li><strong>Filtre por:</strong> <span>Mais próximos <i class="fas fa-long-arrow-alt-up"></i></span> <span>Melhor avaliado <i class="fas fa-long-arrow-alt-up"></i></span> para que tenha a <strong>melhor escolha custo benefício</strong></li>\n' +
                        '                            </ul>\n' +
                        '                        </div>'
                }
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
    if(permitSearch){
        permitSearch = false;

        const addSpinner = () => { // adicona o spinner para mostrar que a reuisicao foi feita. Quando ela for finalizada, o spinner eh removido
            let spinner = `
            <div class="text-center my-5">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;

            let serviceSpinnerContainer = document.querySelector(".service-cards-loading-container");
            serviceSpinnerContainer.innerHTML = spinner;
        }
        addSpinner();

        let idToExlucde = [];
        let maxDist = 0;
        // minDist


        serviceState.allservices.forEach((elem) => { // cuida de selecionar os ids dos servicos que possuem a distancia exata de menor distancia a ser pesquisada na requisicao. A fim de evitar repeticoes
            if(elem.distance > maxDist){ // caso eu tenha um servico cuja distancia seja maior que a maior distanca, ele eh maior que todos os outros, portanto, deixe somente ele na array
                maxDist = elem.distance;
                idToExlucde = [elem.serviceID];
            }
            else if(elem.distance == maxDist){ // caso ele tenha a distanca equivalente a maior distancia ja encontrada, ele tambem deve ser incluido na query de exlucsao
                idToExlucde.push(elem.serviceID);
            }

        });

        let req = new XMLHttpRequest(); 

        let subCatid = []; // array responsavel por copiar os ids das subcategorias selecionadas, para enviar na requisicao
        searachState.tag.forEach(elem => {
            subCatid.push(elem.id);
        });

        let filterBestAva = 'false';

        if(searachState.bestAvaliation == 1) filterBestAva = 'true';

        const config = { // configuracoes de requisicao
            getServices: true,
            dataServices: {
                bestAvaliation: filterBestAva,
                quantity : 2,
                maxDist: 100000000000000000000,
                // minDist: maxDist,
                minDist: searachState.bestAvaliation  == 1 ? 0 : maxDist,
                myLat: Number(tempPosition.tempLat),
                myLng: Number(tempPosition.tempLng),
                subCat: subCatid,
                searchWords: searachState.write,
                service_idToExlucde : idToExlucde || []
            }
        };

        console.log(config)

        // console.log(config)

        req.onload = () => {
            // console.log(req.response)
            let responseData = JSON.parse(req.response);
            console.log(responseData)
            let responseInfo =  responseData.services.statusInfo;
            responseData = responseData.services.data;
            

            let gottenServices = [];

            for(let prop in responseData){ // percorre todos os elemtnos da requisicao
                let elem = responseData[prop];

                let nota_media = elem.nota_media_servico;
                if(!((typeof elem.nota_media_servico === "number") || (typeof elem.nota_media_servico === "string"))) nota_media = 0;

                if(elem.orcamento_servico == null || !elem.orcamento_servico){
                    elem.orcamento_servico = "";
                }

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

            // console.log(gottenServices)
            
            setServiceState(
                {
                    servicesToAdd: gottenServices,
                    lastDistance: responseInfo.maxDistance,
                    endedSearch: responseInfo.ended
                }
            );
        
            const requestUntilScroll = () => { // faz requisicoes ate preencher a tela e gerar um scroll. 
                let contentSection = document.querySelector("#contentSection");
                let serviceCardsPath = document.querySelector(".service-cards-path");
                let viewHeight = contentSection.clientHeight - document.querySelector("#mySearchBarSection").clientHeight -  document.querySelector("#searchTagSection").clientHeight - document.querySelector("#filterSection").clientHeight;
                // viweHieght eh o tamanho que a div ocupa na tela na visualizacao

                if(!serviceState.endedSearch && (viewHeight >= serviceCardsPath.clientHeight)){ // se nao acabaram os servicos, e se a altura a ser ocupada ainda eh maior que a real altura
                    requestServices();
                }
               
            }
        
            requestUntilScroll(); 
            let serviceSpinnerContainer = document.querySelector(".service-cards-loading-container");
            serviceSpinnerContainer.innerHTML = ""; // remove spinner
            permitSearch = true; // requisicao acabou, etntao esta permitido fazer outra
        
        }

        req.open("POST", './getAsyncDataList.php');

        req.send(JSON.stringify(config));
    }
}

const handleScroolSearch = () => { // cuida de fazer novas requisicoes ao scrollar a pg
    
    let section = document.querySelector("#serviceCadsSection");
    section.onscroll = () => {
        if((section.scrollTop > section.scrollHeight - 1000) && !serviceState.endedSearch){
            // o tanto que a pessoa scrollou + a altura do conteiner recisa cjhegar ao fim para fazer uma nova requisicao.
            requestServices();
        }

       
    }
}
handleScroolSearch();

const refreshSearch = () => {
    refreshTagsArea();
    paintSelectedSubcat();
    let serviceCadrPath_e = document.querySelector('.service-cards-path');
    serviceCadrPath_e.innerHTML = "";

    let inputBestAva = document.querySelector("#bestAva");
    console.log(searachState.bestAvaliation)
    inputBestAva.value = searachState.bestAvaliation;

    if(searachState.bestAvaliation == 0){
        document.querySelector("#filterBestAva").classList.remove("active");
        document.querySelector("#filterCloser").classList.add('active');
    }
    else{
        document.querySelector("#filterCloser").classList.remove("active");
        document.querySelector("#filterBestAva").classList.add('active');
    }

    if ((serviceState.allservices.length) === 0){
        document.querySelector('.service-cards-path').innerHTML = '<div class="beforeSearch">\n' +
            '                            <h3> O servico que esta procurando pode não ter sido encontrado. Para fazer uma pesquisa</h3>\n' +
            '\n' +
            '                            <ul>\n' +
            
            '                                <li>Faça o uso da <strong>barra de pesquisa</strong> ou <strong>tabela de categorias</strong></li>\n' +
            '                                <li><strong>Filtre por:</strong> <span>Mais próximos <i class="fas fa-long-arrow-alt-up"></i></span> <span>Melhor avaliado <i class="fas fa-long-arrow-alt-up"></i></span> para que tenha a <strong>melhor escolha custo benefício</strong></li>\n' +
            '                            </ul>\n' +
            '                        </div>'
    }


    
    setServiceState({
        allservices : [],
        lastDistance : 0,
        endedSearch: false , 
        service_idToExlucde: [],
        minDist:0
    });

    console.log('refreshSeacrh', searachState)

    
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

    console.log(data)

    //  setServiceState({allServices : [], services :[]});

    refreshSearch();
}

  

const toggleCategoriesSidebar = () => {
    let state = {
        selected: false
    };
    let backdrop = document.querySelector('.categories-backdrop');
    let sidebar = document.querySelector('#cat-container');
    let btnToggler = document.querySelectorAll('.my-categories-toggle-btn');
    let body = document.querySelector('body');

    // console.log(sidebar)

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
        // console.log(state)
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

        sidebar.style.transition = "transform 0.5s";
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
//toggleCategoriesSidebar();

const categoriesScrollHandler = () => {
    let sidebar = document.querySelector("#sidebar");
    let catContainer = document.querySelector("#cat-container");

    let catNode = catContainer.innerHTML;
    sidebar.innerHTML = "";
    sidebar.innerHTML = catNode;
}


// const mediumScreen = window.matchMedia("(min-width: 768px)");
// //categoriesScrollHandler();
// mediumScreen.addListener(categoriesScrollHandler);

const fillCategories = (data) => {
    if(!typeof data === 'array') return;

    // console.log(data)
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

    data.forEach((item) => {
        listPath.appendChild(categorieItem(item));
    });
}

const serviceCardsRender = (data) => {
    if(! (typeof data === 'object')){
        // console.log('[serviceCardsRender] --> wrong type of data');
        return;
    }

    let serviceCard_e = document.querySelector('#serviceCardTemplate').content;
    let serviceCadrPath_e = document.querySelector('.service-cards-path');

    const serviceCard = (info) => {
        if(! (typeof info === 'object')){
            // console.log('[serviceCard] --> wrong type of data');
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
    //fillCategories(cat);
   
}

const arrangeNewCategories = (data) => {
    data = data.categoires;

    let categorie_e = document.querySelector(".cool-categories-section");
    let categoriesSpanContainer = document.createElement('span');

    let categoriesState = {
        selected : -1,
    }

    const fillsubCat = () => {
        // console.log(categoriesState)
        let subcat = data[categoriesState.selected].sub;
        let content = document.querySelector('.subcat-view .content');
        content.innerHTML = "";

        const addSubcatFuntions = (node, data) => {
            node.onclick = () => {
                
                // console.log(node);
                toggleSearchTag({index: data.id, name: data.name});

                // let tagsTemp = searachState.tag;
                // tagsTemp.push({id: data.id, name: data.name});

                // setSearchState({tag: tagsTemp});
                // console.log(searachState)
            }
        }

        for(let i in subcat){
            let html = `
                <div class="subcat-item col-12" id="${i}">
                    <label>${subcat[i]}</label>
                </div>
            `;

            let dumbSpan = document.createElement("span");
            dumbSpan.innerHTML = html;
            let node = dumbSpan.querySelector('.subcat-item');
        
            addSubcatFuntions(node, {id: i, name: subcat[i]});

            content.appendChild(node);
        }
        
    }

    const refreshCategories = () => {
        let catItems = categorie_e.querySelector(".cat-view").querySelectorAll('.cat-item');
        if(categoriesState.selected !== -1){
            
            catItems.forEach((elem) => {
                if(Number(elem.getAttribute('id')) === categoriesState.selected){
                    let subCatView = document.querySelector('.subcat-view');
                   
                    subCatView.classList.add('selected');

                    let subCatViewHeader = subCatView.querySelector("header");
                    subCatViewHeader.style.marginBottom = `${15 + elem.getBoundingClientRect().height + 10}px`;

                    elem.classList.add('selected');
                    let marginTop = `${10 + subCatViewHeader.getBoundingClientRect().height}`;
                    let transform = `translateY(${(elem.offsetTop - marginTop) * -1}px)`;
               
                    elem.style.transform = transform;
                }else{
                    elem.classList.add('notSelected');
                }
            });

            
            fillsubCat();
        }
        else{
            catItems.forEach((elem) => {
                elem.style.transform = "";
                elem.classList.remove("selected");
                elem.classList.remove("notSelected");
            });
            
        }

    }

    const setCategoriesState = (data) => {
        for(let i in data){
            categoriesState[i] = data[i]
        }

        refreshCategories();
    }
    for(let i in data){
        let elem = data[i];
        let elemSpanContainer = document.createElement("span");
    
        let categorieInnerHTML = `
        <div class="row cat-item" id='${i}'>
            <div class="col">
                <p class="cat-text">${elem.title}</p>

                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.482 11.831L1.54814 5.89714C1.26195 5.61096 1.26195 5.14698 1.54814 4.86082L2.24023 4.16873C2.52592 3.88304 2.98896 3.88249 3.27532 4.16751L8.00018 8.87023L12.725 4.16751C13.0114 3.88249 13.4744 3.88304 13.7601 4.16873L14.4522 4.86082C14.7384 5.14701 14.7384 5.61099 14.4522 5.89714L8.51835 11.831C8.23217 12.1172 7.76819 12.1172 7.482 11.831Z" fill="#3333CC"/>
                </svg>
            </div>
        </div>
        `;

        elemSpanContainer.innerHTML = categorieInnerHTML;

        const addFunctions = (i) => {
            elemSpanContainer.querySelector('.cat-item').onclick = () => {
                setCategoriesState({selected: Number(i)});

                // console.log("aa", searachState)
                paintSelectedSubcat();
            }

            categorie_e.querySelector(".back-to-main-menu").onclick = () => {
                setCategoriesState({selected: -1});


                categorie_e.querySelector(".subcat-view").classList.remove("selected");
                categorie_e.querySelector(".subcat-view").querySelector('.content').innerHTML = "";
            }
        }

        addFunctions(i);
        let node = elemSpanContainer.querySelector('.cat-item');

        categorie_e.querySelector(".cat-view").appendChild(node);
    }
   
    
}

const getCategoriesName = () => {
    let req = new XMLHttpRequest();

    const config = {
        getCategories: true
    };

    req.onload =() => {
        arrangeNewCategories(JSON.parse(req.response));
        prepareCatgories((JSON.parse(req.response)));
                
        // const mediumScreen = window.matchMedia("(min-width: 768px)");
        // //categoriesScrollHandler();
        // mediumScreen.addListener(() => {categoriesScrollHandler(JSON.parse(req.response))});
    }

    req.open("POST", './getAsyncDataList.php');

    req.send(JSON.stringify(config));
}


getCategoriesName();

document.getElementById('userAdressCEP').addEventListener('keyup', () => {
    let cep = document.getElementById('userAdressCEP').value
    if(cep.length === 8 && !isNaN(Number(document.getElementById('userAdressCEP').value))){
        //caso o input tenha 8 digitos ele chama a função passando já o value o cep
        let url = `https://viacep.com.br/ws/${cep}/json/unicode/`

        let ajax = new XMLHttpRequest()
        ajax.open('GET', url)

        ajax.onreadystatechange = () => {
            if(ajax.readyState == 4 && ajax.status == 200){
                let enderecoJSON = ajax.responseText

                //convertendo a resposta JSON em objeto
                enderecoJSON = JSON.parse(enderecoJSON)

                if(enderecoJSON.erro == true){
                    //tratativa de CEP invalido
                    let aviso = document.getElementById('cepError')
                    aviso.innerHTML = 'Digite um CEP valido'

                } else{
                    //retirando aviso caso exista
                    if(document.getElementById('cepError')){
                        document.getElementById('cepError').innerHTML = ''
                    }

                    //Colocando a resposta nos formulários
                    document.getElementById('userAdressCity').value = enderecoJSON.localidade
                    document.getElementById('userAdressState').value = enderecoJSON.uf
                    document.getElementById('userAdressStreet').value = enderecoJSON.logradouro
                    document.getElementById('userAdressNeighborhood').value = enderecoJSON.bairro
                }
            }
            if(ajax.readyState == 4 && ajax.status == 400){
                alert('Erro ao se conectar com os correios')
            }
        }
        ajax.send()
    } else {
        //Colocando a resposta nos formulários
        document.getElementById('userAdressCity').value = ''
        document.getElementById('userAdressState').value = ''
        document.getElementById('userAdressStreet').value = ''
        document.getElementById('userAdressNeighborhood').value = ''
    }
})

document.getElementById('btn-change-location').addEventListener('click', () => {
    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(position => {
            let ajax = new XMLHttpRequest()
            ajax.open('GET', `https://revgeocode.search.hereapi.com/v1/revgeocode?at=${position.coords.latitude},${position.coords.longitude}&apiKey=2BHqTlrrRZyJOYbFEl47yRbagjjwSaY-Eu3iriuEgvY`)

            ajax.onreadystatechange = () => {
                if(ajax.readyState == 4 && ajax.status == 200){
                    let enderecoJSON = ajax.responseText

                    //convertendo a resposta JSON em objeto
                    enderecoJSON = JSON.parse(enderecoJSON)

                    //Colocando a resposta nos formulários
                    document.getElementById('userAdressCEP').value = enderecoJSON['items'][0].address.postalCode.replace('-','')
                    document.getElementById('userAdressCity').value = enderecoJSON['items'][0].address.city
                    document.getElementById('userAdressState').value = enderecoJSON['items'][0].address.stateCode
                    document.getElementById('userAdressStreet').value = enderecoJSON['items'][0].address.street
                    document.getElementById('userAdressNeighborhood').value = enderecoJSON['items'][0].address.district
                    document.getElementById('userAdressNumber').value = enderecoJSON['items'][0].address.houseNumber

                } else if(ajax.readyState == 4 && ajax.status == 400){
                    alert('Erro ao se conectar com os correios')
                }
            }
            ajax.send()
        })
    }
})

let addressModal = document.getElementById('addressModal')
let myModal = new bootstrap.Modal(addressModal)

document.getElementById('changeLocationForm').addEventListener('submit', event => {
    //previnir reload
    event.preventDefault()

    //Validar campos
    let valid = true
    let errorMsg = ""

    //CEP com 8 caracteres
    let userAdressCEP = document.getElementById('userAdressCEP')
    if (userAdressCEP.value.length !== 8){
        valid = false
        errorMsg = "CEP inválido. Siga o padrão do exemplo"

        userAdressCEP.classList.add("is-invalid")
    } else{
        userAdressCEP.classList.remove("is-invalid")
    }

    //Todos os campos obrigatórios preenchidos
    Array.from(document.getElementsByClassName("requiredAdressData")).forEach((el) => {
        if (el.value === ""){
            el.classList.add('is-invalid')
            valid = false
            errorMsg = "Preencha todos os campos"
        } else {
            el.classList.remove('is-invalid')
        }
    });

    document.getElementById('adressInfoError').innerText = errorMsg
    if (valid){
        //Pegar coordenadas de acordo com os dados de endereço do formulário
        let data = []
        Array.from(document.getElementsByClassName('requiredAdressData')).forEach((el, i) => {
            data[i] = el.value.trim()
            //unaccent
        })

        // let q = `${data[4]}%2C+${data[0]}+${data[2]}%2C+${data[1]}+Brasil`
        let qq = `country='Brazil';city=${data[2]};district=${data[3]};street=${data[4]};state=${data[1]};postalCode=${data[0]}`

        let xhr = new XMLHttpRequest()
        xhr.open('GET', `https://geocode.search.hereapi.com/v1/geocode?qq=${qq}&apiKey=${apiKey}`)
        document.getElementById('saveTempAdressBtn').innerHTML = 'Salvar endereço temporário <div class="spinner-border" role="status" style="width: 16px; height: 16px"></div>'
        document.getElementById('saveTempAdressBtn').disabled = 'disabled'
        xhr.onreadystatechange = () => {
            if (xhr.readyState == 4 && xhr.status == 200){
                document.getElementById('saveTempAdressBtn').innerHTML = 'Salvar endereço temporário'
                document.getElementById('saveTempAdressBtn').disabled = ''

                let tempLocation = JSON.parse(xhr.response)
                tempPosition.tempLat = tempLocation.items[0].position.lat
                tempPosition.tempLng = tempLocation.items[0].position.lng

                document.getElementById('tmpLat').value = tempPosition.tempLat
                document.getElementById('tmpLng').value = tempPosition.tempLng

                setTempPosition({tempLat: tempPosition.tempLat, tempLng: tempPosition.tempLng, logradouro: {uf: data[1], cidade: data[2], bairro: data[3], rua: data[4]}})

                myModal.hide()
            }
        }
        xhr.send()
    }
})

function userNotLogged(is_set_location) {
    myModal = new bootstrap.Modal(addressModal, {
        backdrop: 'static'
    })

    if (is_set_location === 'false'){
        myModal.show()

        if(navigator.geolocation){
            navigator.geolocation.getCurrentPosition(position => {
                let ajax = new XMLHttpRequest()
                ajax.open('GET', `https://revgeocode.search.hereapi.com/v1/revgeocode?at=${position.coords.latitude},${position.coords.longitude}&apiKey=2BHqTlrrRZyJOYbFEl47yRbagjjwSaY-Eu3iriuEgvY`)

                ajax.onreadystatechange = () => {
                    if(ajax.readyState == 4 && ajax.status == 200){
                        let enderecoJSON = ajax.responseText

                        //convertendo a resposta JSON em objeto
                        enderecoJSON = JSON.parse(enderecoJSON)

                        //Colocando a resposta nos formulários
                        document.getElementById('userAdressCEP').value = enderecoJSON['items'][0].address.postalCode.replace('-','')
                        document.getElementById('userAdressCity').value = enderecoJSON['items'][0].address.city
                        document.getElementById('userAdressState').value = enderecoJSON['items'][0].address.stateCode
                        document.getElementById('userAdressStreet').value = enderecoJSON['items'][0].address.street
                        document.getElementById('userAdressNeighborhood').value = enderecoJSON['items'][0].address.district
                        document.getElementById('userAdressNumber').value = enderecoJSON['items'][0].address.houseNumber

                    } else if(ajax.readyState == 4 && ajax.status == 400){
                        alert('Erro ao se conectar com os correios')
                    }
                }
                ajax.send()
            })
        }
    }
}

export {setSearchState, setTempPosition, tempPosition, userNotLogged};