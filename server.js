const express = require("express")
const app = express()
const db = require('./database')
const upload = require('express-fileupload')

//middlewares
app.use(express.json())
app.use(express.urlencoded({extended:true}))
app.use(upload())

const session=require('express-session')
 app.use(
    session({
        secret:'myself',//secrect属性的值可以为任意字符串
        resave:false,//固定写法
        saveUninitialized:true,//固定写法
        cookie: {maxAge: 1800000},  //设置maxAge是1800000ms，即30分钟后session和相应的cookie失效过期
        rolling: true
    }))



app.set('view engine', 'ejs')


app.get("/", async (req, res) => {
    res.render('index');
})



//import new modules (routes)
const submissionRouter = require('./routes/submission')
const tl1Router = require('./routes/tl1')
const tl2Router = require('./routes/tl2')
const tl3Router = require('./routes/tl3')
const tl4Router = require('./routes/tl4')
const adminrouter = require('./routes/admin')
const loginrouter = require('./routes/login')
const testrouter = require('./routes/test')

const realdatarouter = require('./routes/realdata')
const truncaterouter = require('./routes/truncate')
const searchrouter = require('./routes/searchpage')
const realdata3router = require('./routes/realdata3')


//add new routes
app.use('/submission', submissionRouter)
app.use('/tl1', tl1Router)
app.use('/tl2', tl2Router)
app.use('/tl3', tl3Router)
app.use('/tl4', tl4Router)
app.use('/admin', adminrouter)
app.use('/login', loginrouter)
//app.use('/test', testrouter)
app.use('/searchpage', searchrouter)

app.use('/realdata', realdatarouter)
app.use('/truncate', truncaterouter)
app.use('/realdata3', realdata3router)
//use static files
app.use('/public', express.static('public'));
app.use('/testuploads', express.static('testuploads'));
app.listen(8080)
