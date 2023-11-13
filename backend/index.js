const express = require('express')
const pkg = require('./dataBase/conect')


(async () => {
    try {
        await sequelize.sync();
        app.listen(3000, function () {
            console.log("Listening to port 3000");
        });
    } catch (err) {
        console.log(err);
    }
})();