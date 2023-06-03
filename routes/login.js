const express = require("express");
const { boolean } = require("yargs");
const router = express.Router();
const db = require('../database');

router.get("/", async (req, res) => {
    res.render('login');
    // const sqlstr = 'select * from submission'
    // db.query(sqlstr, (err, results) => {
    //     res.render('login', { results })
    // })
})

router.post('/', function (req, res, next) {
    console.log("posted to login")
    //var user = { id: req.body.id}
    
     const pw = req.body.password 
     const us = req.body.username

    // if (pw === "admin" && us === "root"){
    //     req.session.islogin=true  
    //     res.redirect("/admin")      
    // }
    // else {
    //     req.session.islogin=false
    //     res.send({ status:0, msg:'fails'})     
    // }    
    const sqlstr = 'SELECT PW, User from login'
    db.query(sqlstr, (err, results) => {
        if (err) return res.cc(err)

        console.log(results);
        const match = results.find((row) => row.PW === pw && row.User === us);

        if (match){
            req.session.islogin=true  
            res.redirect("/admin")      
        }
        else {
            req.session.islogin=false
            res.send({ status:0, msg:'fails'})     
        }    
    })    
})

module.exports = router
