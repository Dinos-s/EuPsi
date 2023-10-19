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
    // Criação dos elementos e classes do interior do card
    const card = document.createElement('div');
    card.classList.add('card');

    const background = document.createElement('div');
    background.classList.add('background');

    const cardSuperior = document.createElement('div')
    cardSuperior.classList.add('card_superior');

    const lado1 = document.createElement('div')
    lado1.classList.add('lado1');

    const profileImage = document.createElement('div');
    profileImage.classList.add('avatar');

    const img = document.createElement('img');
    img.src = psi.profile;
    img.alt = 'picture';

    const content = document.createElement('div');
    content.classList.add('content');

    const profileName = document.createElement('h4');
    profileName.textContent = psi.nome;
    profileName.classList.add('perfil');

    const profileEspecialidade = document.createElement('p');
    profileEspecialidade.textContent = psi.especialidade;
    profileEspecialidade.classList.add('especialidade');

    const profileCRP = document.createElement('p');
    profileCRP.textContent = `${psi.CRP} | CRP - ${psi.regiao} Região`;
    profileCRP.classList.add('crp');

    const cidadePreco = document.createElement('section')
    cidadePreco.classList.add('regular');

    const profileCidade = document.createElement('p');
    profileCidade.textContent = psi.cidade;
    profileCidade.classList.add('cidade');

    const preco = document.createElement('p')
    preco.innerHTML = `<span class="price">R$ ${psi.preco}</span>/50 min`

    const cardInferior = document.createElement('div')
    cardInferior.classList.add('card_inferior')

    const resumo = document.createElement('p')
    resumo.className = 'resumo'
    resumo.textContent = textoLongo(psi.resumo)

    const sobreBTN = document.createElement('button')
    sobreBTN.textContent = 'Saber Mais...'
    sobreBTN.className = 'sobreBTN'
    sobreBTN.addEventListener('click', () => {
        const pisicolgo = { nome: psi.nome }
        const url = `agendamento.html?psi=${encodeURIComponent(pisicolgo.nome)}`
        window.location.href = url
    })


    // Abaixo está listado os cards dos psicólogos
    // colocando os elementos dentro dos elementos
    card.appendChild(background);
    card.appendChild(cardSuperior)
    cardSuperior.appendChild(lado1)
    lado1.appendChild(profileImage)
    profileImage.appendChild(img);
    lado1.appendChild(content);
    content.appendChild(profileName);
    content.appendChild(profileEspecialidade);
    content.appendChild(profileCRP);
    cidadePreco.appendChild(profileCidade);
    cidadePreco.appendChild(preco)
    content.appendChild(cidadePreco)
    cardInferior.appendChild(resumo)
    resumo.appendChild(sobreBTN)
    card.appendChild(cardInferior)

    //lado2 do card
    const lado2 = document.createElement('div')
    lado2.classList.add('lado2')

    // Calendário dinâmico
    const calendarDiv = document.createElement('div');
    calendarDiv.classList.add('calendar');

    const calendarWrapper = document.createElement('div');
    calendarWrapper.classList.add('wrapper');

    const calendarTable = document.createElement('table');
    calendarTable.id = 'DiasSemana';

    // Estrutura do calendário
    const linhaTitulo = document.createElement('tr')
    linhaTitulo.className = 'linhaTitulo'
    const colunaTitulo = document.createElement('td')
    colunaTitulo.textContent = 'Horários Disponíveis'
    colunaTitulo.setAttribute('colspan', '7')
    linhaTitulo.appendChild(colunaTitulo)

    const linhaDia = document.createElement('tr');
    linhaDia.id = 'dayRow';
    const linhaData = document.createElement('tr');
    linhaData.id = 'dateRow';

    const semana = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];

    // Definindo as variáveis iniciais do dia
    let diaZero = new Date();
    let inicioSemanal = new Date(diaZero);
    inicioSemanal.setDate(diaZero.getDate() - diaZero.getDay());

    // Dias da semana
    for (let i = 0; i < 7; i++) {
        const dia = new Date(inicioSemanal);
        dia.setDate(inicioSemanal.getDate() + i);
        const diaSemana = dia.toLocaleDateString('pt-BR', { weekday: 'short' });
        const data = dia.toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit' });

        const celulaDia = document.createElement('td');
        celulaDia.textContent = diaSemana;
        celulaDia.className = 'dia';
        linhaDia.appendChild(celulaDia);

        const celulaData = document.createElement('td');
        celulaData.textContent = data;
        celulaData.className = 'data';
        linhaData.appendChild(celulaData);
    }

    calendarTable.appendChild(linhaTitulo)
    calendarTable.appendChild(linhaDia);
    // calendarTable.appendChild(linhaData);
    calendarWrapper.appendChild(calendarTable);

    // Aqui está o código para criar e adicionar a tabela de horas (time)

    const containerTime = document.createElement('div')
    containerTime.className = 'colunaTempo'

    const tableTime = document.createElement('table');
    tableTime.className = 'horas-scroll';

    // Cria os elementos da tabela
    const colunasHora = [];
    for (let i = 1; i <= 7; i++) {
        const colunaHora = document.createElement('td');
        colunaHora.className = `horaColumn${i}`;
        colunasHora.push(colunaHora);
    }

    const linhaHora = document.createElement('tr');
    colunasHora.forEach((column) => {
        linhaHora.appendChild(column);
    });

    tableTime.appendChild(linhaHora);
    cardSuperior.appendChild(lado2)
    containerTime.appendChild(tableTime)
    calendarWrapper.appendChild(containerTime);
    lado2.appendChild(calendarDiv)

    calendarDiv.appendChild(calendarWrapper);

    return card;
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
                <div class='maisInfos'>
                    <h3>Experiência</h3>
                    <ul class='softskills'>
                        
                    </ul>
                </div>
                <div class='maisInfos'>
                    <h3>Especialidade</h3>
                    <ul class='especialidades softskills'>
                        
                    </ul>
                </div>
                <div class='maisInfos'>
                    <h3>Abordagens</h3>
                    <ul class='abordar softskills'>
                        
                    </ul>
                </div>
                <div class='maisInfos'>
                    <h3>Formação</h3>
                    <ul class='diploma softskills'>
                        
                    </ul>
                </div>
            `
            experience(doctor)
            especialidade(doctor)
            arbodagem(doctor)
            formation(doctor)
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

// pegando as especialidades no json
function especialidade(doctor) {
    const Especial = document.querySelector('.especialidades');
    Especial.innerHTML = doctor.especialidade.map((skill) => {
        return `<li class='experiencias'>
                    ${skill}
                </li>`
    }).join('');
}

// abordargens do psicologo
function arbodagem(doctor) {
    const Abordar = document.querySelector('.abordar')
    Abordar.innerHTML = doctor.abordagens.map((skill) => {
        return `<li class='experiencias'>
                    ${skill}
                </li>`
    }).join('');
}

// Formação do psicologo
function formation(doctor) {
    const Escolar = document.querySelector('.diploma')
    Escolar.innerHTML = doctor.formacao.map((skill) => {
        return `<li class='experiencias'>
                    <h2 class="title">${skill.curso}</h2>
                    <h3>${skill.university}</h3>
                    <p class="period">${skill.conclusao}</p>
                    <p>${skill.tipo}</p>
                </li>`
    }).join('');
}