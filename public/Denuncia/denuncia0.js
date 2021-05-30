class ReportInterface {
    constructor(iframe_e = null){
        this.iframe_e = iframe_e;
    }

    getFrameContents = (iFrame = this.iframe_e, elem = 'document') => {
        if(!iFrame || !elem) return

        let iFrameBody;
        if ( iFrame.contentDocument ) 
        {
            iFrameBody = iFrame.contentDocument.querySelectorAll(elem);
        }
        else if ( iFrame.contentWindow ) 
        {
            iFrameBody = iFrame.contentWindow.document.querySelectorAll(elem);  
        }    
        return iFrameBody;
    }

    getContents({parent = this.iframe_e, elem = null}){
        if(!elem) return;

        if(parent === this.iframe_e) return this.getFrameContents(parent, elem)
        else return parent.querySelectorAll(elem)

    }

    reasonOptionHandler(text = null, parent = this.iframe_e){ // esta funcao coloca o motivo selecionado no input para o form, e no btnToggler
        if(!text) return

        let inputInfo = this.getContents(parent, "#myReportReason"); // o input do form
        let btnDropDown; // este sera o btn
         
        console.log(parent)

    }

    
    getInformation ({providerName = "", serviceName = ""} = 0, reportReasonList = null, parent = null) { // essa funcao atribui os valores enviados para a classe, a estrutura em si
        if((providerName == "" || serviceName == "" || !reportReasonList)) return

       let headInfo = {
            'service': this.getContents({elem: '#myServiceReportName'}),
            'provider': this.getContents({elem: '#myPersonReportName'})
        };


        for(let i = 0; i < headInfo.service.length; i++){ // insere as informacoes no cabecalho
            headInfo.service[i].innerHTML = serviceName;
            headInfo.provider[i].innerHTML = providerName;
        }

        let lblReason = this.getContents({elem: '.my-report-reason-drop-item'})[0] // uma label template de opcao de motivo

        let reasonStructure = this.getContents({elem:'.my-reason-dropdrown'})[0]; // o local em que as label de motivo serao inseridas
        
        reportReasonList.push("Outro"); // esta ultima opcao devera existir 
        for(let i = 0; i < reportReasonList.length; i++){ // insere os motivos na lista de motivos
            lblReason.innerHTML = reportReasonList[i];

            let reason = document.importNode(lblReason, true);
            reason.style.display = "flex";

            reason.onclick = () => {
                this.reasonOptionHandler(reason.innerHTML, parent)

            }
            reasonStructure.appendChild(reason);
        }


    }

    getStructure(elem = 'body'){
        return this.getFrameContents(this.iframe_e, elem)
    }
}

export default ReportInterface;
