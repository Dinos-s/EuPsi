// aqui estará listado o modelo de table de psicologos que será criado no banco de dados;

import { DataTypes } from "sequelize";
import sequelize from "../dataBase/conect.js";

const psicologo = sequelize.define('psicologos', {
    id: {
        type: DataTypes.INTEGER,
        autoIncrement: true,
        allowNull: false,
        primaryKey: true,
    },
    photo_perfil: {
        type: DataTypes.BLOB,
        allowNull: true
    },
    nome: {
        type: DataTypes.STRING,
        allowNull: false,
    },
    crp: {
        type: DataTypes.STRING,
        allowNull: false,
    },
    telefone: {
        type: DataTypes.STRING,
        allowNull: false,
    },
    email: {
        type: DataTypes.STRING,
        allowNull: false,
    },
    senha: {
        type: DataTypes.STRING,
        allowNull: false,
    },
    valor_sessao: {
        type: DataTypes.FLOAT,
        allowNull: true,
    },
    tempo_sessao: {
        type: DataTypes.INTEGER,
        allowNull: true,
    },
    experiencia: {
        type: DataTypes.STRING,
        allowNull: true,
    },
    especialidade: {
        type: DataTypes.STRING,
        allowNull: true,
    },
    formacao: {
        type: DataTypes.STRING,
        allowNull: true,
    },
    localidade: {
        type: DataTypes.STRING,
        allowNull: true,
    },
    abordagens: {
        type: DataTypes.TEXT,
        allowNull: true,
    },
    descricao_pessoal: {
        type: DataTypes.TEXT,
        allowNull: true,
    },
});

export default psicologo;