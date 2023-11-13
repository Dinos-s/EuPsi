import { Sequelize } from "sequelize";

const sequelize = new Sequelize (
    'eupsi',
    'root',
    '0000',
    {
        host: 'localhost',
        dialect: 'mysql',
        port: 3306,
        define: {
            timestamps: false
        }
    }
);

export default sequelize;

// aqui ficará alguns dados de conexão como o banco de dados;