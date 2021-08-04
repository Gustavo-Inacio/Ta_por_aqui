function showAllServices(serviceType, user) {
    //carregndo conteúdo pro modal
    $('#showAllServicesModalContent').load(`show_services.php?servicetype=${serviceType}&user=${user}`)

    //mostrando modal
    $('#showAllServicesModal').modal('show')
}