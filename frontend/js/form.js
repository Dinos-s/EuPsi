// Validação do formulario de cadastro psicolgo
const form = document.getElementById('form');
const email = document.getElementById('email');
const senha = document.getElementById('senha');
const senhaRepeat = document.getElementById('senha-repeat');
const submitBtn = document.getElementById('submitBtn');
const imagemInput = document.getElementById('imagem');
const imagemPreview = document.getElementById('imagem-preview');
const containerInfos = document.querySelectorAll('.input-container');

form.addEventListener("submit", async (event) => {
    event.preventDefault();
    if (validarForm) {
        cadPaciente,
        cadPsi,
        updatePsi
    }
});

async function pacientes() {
    const response = await fetch("http://localhost:3000/pacientes");
    const pacientes = await response.json();
    console.log(pacientes);
    return pacientes
}
pacientes()

function validarForm() {

    // email é valido
    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!emailPattern.test(email.value)) {
        alert('Por favor, insira um email válido.');
        return false;
    }

    // verificar sa as senhas são iguais
    if (senha.value !== senhaRepeat.value) {
        alert('Senhas não correspondentes');
        document.getElementById('senha-repeat').value = ''
        document.getElementById('senha').value = ''
        return false;
    }

    return true
}

imagemInput.addEventListener('change', (event) => {
    const selectedFile = event.target.files[0];

    if (selectedFile) {
        const reader = new FileReader();
        reader.onload = function (e) {
            imagemPreview.src = e.target.result;
        };
        reader.readAsDataURL(selectedFile);
    } else {
        imagemPreview.src = ''; // Limpar a pré-visualização se nenhum arquivo for selecionado
    }
});

// adiciona um novo campo no fim da pagina
containerInfos.forEach(container => {
    const addBtn = container.querySelector('.add-more')
    addBtn.addEventListener('click', () => {
        const newInputContainer = container.cloneNode(true)
        const newInput = newInputContainer.querySelector('input')
        newInput.value = ''
        container.parentElement.appendChild(newInputContainer)
    })
})

// Função para cadastrar o paciente
function cadPaciente() {
    const nome = document.getElementById('nome').value;
    const cpf = document.getElementById('cpf').value;
    const telefone = document.getElementById('telefone').value;
    const email = document.getElementById('email').value;
    const senha = document.getElementById('senha').value;

    const formData = { nome, cpf, telefone, email, senha };
    try {
        fetch('http://localhost:3000/addPaciente', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData),
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
            })

        // a linha abaixo será executada para redirecionar para outra pagina
        window.location.href = 'procuraPsi.html'
    } catch (error) {
        console.error('Erro ao enviar dados para o servidor:', error);
    };
}

//função de cadatro de psicologo
function cadPsi() {
    const nome = document.getElementById('nome').value;
    const crp = document.getElementById('crp').value;
    const telefone = document.getElementById('telefone').value;
    const email = document.getElementById('email').value;
    const senha = document.getElementById('senha').value;

    const formData = { nome, crp, telefone, email, senha };

    try {
        fetch('http://localhost:3000/addPsicologo', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData),
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                const psiId = data.id

                // a linha abaixo será executada para redirecionar para outra pagina
                window.location.href = `perfilPsi.html?id=${encodeURIComponent(psiId)}`;
            })

    } catch (error) {
        console.error('Erro ao enviar dados para o servidor:', error);
    };
}

// Função para obter mais dados do psicólogo e preencher outros campos
async function dadosDoPsi(id) {
    try {
        const response = await fetch(`http://localhost:3000/psicologo/${id}`);
        const psicologo = await response.json();

        // Preencha os campos do formulário com os dados obtidos
        document.getElementById('nome').value = psicologo.nome;
        document.getElementById('crp').value = psicologo.crp;
        document.getElementById('telefone').value = psicologo.telefone;
        document.getElementById('email').value = psicologo.email;
        document.getElementById('resumo').value = psicologo.resumo

        const formData = { nome, crp, telefone, email, senha, resumo};
    } catch (error) {
        console.error('Erro ao obter dados do psicólogo:', error);
    }
}

const paramId = new URLSearchParams(window.location.search)
const id = paramId.get('id');

dadosDoPsi(id) // essa linha executa a função logo acima

// Função para atualizar os dados do psicologo
function updatePsi() {
    const nome = document.getElementById('nome').value;
    const crp = document.getElementById('crp').value;
    const telefone = document.getElementById('telefone').value;
    const email = document.getElementById('email').value;
    const senha = document.getElementById('senha').value;
    const resumo = document.getElementById('resumo').value

    const formData = { nome, crp, telefone, email, senha, resumo};

    try {
        fetch(`http://localhost:3000/psicologo/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData),
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
            })

    } catch (error) {
        console.error('Erro ao enviar dados para o servidor:', error);
    };
}