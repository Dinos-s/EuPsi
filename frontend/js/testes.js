// integrando o form com o banco de dados
const cadPaciente = document.querySelector('.cadPaciente')

async function pacientes() {
    const response = await fetch("http://localhost:3000/pacientes");
    const pacientes = await response.json();
    console.log(pacientes);
    return pacientes
}

pacientes()

cadPaciente.addEventListener('submit', function (event) {
  event.preventDefault();

  const nome = document.getElementById('nome').value;
  const telefone = document.getElementById('telefone').value;
  const email = document.getElementById('email').value;
  const senha = document.getElementById('senha').value;
  // Você pode adicionar mais campos conforme necessário

  // Construir um objeto com os dados do formulário
  const formData = {
    nome,
    telefone,
    email,
    senha,
  };

  // Enviar dados para o servidor usando Fetch API
  fetch('http://localhost:3000/addPaciente', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(formData),
  })
    .then(response => response.text())
    .then(data => {
      console.log(data);
    })
    .catch(error => {
      console.error('Erro ao enviar dados para o servidor:', error);
    });
});

// fetch('http://localhost:3000/pacientes')
//   .then((res) => {
//     if (!res.ok) {
//       throw new Error(`Erro na solicitação: ${res.status}`);
//     }
//     return res.json();
//   })
//   .then((data) => {
//     console.log(data);
//   })
//   .catch((error) => {
//     console.error('Erro ao obter dados do servidor:', error);
//   });
