// integrando o form com o banco de dados
// const form = document.querySelector('#form')
async function pacientes() {
  const response = await fetch("http://localhost:3000/pacientes");
  const pacientes = await response.json();
  console.log(pacientes);
  return pacientes
}
pacientes()

// document.querySelector('#form').addEventListener('submit', (event) => {
//   event.preventDefault()
  // cadPaciente()
  // cadPsi()

//   const paramURL = new URLSearchParams(window.location.search)
//   const psiId = paramURL.get('id')
//   dadosDoPsi(psiId)
// })

// Função para cadastrar o paciente
function cadPaciente() {
  const nome = document.getElementById('nome').value;
  const cpf = document.getElementById('cpf').value;
  const telefone = document.getElementById('telefone').value;
  const email = document.getElementById('email').value;
  const senha = document.getElementById('senha').value;

  const formData = { nome, cpf, telefone, email, senha };

  if (!nome || !cpf || !telefone || !email || !senha) {
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
  const senhaRepeat = document.getElementById('senha-repeat');

  const formData = { nome, crp, telefone, email, senha };

  if (!nome || !crp || !telefone || !email || !senha ) {
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

// função que vai pegar os dados do banco para o perfilPsi
async function dadosDoPsi(id) {
  try {
    const response = await fetch(`http://localhost:3000/psicologo/${id}`);
    const psicologo = await response.json();

    // Preencha os campos do formulário com os dados obtidos
    document.getElementById('nome').value = psicologo.nome;
    document.getElementById('crp').value = psicologo.crp;
    document.getElementById('telefone').value = psicologo.telefone;
    document.getElementById('email').value = psicologo.email;
  } catch (error) {
    console.error('Erro ao obter dados do psicólogo:', error);
  }
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
