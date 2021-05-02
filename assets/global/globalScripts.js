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