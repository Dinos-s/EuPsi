// aqui estará listado o modelo de table de psicologos que será criado no banco de dados;

import { DataTypes } from "sequelize";
import sequelize from "../dataBase/conect.js";

const psicologos = sequelize.define('psicologos', {
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
});

export default psicologos;