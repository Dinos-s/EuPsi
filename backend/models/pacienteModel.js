// aqui estará listado o modelo de table de usuario que será criado no banco de dados;
import { DataTypes } from "sequelize";
import sequelize from "../dataBase/conect.js";

const pacientes = sequelize.define('pacientes', {
    id: {
        type: DataTypes.INTEGER,
        autoIncrement: true,
        primaryKey: true,
    },
    nome: {
        type: DataTypes.STRING,
        allowNull: false,
    },
    telefone: {
        type: DataTypes.STRING(15),
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
}, { timestamps: true });

export default pacientes;