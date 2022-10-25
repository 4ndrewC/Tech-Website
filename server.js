const express = require("express")
const app = express()

//middlewares
app.use(express.json())
app.use(express.urlencoded({extended:true}))


app.set('view engine', 'ejs')


app.get("/", (req, res) => {
    res.render('index')
})


app.listen(8000)