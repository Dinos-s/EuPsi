import express from "express";
import jwt from "jsonwebtoken";

const checkToken = (req, res, next) => {
    const authHeader = req.headers['authorization']
    const token = authHeader && authHeader.split(' ')[1]

    if (!token) {
        return res.status().json({menssagem: 'Acesso Negado'})
    }

    try {
        const secret = process.env.SECRET
        jwt.verify(token, secret)
        next()
    } catch (error) {
        res.status(400).json({menssagem: 'Token Invalido'})
    }

}

export default checkToken