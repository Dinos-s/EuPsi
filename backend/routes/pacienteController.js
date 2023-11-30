import express from 'express';
import bcrypt from "bcrypt";
import jwt from "jsonwebtoken";
import dotenv from 'dotenv'
dotenv.config()

let router = express.Router();
import pacienteService from '../services/PacienteSevice.js'
import checkToken from "../middlewares/autentica.js";

router.post('/addPaciente', async (req, res) => {
    const { nome, cpf, telefone, email, senha } = req.body

    //emcriptando a senha
    const salt = await bcrypt.genSalt(12)
    const senhaHash = await bcrypt.hash(senha, salt)

    const PacienteModel = {
        nome: nome,
        cpf: cpf,
        telefone: telefone,
        email: email,
        senha: senhaHash
    }

    const paciente = await pacienteService.savePaciente(PacienteModel)
    return res.status(201).json(paciente)
})

//rota de login do paciente
router.post('/paciente/login', async (req, res) => {
    const { email, senha } = req.body

    // Verificar se o paciente existe no banco de dados
    const paciente = await pacienteService.getPacienteByEmail(email);
    if (!paciente) {
        return res.status(401).json({ mensagem: 'Credenciais inválidas email' });
    }

    // Verificar se a senha fornecida corresponde à senha cadastrada no banco de dados
    const senhaCorreta = await bcrypt.compare(senha, paciente.senha);
    if (!senhaCorreta) {
        return res.status(401).json({ mensagem: 'Credenciais inválidas senha' });
    }

    try {
        // Gerar token de autenticação
        const secret = process.env.SECRET || 'seuSegredoDoToken' // Caso o process.env.SECRET não funcione use outro valor
        const token = jwt.sign(
            { id: paciente.id,
              nome: paciente.nome,
            },
            secret ,
            { expiresIn: '1h', }
        );

        return res.status(200).json({ token });
    } catch (error) {
        console.error('Erro durante o login:', error);
        return res.status(500).json({ mensagem: 'Erro interno do servidor'});
    }
});

router.get('/pacientes', async (req, res) => {
    const allPacientes = await pacienteService.getAllPacientes()
    return res.status(200).json(allPacientes)
})

router.get('/total/Pacientes', async (req, res) => {
    const totalPacientes = await pacienteService.getTotalPacientes()
    return res.status(200).json(totalPacientes)
})

router.get('/paciente/:id', async (req, res) => {
    const paciente = await pacienteService.getPacienteById(req.params.id)
    return res.status(200).json(paciente)
})

// rota de acesso apenas para um unico usuário 
router.get('/paciente/auth/:id', checkToken, async (req, res) => {
    try {
        const paciente = await pacienteService.getPacienteById(req.params.id);

        if (!paciente) {
            return res.status(404).json({ mensagem: 'Paciente não encontrado' })
        }

        return res.status(200).json(paciente)
    } catch (error) {
        return res.status(500).json({ mensagem: 'Erro interno do servidor'})
    }
})

router.put('/updatePaciente/:id', async (req, res) => {
    const { nome, cpf, telefone, email, senha } = req.body

    const PacienteModel = {
        nome: nome,
        cpf: cpf,
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