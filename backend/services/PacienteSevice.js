import pacienteRepo from "../repositories/pacienteRepo.js";

const savePaciente = (pacienteModel) => {
    return pacienteRepo.savePaciente(pacienteModel)
}

const getAllPacientes = () => {
    return pacienteRepo.getAllPacientes()
}

const getPacienteById = (id) => {
    return pacienteRepo.getPacienteById(id)
}

const updatePaciente = (id, pacienteModel) => {
    return pacienteRepo.updatePaciente(id, pacienteModel)
}

const deletaPaciente = (id) => {
    return pacienteRepo.deletaPaciente(id)
}

const getPacienteByEmail = (email) => {
    return pacienteRepo.getPacienteByEmail(email)
}

const service = {
    savePaciente,
    getAllPacientes,
    getPacienteById,
    updatePaciente,
    deletaPaciente,
    getPacienteByEmail
}

export default service