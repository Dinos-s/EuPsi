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
fetch('dados.json').then((res) => {
    res.json().then((data) => {
        data.psicologos.forEach((psi) => {
            // aqui está criando os elementos e classes do interior do card 
            const card = document.createElement('div')
            card.classList.add('card')

            const profileImage = document.createElement('div');
            profileImage.classList.add('avatar')

            const background = document.createElement('div')
            background.classList.add('background')

            const img = document.createElement('img')
            img.src = psi.profile;
            img.alt = "picture";

            const content = document.createElement('div')
            content.classList.add('content')

            const profileName = document.createElement('h4')
            profileName.textContent = psi.nome
            profileName.classList.add('perfil')

            const profileEspecialidade = document.createElement('p');
            profileEspecialidade.textContent = psi.especialidade;
            profileEspecialidade.classList.add('especialidade');
      
            const profileCRP = document.createElement('p');
            profileCRP.textContent = `${psi.CRP} | CRP - ${psi.regiao} Região`;
            profileCRP.classList.add('crp');
      
            const profileCidade = document.createElement('p');
            profileCidade.textContent = psi.cidade;
            profileCidade.classList.add('cidade');
            
            // abaixo está listado os cards dos psicologos
            card.appendChild(background)
            card.appendChild(profileImage)
            profileImage.appendChild(img)
            card.appendChild(content)
            content.appendChild(profileName)
            content.appendChild(profileEspecialidade)
            content.appendChild(profileCRP)
            content.appendChild(profileCidade)

            //calendario dinamico
            const calendarDiv = document.createElement('div')
            calendarDiv.classList.add('calendar')

            const calendarWrapper = document.createElement('div')
            calendarWrapper.classList.add('wrapper')

            const calendarTable = document.createElement('table')
            calendarTable.id = 'DiasSemana';

            // Estrutura do calendario
            const linhaDia = document.createElement('tr')
            linhaDia.id = "dayRow"
            const linhaData = document.createElement('tr')
            linhaData.id = "dateRow"

            const semana = ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"]

            // definindo as variaveis inicias do dia
            let diaZero = new Date()
            let inicioSemanal = new Date(diaZero)
            inicioSemanal.setDate(diaZero.getDate() - diaZero.getDay())

            // Dias da semana
            for (let i = 0; i < 7; i++) {
                const dia = new Date(inicioSemanal);
                dia.setDate(inicioSemanal.getDate() + i);
                const diaSemana = dia.toLocaleDateString('pt-BR', { weekday: 'short' });
                const data = dia.toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit' });

                const celulaDia = document.createElement('td');
                celulaDia.textContent = diaSemana;
                celulaDia.className = 'dia'
                linhaDia.appendChild(celulaDia);

                const celulaData = document.createElement('td');
                celulaData.textContent = data;
                celulaData.className = 'data'
                linhaData.appendChild(celulaData);
            }

            calendarTable.appendChild(linhaDia)
            calendarTable.appendChild(linhaData)

            calendarWrapper.appendChild(calendarTable)
            calendarDiv.appendChild(calendarWrapper)
            card.appendChild(calendarDiv)

            cardContainer.appendChild(card)
        })
    })
})

// const cardContainer = document.querySelector('.card-Container')
// fetch("dados.json").then((res) => {
//     res.json().then((data) => {
//         data.psicologos.forEach((psi) => { // extraindo os psicologos do json e os transformando em cards separados;
//             cardContainer.innerHTML += `
//             <a href='agendamento.html?psi=${encodeURIComponent(psi.nome)}' class='card-link'>
//                 <div class='card'>
//                         <div class="background"></div>
//                     <div class="avatar">
//                         <img src="${psi.profile}" alt="picture">
//                     </div>
//                     <div class="content">
//                         <h4 class="perfil">${psi.nome}</h4>
//                         <p class="especialidade">${psi.especialidade}</p>
//                         <p class="crp">${psi.CRP} | CRP - ${psi.regiao} Região</p>
//                         <p class="cidade">${psi.cidade}</p>
//                     </div>

//                     <div class="calendar">
//                         <div class="wrapper">
//                             <table id="DiasSemana">
//                                 <tr>
//                                     <th colspan="7">Dias da Semana</th>
//                                 </tr>
//                                 <tr id="dayRow"></tr>
//                                 <tr id="dateRow"></tr>
//                             </table>
//                         </div>
//                     </div>

//                 </div>
//             </a>`   
//         })
//     })
// })
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
const months = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

let dataAtual = new Date()

// function mudarSemana(semana) {
//     dataAtual.setDate(dataAtual.getDate() + semana * 7)
//     const PrimeiroDiaSemana = new Date(dataAtual)
//     PrimeiroDiaSemana.setDate(dataAtual.getDate() - dataAtual.getDay() + 1)
//     atualizarDiasTela(PrimeiroDiaSemana)
// }

const PrimeiroDiaSemana = new Date(dataAtual)
PrimeiroDiaSemana.setDate(dataAtual.getDate() - dataAtual.getDay() + 1)
atualizarDiasTela(PrimeiroDiaSemana)
atualizarHorasTela()

function atualizarDiasTela(PrimeiroDiaSemana) {
    const linhaDia = document.getElementById('dayRow')
    const linhaSemana = document.getElementById('dateRow')
    linhaDia.innerHTML = ''
    linhaSemana.innerHTML = ''

    for (let i = 0; i < 7; i++) {
        const dia = new Date(PrimeiroDiaSemana)
        dia.setDate(PrimeiroDiaSemana.getDate() + i)
        const diaSemana = dia.toLocaleDateString('pt-BR', { weekday: 'short' })
        const data = dia.toLocaleDateString('pt-BR', { day: '2-digit', month: "2-digit" })

        const celulaDia = document.createElement('td')
        const celulaData = document.createElement('td')

        celulaDia.textContent = diaSemana
        celulaData.textContent = data

        celulaDia.className = 'dia'
        celulaData.className = 'data'

        linhaDia.appendChild(celulaDia)
        linhaSemana.appendChild(celulaData)
    }
}

// function atualizarHorasTela() {
//     for (let i = 1; i <= 7; i++) { // esse for é usado para as colunas das horas
//         const horaColumn = document.getElementById(`horaColumn${i}`);
//         horaColumn.innerHTML = '';

//         // Hora inicial
//         let horaAtual = new Date();
//         horaAtual.setMinutes(0); // Começa no minuto 0

//         for (let j = 0; j < 7; j++) { // esse gera a quantidade de horas do dia
//             const horaFormatada = horaAtual.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });

//             const celulaHora = document.createElement('div');
//             celulaHora.textContent = horaFormatada;
//             celulaHora.className = 'hora';

//             horaColumn.appendChild(celulaHora);

//             // Avança 50 minutos
//             horaAtual.setMinutes(horaAtual.getMinutes() + 50);
//         }
//     }
// }

// let date = new Date();
// let currentYear = date.getFullYear()
// let currentMonth = date.getMonth()

// const currentDate = document.querySelector('.current-date')
// const days = document.querySelector('.days');
// let monthName = months[date.getMonth()];
// const prevNextIcon = document.querySelectorAll('.icons span')

// const render = () => {
//     let fisrtDateMonth = new Date(currentYear, currentMonth, 1).getDay()
//     let lastDateMonth = new Date(currentYear, currentMonth + 1, 0).getDate()
//     let lastDayOfMonth = new Date(currentYear, currentMonth, lastDateMonth).getDay()
//     let lastDateOfLastMonth = new Date(currentYear, currentMonth, 0).getDate()
//     let day = ''

//     for (let i = fisrtDateMonth; i > 0; i--) {
//         day += `<li class='inativo'>${lastDateOfLastMonth - i + 1}</li>`
//     }

//     for (let s = 1; s <= lastDateMonth; s++) {
//         let isToday = '';

//         if (s === date.getDate() && currentMonth === new Date().getMonth() && currentYear === new Date().getFullYear()) {
//             isToday = 'ativo';
//         } else {
//             isToday = '';
//         }
        
//         day += `<li class='${isToday}'>${s}</li>`
//     }

//     for (let i = lastDayOfMonth; i < 6; i++) {
//         day += `<li class="inativo">${i - lastDayOfMonth + 1}</li>`
//     }

//     currentDate.innerText = `${months[currentMonth]} ${currentYear}`
//     days.innerHTML = day
// }
// render()

// prevNextIcon.forEach(icon => {
//     icon.addEventListener('click', () => {
//         currentMonth = icon.id === 'prev' ? currentMonth - 1 : currentMonth + 1

//         if (currentMonth < 0 || currentMonth > 11) {
//             date = new Date(currentYear, currentMonth, new Date().getDate())
//             currentYear = date.getFullYear()
//             currentMonth = date.getMonth()
//         } else {
//             date = new Date();
//         }
//         render()
//     })
// })