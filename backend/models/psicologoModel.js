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
    nome: {
        type: DataTypes.STRING,
        allowNull: false,
    },
    photo_perfil: {
        type: DataTypes.BLOB,
        allowNull: true,
    },
    crp: {
        type: DataTypes.STRING,
        allowNull: false,
        unique: true
    },
    telefone: {
        type: DataTypes.STRING,
        allowNull: false,
    },
    email: {
        type: DataTypes.STRING,
        allowNull: false,
        unique: true,
    },
    senha: {
        type: DataTypes.STRING,
        allowNull: false,
    },
    status: {
        type: DataTypes.STRING,
        allowNull: false,
        defaultValue: 'I', // por pradrão recebe um I de inativo;
    },
}, {timestamps: true});

export default psicologo;