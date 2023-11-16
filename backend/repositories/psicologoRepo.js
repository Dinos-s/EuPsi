import psicologo from "../models/psicologoModel.js";

// 1 - salvar psicologo
const savePsicologo = async(psiModel) => {
    const save = await psicologo.create(psiModel)
    return save
}

// 2 - busca todos os psicologos
const getAllPisicologos = async() => {
    return await psicologo.findAll({
        order: [
            ['id', 'ASC']
        ]
    })
}

// 3 - busca o psicologo por id
const getPisicologoById = async(id) => {
    return await psicologo.findByPk(id)
}

// 4 - atualizar dados do psicologo
const updatePsicologo = async(id, psiModel) => {
    try {
        const result = await psicologo.update(psiModel, {
            where: {
                id: id,
            }
        })
        if (result[0] === 1) {
            return {
                message: 'Dados atualizados com sucesso'
            }
        } else {
            return {
                message:` Usuário de número ${id}, não foi encontrado`
            }
        }
    } catch (error) {
        return error
    }
}

// 5 - Deletar pisicologo
const deletaPsicologo = async (id) => {
    return await psicologo.destroy({
        where: {
            id: id,
        }
    })
}

const factory = {
    savePsicologo,
    getAllPisicologos,
    getPisicologoById,
    updatePsicologo,
    deletaPsicologo
}

export default factory