// função de cosulta os psicologos já cadastrados
async function psicologos() {
    const response = await fetch("http://localhost:3000/psicologos");
    const psicologos = await response.json();
    console.log("Psicólogos:", psicologos);
    renderPsicologos(psicologos);
}

// função de cosulta os psicologos já cadastrados
async function pacientes() {
    const response = await fetch("http://localhost:3000/pacientes");
    const pacientes = await response.json();
    console.log("Pacientes:", pacientes);
    renderPacientes(pacientes);
}

// Função para criar a lista de psicólogos
function renderPsicologos(psiData) {
    const psicologosList = document.getElementById("psicologos-list");
    psicologosList.innerHTML = "";

    psiData.forEach((psicologo) => {
        const psicologoDiv = document.createElement("div");
        psicologoDiv.innerHTML = `
        <strong>${psicologo.nome}</strong><br>
        CRP: ${psicologo.crp}<br>
        Telefone: ${psicologo.telefone}<br>
        E-mail: ${psicologo.email}<br><br>`;
        psicologosList.appendChild(psicologoDiv);
    });
}

// Função para criar a lista de pacientes
function renderPacientes(pacienteData) {
    const pacientesList = document.getElementById("pacientes-list");
    pacientesList.innerHTML = "";

    pacienteData.forEach((paciente) => {
        const pacienteDiv = document.createElement("div");
        pacienteDiv.innerHTML = `
        <strong>${paciente.nome}</strong><br>
        Telefone: ${paciente.telefone}<br>
        E-mail: ${paciente.email}<br><br>`;
        pacientesList.appendChild(pacienteDiv);
    });
}

// Chamando as funções para renderizar as listas
async function obtendoDados() {
    await pacientes()
    await psicologos()
}

obtendoDados()