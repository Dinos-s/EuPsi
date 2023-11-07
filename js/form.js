// Validação do formulario de cadastro psicolgo
const form = document.getElementById('form');
const email = document.getElementById('email');
const senha = document.getElementById('senha');
const senhaRepeat = document.getElementById('senha-repeat');
const submitBtn = document.getElementById('submitBtn');
const imagemInput = document.getElementById('imagem');
const imagemPreview = document.getElementById('imagem-preview');
const containerInfos = document.querySelectorAll('.input-container');

form.addEventListener("submit", (event) => {
    if (!validarForm()) {
        event.preventDefault();
    }
});
  
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