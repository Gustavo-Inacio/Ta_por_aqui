export default class ReportInterface{
    constructor(iframeReference){
        this.iframeReference = iframeReference;

        this.providerName = null;
        this.serviceName = null;
        this.smallBusiness = null;
        this.reason = null;
        this.comment = null;
    }

    getIframeContents({parent = this.iframeReference, elem = 'body'}){ // este metodo trata de procurar um elemento dentr de um iframe
        if(!parent || !elem) return

        let iFrameElem;
        if ( parent.contentDocument ) 
        {
            iFrameElem = parent.contentDocument.querySelectorAll(elem);
        }
        else if ( parent.contentWindow ) 
        {
            iFrameElem = parent.contentWindow.document.querySelectorAll(elem);  
        }    
        return iFrameElem;
    }

    getContents({parent = this.iframeReference, elem = 'body'}){ // este elemento trata de procurar um elemnto
        if(parent === this.iframeReference) return this.getIframeContents({parent, elem}) // caso o elemento pai seja um iframe ele chama a funcao que cuida disso
        else return parent.querySelectorAll(elem); // se nao, eh somente um elemtm padrao
    }

    headInfo({serviceName = null, providerName = null, smallBusiness = null}){ // implemnta as infos no cabecalho
        let headComponent = { // sao as labels do cabecalho
            serviceName: this.getContents({elem: '#myServiceReportName'}),
            providerName: this.getContents({elem: '#myPersonReportName'})
        }

        if(smallBusiness){// caso for pequeno negocio
            this.smallBusiness = smallBusiness;
            this.providerName = null;
            this.serviceName = null;

            let business = this.getContents({elem: '.service-report-title'}); // esta eh a div que mostra o servico / smallBisunes

            for(let i = 0; i < business.length; i++){
                let lblService = business[i].querySelectorAll('#myServiceReportName')[0]; // label que fica dentro da div. a lbl mostra o nome do estabelecmento

                lblService.innerHTML = smallBusiness; // 
                business[i].innerHTML = `Negócio: `;
                business[i].appendChild(lblService);
            }

            let providerNameStructure = this.getContents({elem: '.person-report-title'}) // este eh a div que mostra o nome do prestador
            
            for(let i = 0; i < providerNameStructure.length; i++){
                providerNameStructure[i].style.display = 'none'; // todas as divs nao serao mostradas pois nao existe prestados num smallBusiness
            }
        }
        else if(serviceName && providerName){ // se exitir um prestador e um provedor
            this.smallBusiness = null;
            this.providerName = providerName;
            this.serviceName = serviceName;

            for(let i = 0; i < headComponent.serviceName.length; i++){
                headComponent.serviceName[i].innerHTML = serviceName;
                headComponent.providerName[i].innerHTML = providerName;
            }
        }
        else{
            return;
        }
    }

    reasonDropMenu({reportReason}){ // este metodo cuidara do dropdown de motivos de denuncia
        reportReason.push('Outro'); // esta sera a ultima opcao

        let lblReason = this.getContents({elem: '.my-report-reason-drop-item'})[0]; // esta eh o lbl de template
        let reasonWrraper = this.getContents({elem: '.my-reason-dropdrown'})[0]; // esta eh a estrutura do menu

        let btnReportOption = this.getContents({elem: '#btnDropdownReport'})[0]; // este eh o btnToggler
        let inputInfo = this.getContents({elem: '#myReportReason'})[0]; // este eh o input do form
        
        

        let otherReason = this.getContents({elem: '.other-reason-toggle'});
       

        const reasonClickHandler = (elem) =>{ // quando clicar em um elemnto do menu, esta funcao sera executada

            btnReportOption.innerHTML = elem.innerHTML; // o btn toggler muda o texto para o selecionado
            inputInfo.value = elem.innerHTML; // o input do form muda o seu valor

            if(elem.innerHTML === "Outro"){ // se for outro motivo, habilita a caixa de escrever outro
                for(let i = 0; i < otherReason.length; i++){
                    otherReason[i].style.display = 'initial';
                }
            }
            else{
                for(let i = 0; i < otherReason.length; i++){
                    otherReason[i].style.display = 'none';
                }
            }

            this.reason = inputInfo.value;
        }
        
        for(let i = 0; i < reportReason.length; i++){ // implementa cada motivo n menu
            
            lblReason.innerHTML = reportReason[i]; // coloca o nome
            let newItem = document.importNode(lblReason, true); // importa para uma varavel
            newItem.style.display = 'flex' // deixa ela visivel
            reasonWrraper.appendChild(newItem); // implementa ela no menu

            newItem.onclick = ()=> {reasonClickHandler(newItem)};
        }


    }

    toggleSectionHandler(){
        let btnSend = this.getContents({elem: '#btnSend'})[0];
        let inputSection = this.getContents({elem: "#myReportSection"})[0];
        let confirmSection = this.getContents({elem: "#myVerificationSection"})[0];

        let inputProviderName = this.getContents({elem: '#providerName_form'})[0];
        let inputServiceName = this.getContents({elem: '#serviceName_form'})[0];

        let inputSmallBusiness = this.getContents({elem: '#smallBusiness_form'})[0];

        let pReason = this.getContents({elem: '.my-reason-text-verification'})[0];
        let inputReason = this.getContents({elem: '#reason_form'})[0];

        let inputComment = this.getContents({elem: '#comment_form'})[0];
        let pComment = this.getContents({elem: '.my-comment-verification'})[0];
           

        const fillInfo = () => {
            let comment_elem = this.getContents({parent: document.querySelectorAll("#myReportSection")[0] ,elem: '.my-comment-text'})[0];
            this.comment = comment_elem.value;

            if(this.reason === "Outro"){
                let otherRasonInput = this.getContents({parent: document.querySelectorAll("#myReportSection")[0], elem: '.my-other-reason-text'})[0];
                this.reason = otherRasonInput.value;
            }

            if(this.smallBusiness){
                inputSmallBusiness.value = this.smallBusiness;
                inputProviderName.value = null;
                inputServiceName.value = null;
            }
            else if(this.providerName && this.serviceName){
                inputProviderName.value = this.providerName;
                inputServiceName.value = this.serviceName;
            }

            pReason.innerHTML = this.reason;
            inputReason.value = this.reason;
            
            inputComment.value = this.comment;
            pComment.innerHTML = this.comment;

        }
        
        btnSend.onclick = () => {

            fillInfo()
            inputSection.style.display = "none";
            confirmSection.style.display = "block";

        }
    }

    getInfo({serviceName = null, providerName = null, smallBusiness = null, reportReason = null} = {}){
        if(!reportReason || !Array.isArray(reportReason)) return;

        this.reasonDropMenu({reportReason})

        if(!smallBusiness){ // se nao for um pequeno negocio
            if(serviceName && providerName) this.headInfo({providerName, serviceName}); // se tiver o provider name e o service name, manda para o headInfo.
            else return; // se as informacoes nao estiverem completas, retorna nulo
            console.log("passou")
        }
        else{
            if(serviceName || providerName && smallBusiness) return // se tiver um smallBusiness com alguma info de prestador, nao faz sentido, retone nulo.
            else this.headInfo({smallBusiness}) // se so tiver o small business, manda ele para o headInfo
        }

        console.log(this.getContents({elem: "#myReportSection"}));

        this.toggleSectionHandler();
    }

    
    getStructure({parent = this.iframeReference, elem = 'body'} = {}){
        if(!parent || !elem) return;

        if(!typeof elem === 'string') return;

        return this.getContents({parent, elem});
    }

}