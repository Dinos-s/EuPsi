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
            <a href="agendamento.html?psi=${encodeURIComponent(psi.nome)}" class="card-link">
                <div class='card'>
                        <div class="background"></div>
                    <div class="avatar">
                        <img src="${psi.profile}" alt="picture">
                    </div>
                    <div class="content">
                        <h4 class="perfil">${psi.nome}</h4>
                        <p class="especialidade">${psi.especialidade}</p>
                        <p class="crp">${psi.CRP} | CRP - ${psi.regiao} Região</p>
                        <p class="cidade">${psi.cidade}</p>
                    </div>
                </div>
            </a>`
        })
    })
})

// modo dinamico do agendamento
const paramURL = new URLSearchParams(window.location.search)
const psiNome = paramURL.get('psi')
fetch('dados.json').then(res => res.json())
    .then(data => {
       const doctor = data.psicologos.find(psi => psi.nome === psiNome) // aqui com para se o valor do psi.nome e o mesmo do psiNome;
        if (psiNome) {
            const avatar = document.querySelector('.avatar')
            const infoUser = document.querySelector('.info h2')
            const crp = document.querySelector('.crp')
            const city = document.querySelector('.city')
            const price = document.querySelector('.price')

            // Pega os dados correspondents e o substitui pelos do json;
            avatar.src = doctor.profile
            infoUser.textContent = doctor.nome
            crp.textContent = doctor.CRP
            city.textContent = doctor.cidade
        }
    })
    .catch(error => {
        console.error(error);
    });

// dias do calendario
const months = ['Jan', 'Fev', 'Mar', 'Apr', 'Mai', 'Jun', 'Jul', 'Ago', 'Sep', 'Out', 'Nov', 'Dez']
let date = new Date()
let dayNum = date.getDay() // dia da semana
let active = document.querySelector(".week li:nth-child("+dayNum+")")
let day = date.getDate() // dia de hoje 1-30/31
let month = months[date.getMonth()] //imprime o mes correspondente do array; 7 = Ago
let year = date.getFullYear() //ano completo
let h1 = document.createElement('h1') // cria um no elemento html
let h3 = document.createElement('h3')
let h5 = document.createElement('h5')

active.classList.add('current') //add class no html 
h1.innerHTML = day
h3.innerHTML = year
h5.innerHTML = month
active.appendChild(h1)
active.appendChild(h3)
active.appendChild(h5)

// const prev = document.querySelector('.prev')
// const next = document.querySelector('.next')
// const currentYearElement = document.getElementById('currentYear')
// const currentMonthElement = document.getElementById('currentMonth')
// const mainContainer = document.querySelector('main')
// const months = ['Jan', 'Fev', 'Mar', 'Apr', 'Mai', 'Jun', 'Jul', 'Ago', 'Sep', 'Out', 'Nov', 'Dez']

// function render() {
//     const thisMonth = new Date().getMonth();
//     let output = '';

//     for (let i = 0; i < months.length; i++) {
//         const active = i === thisMonth ? 'active' : '';
//         output += `<div class="${active}">${months[i]}</div>`
//     }

//     return output
// }

// function changeYear(yearChange) {
//     const currentYear = parseInt(currentYearElement.textContent) + yearChange
//     currentYearElement.textContent = currentYear
// }

// mainContainer.innerHTML = render()
// currentYearElement.textContent = new Date().getFullYear()
// currentMonthElement.textContent = new Date().getMonth()