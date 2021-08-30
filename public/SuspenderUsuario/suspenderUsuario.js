$(document).ready(() => {
    $('#1').on('click', () => {
        if (document.getElementById('1').checked) {
            let outroMotivoInput = document.createElement('input')
            outroMotivoInput.type = "text"
            outroMotivoInput.className = "form-control"
            outroMotivoInput.id = "outroMotivoInput"
            outroMotivoInput.name = "outroMotivo"
            outroMotivoInput.placeholder = "Escreva um outro motivo"
            outroMotivoInput.required = "required"

            document.getElementById('outroMotivoDiv').appendChild(outroMotivoInput)
        } else {
            document.getElementById('outroMotivoDiv').innerHTML = ""
        }
    })
})