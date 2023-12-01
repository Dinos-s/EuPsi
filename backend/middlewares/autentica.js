import jwt from "jsonwebtoken";

const checkToken = (req, res, next) => {
    const authHeader = req.headers['authorization']
    const token = authHeader && authHeader.split(' ')[1]

    if (!token) {
        return res.status(401).json({ menssagem: 'Acesso Negado' })
    }

    try {
        const secret = process.env.SECRET || 'seuSegredoDoToken' // Caso o process.env.SECRET não funcione use outro valor
        const decoded = jwt.verify(token, secret);
        req.user = decoded;  // Adiciona o usuário decodificado ao objeto de requisição para uso posterior

        // Verifica se o ID do usuário no token é o mesmo do ID nos parâmetros da URL
        if (req.params.id && req.user.id !== parseInt(req.params.id, 10)) {
            return res.status(403).json({ mensagem: 'Acesso não autorizado' });
        }
        next()
    } catch (error) {
        res.status(400).json({ menssagem: 'Token Invalido' })
        console.log(error);
    }
}

export default checkToken