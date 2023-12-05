import express from "express";
import pkg from 'body-parser';
import sequelize from './dataBase/conect.js';
import router from './routes/router.js';
import cors from "cors";

const port = process.env.PORT || 3000
const app = express();
const { json, urlencoded } = pkg

app.use(json());
app.use(urlencoded({ extended: true }));
app.use(cors())
app.use("/", router);

(async () => {
    try {
        await sequelize.sync();
        app.listen(port, function () {
            console.log(`Rodando na porta: ${port}`);
        });
    } catch (err) {
        console.log(err);
    }
})();