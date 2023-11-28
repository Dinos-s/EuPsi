import express from 'express';
let router = express.Router();
import pacienteController from "./pacienteController.js";
import psicologoController from './psicologoController.js';


router.get('/', (req, res) => {
    console.log('Enfim está funcionando');
})

router.use('/', pacienteController)
router.use('/', psicologoController)

export default router;