import paciente from '../models/pacienteModel.js'

// 1 - salvar paciente
const savePaciente = async(pacienteModel) => {
    const save = await paciente.create(pacienteModel)
    return save
}

// 2 - busca todos os pacientes
const getAllPacientes = async() => {
    return await paciente.findAll({
        order: [
            ['id', 'ASC']
        ]
    })
}

// 3 - busca o paciente por id
const getPacienteById = async (id) => {
    return await paciente.findByPk(id)
}

// 4 - atualizar os dados do paciente
const updatePaciente = async (id, pacienteModel) =>{
    try {
        const result = await paciente.update(pacienteModel, {
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

// 5 - Deletar paciente
const deletaPaciente = async(id) => {
    return await paciente.destroy({
        where: {
            id: id,
        }
    })
}

// 6 - Verificar se o pacienten está cadastrado
const getPacienteByEmail = async (email) => {
    return await paciente.findOne({
        where: {
            email: email,
        },
    });
};

// 7 - Contanto o total de paciente cadastrados
const totalPacientes = async() => {
    return await paciente.count()
} 

const factory = {
    savePaciente,
    getAllPacientes,
    getPacienteById,
    updatePaciente,
    deletaPaciente,
    getPacienteByEmail,
    totalPacientes,
}

// Exporta os dados para que possam ser usados em outro arquivo
export default factory