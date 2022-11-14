const express = require("express")
const app = express()
const db = require('./database')

//middlewares
app.use(express.json())
app.use(express.urlencoded({extended:true}))


app.set('view engine', 'ejs')


app.get("/", async (req, res) => {
    const content = await db.promise().query(`select * from submission`);
    console.log(content[0]);
    res.render('index');
})

//import new modules (routes)
const submissionRouter = require('./routes/submission')

//add new routes
app.use('/submission', submissionRouter)

//use static files
app.use('/public', express.static('public'))

app.listen(8000)
