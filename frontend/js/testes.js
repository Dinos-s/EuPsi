// integrando o form com o banco de dados
async function pacientes() {
  const response = await fetch("http://localhost:3000/pacientes");
  const pacientes = await response.json();
  console.log(pacientes);
  return pacientes
}

pacientes()

cadPaciente.addEventListener('submit', function (event) {
  event.preventDefault();
  cadPaciente();
  cadPsi()
});

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
      .then(response => response.text())
      .then(data => {
        console.log(data);
      })

      // a linha abaixo será executada para redirecionar para outra pagina
      window.location.href='./procuraPsi.html'
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
      .then(response => response.text())
      .then(data => {
        console.log(data);
      })
      
      // a linha abaixo será executada para redirecionar para outra pagina
      window.location.href=`./perfilPsi.html`
  } catch (error) {
    console.error('Erro ao enviar dados para o servidor:', error);
  };
}

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
