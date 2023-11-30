import { Sequelize } from "sequelize";
import dotenv from 'dotenv'
dotenv.config()

const sequelize = new Sequelize (
    process.env.NOME_BANCO || 'eupsi',
    process.env.USER || 'root',
    process.env.PASS_BD || '0000',
    {
        host: process.env.HOST || 'localhost',
        dialect: 'mysql',
        port: 3306,
        define: {
            timestamps: true
        }
    }
);

export default sequelize;

// aqui ficará alguns dados de conexão como o banco de dados;