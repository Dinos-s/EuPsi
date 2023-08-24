const navLinks = document.querySelectorAll('nav ul li a');

// Adiciona um evento de clique a cada link
navLinks.forEach(link => {
    link.addEventListener('click', function (event) {
        // Remove a classe "active" de todos os links
        navLinks.forEach(link => link.classList.remove('active'));
        this.classList.add('active');
    });
});

// pegando usuarios do json
const cardContainer = document.querySelector('.card-Container')
fetch("dados.json").then((res) => {
    res.json().then((data) => {
        data.psicologos.forEach((psi) => { // extraindo os psicologos do json e os transformando em cards separados;
            cardContainer.innerHTML += `
            <div class='card'>
                <div class="background">
                </div>
                <div class="avatar">
                    <img src="${psi.profile}" alt="picture">
                </div>
                <div class="content">
                    <h4 class="perfil">${psi.nome}</h4>
                    <p class="especialidade">${psi.especialidade}</p>
                    <p class="crp">${psi.CRP} | CRP - ${psi.regiao} Região</p>
                    <p class="cidade">${psi.cidade}</p>
                </div>
            </div>`
        })
    })
})

// dias do calendario
const prev = document.querySelector('.prev')
const next = document.querySelector('.next')
const currentYearElement = document.getElementById('currentYear')
const mainContainer = document.querySelector('main')
const months = ['Jan', 'Fev', 'Mar', 'Apr', 'Mai', 'Jun', 'Jul', 'Ago', 'Sep', 'Out', 'Nov', 'Dez']

function render() {
    const thisMonth = new Date().getMonth();
    let output = '';

    for (let i = 0; i < months.length; i++) {
        const active = i === thisMonth ? 'active' : '';
        output += `<div class="${active}">${months[i]}</div>`
    }

    return output
}

function changeYear(yearChange) {
    const currentYear = parseInt(currentYearElement.textContent) + yearChange
    currentYearElement.textContent = currentYear
}

mainContainer.innerHTML = render()
currentYearElement.textContent = new Date().getFullYear()




