import express from 'express';
import bcrypt from "bcrypt";
import jwt from "jsonwebtoken";
import multer from "multer";
import dotenv from 'dotenv'
dotenv.config()

let router = express.Router();
import checkToken from "../middlewares/autentica.js";
import psiService from "../services/PsicologoService.js";

const storage = multer.diskStorage({
    destination: (req, file, callback) => {
        callback(null, './images')
    },
    filename: (req, file, callback) => {
        const { nome } = req.body
        const time = new Date.now()
        callback(null, `${nome}_${time}_${file.originalname}`)
    }
})

const upload = multer({ storage: storage }).single('file')

router.post('/addPsicologo', async (req, res) => {
    const { nome, crp, telefone, email, senha } = req.body

    //emcriptando a senha
    const salt = await bcrypt.genSalt(12)
    const senhaHash = await bcrypt.hash(senha, salt)

    const PsiModel = {
        nome: nome,
        crp: crp,
        telefone: telefone,
        email: email,
        senha: senhaHash
    }

    const psicologo = await psiService.savePsicologo(PsiModel)
    return res.status(201).json(psicologo)
})

//rota de login do psicologo
router.post('/psicologo/login', async(req, res) => {
    const { email, senha } = req.body
    
    // Verificar se o psicologo exite no banco de dados
    const psicologo = await psiService.getPsicologoByEmail(email)
    if (!psicologo) {
        return res.status(401).json({mensagem: 'Credenciais inválidas email'})
    }

    // Verifica se a senha fornecida corresponde à senha cadastrada no banco de dados
    const senhaCorreta = await bcrypt.compare(senha, psicologo.senha)
    if (!senhaCorreta) {
        return res.status(401).json({ mensagem: 'Credenciais inválidas senha' })
    }

    try {
        // Gerar token de atualização
        const secret = process.env.SECRET || 'seuSegredoDoToken'
        const token = jwt.sign(
            { id: psicologo.id,
              nome: psicologo.nome,
            },
            secret,
            { expiresIn: '1h', }
        )
        return res.status(200).json({ token })
    } catch (error) {
        console.error('Erro durante o login:', error);
        return res.status(500).json({ mensagem: 'Erro interno do servidor' });
    }
})

router.get('/psicologos', async (req, res) => {
    const allPisicologos = await psiService.getAllPisicologos()
    return res.status(200).json(allPisicologos)
})

router.get('/psicologo/:id', async (req, res) => {
    const psicologo = await psiService.getPisicologoById(req.params.id)
    return res.status(200).json(psicologo)
})

// rota de acesso apenas para um unico usuário
router.get('/psicologo/auth/:id', checkToken, async (req, res) => {
    try {
        const psicologo = await psiService.getPisicologoById(req.params.id);

        if (!psicologo) {
            return res.status(404).json({ mensagem: 'Psicólogo não encontrado' })
        }

        return res.status(200).json(psicologo)
    } catch (error) {
        return res.status(500).json({ mensagem: 'Erro interno do servidor'})
    }
})

router.get('/total/Psicologos', async (req, res) => {
    const totalPsicologos = await psiService.getTotalPsi()
    return res.status(200).json(totalPsicologos)
})

router.put('/updatePsi/:id', async (req, res) => {
    const { nome, crp, telefone, email, senha, resumo } = req.body

    const PsiModel = {
        nome: nome,
        crp: crp,
        telefone: telefone,
        email: email,
        senha: senha,
        resumo: resumo,
    }

    const psicologo = await psiService.updatePsicologo(req.params.id, PsiModel)
    return res.status(200).json(psicologo)
})

router.delete('/deletePsicologo/:id', async (req, res) => {
    const psicologo = await psiService.deletaPsicologo(req.params.id)
    return res.status(200).json(psicologo)
})

export default router