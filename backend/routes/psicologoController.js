import express from "express";
let router = express.Router()
import psiService from "../services/PsicologoService.js";

router.post('/addPsicologo', async (req, res) => {
    const { nome, crp, telefone, email, senha } = req.body

    const PsiModel = {
        nome: nome,
        crp: crp,
        telefone: telefone,
        email: email,
        senha: senha
    }

    const psicologo = await psiService.savePsicologo(PsiModel)
    return res.status(201).json(psicologo)
})

router.get('/psicologos', async (req, res) => {
    const allPisicologos = await psiService.getAllPisicologos()
    return res.status(200).json(allPisicologos)
})

router.get('/psicologos/:id', async (req, res) => {
    const psicologo = await psiService.getPisicologoById(req.params.id)
    return res.status(200).json()
})

router.put('/updatePsi/:id', async (req, res) => {
    const { nome, crp, telefone, email, senha } = req.body

    const PsiModel = {
        nome: nome,
        crp: crp,
        telefone: telefone,
        email: email,
        senha: senha
    }

    const psicologo = await psiService.updatePsicologo(req.params.id, PsiModel)
    return res.status(200).json(psicologo)
})

router.delete('/deletePsicologo', async (req, res) => {
    const psicologo = await psiService.deletaPsicologo(req.params.id)
    return res.status(200).json(psicologo)
})

export default router