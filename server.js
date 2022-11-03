const express = require("express")
const app = express()
const db = require('./database')

//middlewares
app.use(express.json())
app.use(express.urlencoded({extended:true}))


app.set('view engine', 'ejs')


app.get("/", async (req, res) => {
    const content = await db.promise().query(`select * from submissions`);
    console.log(content);
    res.render('index');
})


app.listen(8000)
