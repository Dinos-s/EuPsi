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
    if (validarForm()) {
        cadPaciente()
        cadPsi()
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

    if (senha.value.length <= 0 && senhaRepeat.value.length <= 0) {
        alert('Senha não pode ser vazia')
        return false
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
    const senhaRepeat = document.getElementById('senha-repeat').value;

    const formData = { nome, cpf, telefone, email, senha };

    if (!nome || !cpf || !telefone || !email || !senha || !senhaRepeat) {
        console.error('Por favor, preencha todos os campos obrigatórios.');
        return;
    }
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
    const senhaRepeat = document.getElementById('senha-repeat').value;

    const formData = { nome, crp, telefone, email, senha };

    if (!nome || !crp || !telefone || !email || !senha || !senhaRepeat) {
        console.error('Por favor, preencha todos os campos obrigatórios.');
        return;
    }

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