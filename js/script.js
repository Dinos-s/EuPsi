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

function criaPsiCard(psi) {
    const card = document.createElement('div')
    card.innerHTML = `
    <div class="card">
    <div class="background"></div>
    <div class="card_superior">
        <div class="lado1">
            <div class="avatar"><img src="${psi.profile}" alt="picture"></div>
            <div class="content">
                <h4 class="perfil">${psi.nome}</h4>
                <p class="especialidade">Psicoligia Pedriata</p>
                <p class="crp">${psi.CRP} | CRP - ${psi.regiao} Região</p>
                <section class="regular">
                    <p class="cidade">${psi.cidade}</p>
                    <p><span class="price">R$ ${psi.preco}</span>/50 min</p>
                </section>
            </div>
        </div>
        <div class="lado2">
            <div class="calendar">
                <div class="wrapper">
                    <table id="DiasSemana">
                        <tr class="linhaTitulo">
                            <td colspan="7">Horários Disponíveis</td>
                        </tr>
                        <tr id="dayRow">
                            <td class="dia">dom.</td>
                            <td class="dia">seg.</td>
                            <td class="dia">ter.</td>
                            <td class="dia">qua.</td>
                            <td class="dia">qui.</td>
                            <td class="dia">sex.</td>
                            <td class="dia">sáb.</td>
                        </tr>
                    </table>
                    <div class="colunaTempo">
                        <table class="horas-scroll">
                            <tr>
                                <td class="horaColumn1"></td>
                                <td class="horaColumn2"></td>
                                <td class="horaColumn3"></td>
                                <td class="horaColumn4"></td>
                                <td class="horaColumn5"></td>
                                <td class="horaColumn6"></td>
                                <td class="horaColumn7"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card_inferior">
        <p class="resumo">${textoLongo(psi.resumo)}<button class="sobreBTN">Saber Mais...</button></p>
    </div>
</div>
    `;
        // Encontre o botão .sobreBTN dentro deste card
        const sobreBTN = card.querySelector('.sobreBTN');

        sobreBTN.addEventListener('click', () => {
            const psicologo = { nome: psi.nome };
            const url = `agendamento.html?psi=${encodeURIComponent(psicologo.nome)}`;
            window.location.href = url;
        });
    return card   
}

fetch('dados.json').then((res) => {
    res.json().then((data) => {
        data.psicologos.forEach((psi) => {
            const card = criaPsiCard(psi);
            cardContainer.appendChild(card);
        })
        horasNaTabela()
    })
})


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
            const saberMais = document.querySelector('.saberMais')

            // Pega os dados correspondents e o substitui pelos do json;
            avatar.src = doctor.profile
            infoUser.textContent = doctor.nome
            crp.textContent = doctor.CRP
            city.textContent = doctor.cidade
            price.textContent = `R$ ${doctor.preco}`

            saberMais.innerHTML = `
                <div class='descPessoal'>
                    <h3>Descrição Pessoal</h3>
                    <p class='resumo'>${doctor.resumo}</p>
                </div>
                <div class='experience'>
                    <h3>Experiência</h3>
                    <ul class='softskills'>
                        
                    </ul>
                </div>
            `
            experience(doctor)
        }
    })
    .catch(error => {
        console.error(error);
    });

// dias do calendario
const months = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

let dataAtual = new Date()

function mudarSemana(semana) {
    dataAtual.setDate(dataAtual.getDate() + semana * 7)
    const PrimeiroDiaSemana = new Date(dataAtual)
    PrimeiroDiaSemana.setDate(dataAtual.getDate() - dataAtual.getDay() + 1)
    atualizarDiasTela(PrimeiroDiaSemana)
}

const PrimeiroDiaSemana = new Date(dataAtual)
PrimeiroDiaSemana.setDate(dataAtual.getDate() - dataAtual.getDay() + 1)
atualizarDiasTela(PrimeiroDiaSemana)
horasNaTabela()

function atualizarDiasTela(PrimeiroDiaSemana) {
    const linhaDia = document.getElementById('dayRow')
    const linhaSemana = document.getElementById('dateRow')
    linhaDia.innerHTML += ''
    linhaSemana.innerHTML += ''

    for (let i = 0; i < 7; i++) {
        const dia = new Date(PrimeiroDiaSemana)
        dia.setDate(PrimeiroDiaSemana.getDate() + i)
        const diaSemana = dia.toLocaleDateString('pt-BR', { weekday: 'short' })
        // const data = dia.toLocaleDateString('pt-BR', { day: '2-digit', month: "2-digit" })

        const celulaDia = document.createElement('td')
        // const celulaData = document.createElement('td')

        celulaDia.textContent = diaSemana
        // celulaData.textContent = data

        celulaDia.className = 'dia'
        // celulaData.className = 'data'

        linhaDia.appendChild(celulaDia)
        // linhaSemana.appendChild(celulaData)
    }
}

// Aqui está acrescentando os horários na tabela para todos os usuários
function horasNaTabela() {
    for (let i = 0; i <= 7; i++) { // esse for é usado para as colunas das horas
        const horaColumns = document.querySelectorAll(`.horaColumn${i}`);

        horaColumns.forEach((horaColumn) => {
            horaColumn.innerHTML += '';

            // Hora inicial
            let horaAtual = new Date();
            // horaAtual.setMinutes(0); // Começa no minuto 0
            horaAtual.setHours(7, 0)

            let horaFinal = new Date();
            horaFinal.setHours(22, 0)

            const ul = document.createElement('ul');
            ul.className = 'hora-list'; // Adicione uma classe para a lista

            while (horaAtual < horaFinal) { // esse gera a quantidade de horas do dia
                const horaFormatada = horaAtual.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });

                const li = document.createElement('li');
                const button = document.createElement('button');
                button.textContent = horaFormatada;
                button.className = 'hora-button'; // Adicione uma classe para o botão
                li.appendChild(button);
                ul.appendChild(li);

                // Avança 50 minutos
                horaAtual.setMinutes(horaAtual.getMinutes() + 50);
            }

            horaColumn.appendChild(ul); // Adicione a lista à coluna de hora
        });
    }
}

// três pontos no excesso de texto
function textoLongo(texto) {
    if (texto && texto.length > 200) {
        return texto.slice(0, 200) + '...';
    } else {
        return texto
    }
}

// pegando as experiencias do json
function experience(doctor) {
    const Softskills = document.querySelector('.softskills');
    Softskills.innerHTML = doctor.experiencia.map((skill) => {
        return `<li class='experiencias'>
                    ${skill}
                </li>`
    }).join('');
}