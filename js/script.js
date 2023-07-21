const cont = document.querySelector('.mobile-menu');
const sidebar = document.querySelector('.hamburger');

sidebar.addEventListener('click', () => {

    cont.classList.toggle('show-menu');
    
});