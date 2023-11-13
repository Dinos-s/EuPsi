import express from 'express';
let router = express.Router();
import pacienteService from '../services/PacienteSevice.js'

router.post('/addPaciente', async (req, res) => {
    const { nome, telefone, email, senha } = req.body
    
    const PacienteModel = {
        nome: nome,
        telefone: telefone,
        email: email,
        senha: senha
    }

    const paciente = await pacienteService.savePaciente(PacienteModel)
    return res.status(201).json(paciente)
})

router.get('/pacientes', async (req, res) => {
    const allPacientes = await pacienteService.getAllPacientes()
    return res.status(200).json(allPacientes)
})

router.get('/paciente/:id', async (req, res) => {
    const paciente = await pacienteService.getPacienteById(req.params.id)
    return res.status(200).json(paciente)
})

router.put('/updatePaciente/:id', async (req, res) => {
    const { nome, telefone, email, senha } = req.body
    
    const PacienteModel = {
        nome: nome,
        telefone: telefone,
        email: email,
        senha: senha
    }

    const paciente = await pacienteService.updatePaciente(req.params.id, PacienteModel)
    return res.status(200).json(paciente)
})

router.delete('/deletePaciente/:id', async (req, res) => {
    const paciente = await pacienteService.deletaPaciente(req.params.id)
    return res.status(200).json(paciente)
})

export default router