import psiRepo from "../repositories/psicologoRepo.js";

const savePsicologo = (psiModel) => {
    return psiRepo.savePsicologo(psiModel)
}

const getAllPisicologos = () => {
    return psiRepo.getAllPisicologos()
}

const getPisicologoById = (id) => {
    return psiRepo.getPisicologoById(id)
}

const updatePsicologo = (id, psiModel) => {
    return psiRepo.updatePsicologo(id, psiModel)
}

const deletaPsicologo = (id) => {
    return psiRepo.deletaPsicologo(id)
}

const getPsicologoByEmail = (email) => {
    return psiRepo.getPsicologoByEmail(email)
}

const getTotalPsi = () => {
    return psiRepo.totalPsi()
}

const service = {
    savePsicologo,
    getAllPisicologos,
    getPisicologoById,
    updatePsicologo,
    deletaPsicologo,
    getPsicologoByEmail,
    getTotalPsi,
}

export default service