const express = require("express")
const app = express()
const db = require('./database')

//middlewares
app.use(express.json())
app.use(express.urlencoded({extended:true}))


app.set('view engine', 'ejs')


app.get("/", async (req, res) => {
    const content = await db.promise().query(`select * from submission`);
    // console.log(content[0]);
    res.render('index');
})

app.post("/", async (req, res) => {
    const content = req.body;
    console.log(content.UserName);
    console.log(content.Techname);
    console.log(content.Description);
    await db.promise().query(`insert into submissions values(1, '${content.Techname}', '${content.Description}', true, false, false, false, false, '${content.UserName}', 'your mom')`);
    res.redirect("/");
})

//import new modules (routes)
const submissionRouter = require('./routes/submission')
const tl1Router = require('./routes/tl1')
const tl1Router = require('./routes/tl2')
const tl1Router = require('./routes/tl3')
const tl1Router = require('./routes/tl4')

//add new routes
app.use('/submission', submissionRouter)
app.use('/tl1', tl1Router)
app.use('/tl2', tl1Router)
app.use('/tl3', tl1Router)
app.use('/tl4', tl1Router)

//use static files
app.use('/public', express.static('public'))

app.listen(8000)
