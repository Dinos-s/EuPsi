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
const months = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];

let date = new Date();
let currentYear = date.getFullYear()
let currentMonth = date.getMonth()

const currentDate = document.querySelector('.current-date')
const days = document.querySelector('.days');
let monthName = months[date.getMonth()];
const prevNextIcon = document.querySelectorAll('.icons span')

const render = () => {
    let fisrtDateMonth = new Date(currentYear, currentMonth, 1).getDay()
    let lastDateMonth = new Date(currentYear, currentMonth + 1, 0).getDate()
    let lastDayOfMonth = new Date(currentYear, currentMonth, lastDateMonth).getDay()
    let lastDateOfLastMonth = new Date(currentYear, currentMonth, 0).getDate()
    let day = ''

    for (let i = fisrtDateMonth; i > 0; i--) {
        day += `<li class='inativo'>${lastDateOfLastMonth - i + 1}</li>`
    }

    for (let s = 1; s <= lastDateMonth; s++) {
        let isToday = '';

        if (s === date.getDate() && currentMonth === new Date().getMonth() && currentYear === new Date().getFullYear()) {
            isToday = 'ativo';
        } else {
            isToday = '';
        }
        
        day += `<li class='${isToday}'>${s}</li>`
    }

    for (let i = lastDayOfMonth; i < 6; i++) {
        day += `<li class="inativo">${i - lastDayOfMonth + 1}</li>`
    }

    currentDate.innerText = `${months[currentMonth]} ${currentYear}`
    days.innerHTML = day
}
render()

prevNextIcon.forEach(icon => {
    icon.addEventListener('click', () => {
        currentMonth = icon.id === 'prev' ? currentMonth - 1 : currentMonth + 1

        if (currentMonth < 0 || currentMonth > 11) {
            date = new Date(currentYear, currentMonth, new Date().getDate())
            currentYear = date.getFullYear()
            currentMonth = date.getMonth()
        } else {
            date = new Date();
        }
        render()
    })
})