const navLinks = document.querySelectorAll('nav ul li a');

// Adiciona um evento de clique a cada link
navLinks.forEach(link => {
    link.addEventListener('click', function(event){
        // Remove a classe "active" de todos os links
        navLinks.forEach(link => link.classList.remove('active'));
        this.classList.add('active');
    });
});
