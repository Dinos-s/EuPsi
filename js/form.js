// Validação do formulario de cadastro psicolgo
const form = document.getElementById('form');
const email = document.getElementById('email');
const senha = document.getElementById('senha');
const senhaRepeat = document.getElementById('senha-repeat');
const submitBtn = document.getElementById('submitBtn');

form.addEventListener("submit", (event) => {
    event.preventDefault();
  
    validarForm()
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