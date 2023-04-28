const express = require("express");
const { boolean } = require("yargs");
const router = express.Router();
const db = require('../database');



router.get("/", async (req, res) => {
    const sqlstr = 'select * from submission'
    const dom = await db.promise().query(`select * from domains`)
    var domains = dom[0];
    // console.log(domains)
    db.query(sqlstr, (err, results) => {
        if (err) return res.cc(err)
        console.log("session test 1" + req.session.islogin)
        if (req.session.islogin == true) {
            res.render('admin', {results, domains});
        }
        else{
            res.redirect('/login');
        }
    })
  

})

router.post('/remove', function (req, res, next) {
    console.log("posted to admin")
    var user = { id: req.body.id}
    
    db.query(
        'UPDATE submission SET accepted = ' + 0 + ' WHERE id = ' + req.body.id
    )
    console.log("deleted tech tool: " + req.body.id)
    res.redirect('/admin')
  })

router.post('/add', (req, res) => {
    var user = {id: req.body.id}
  
    db.query('UPDATE submission SET accepted = ' + 1 + ' WHERE id = ' + req.body.id)
    console.log("accepted tech tool: " + req.body.id)
    res.redirect('/admin')
})
router.post('/edit', (req, res) => {
   
   // console.log(req.body.Techname)
    let b = "\'"
    console.log( 'asdasdasd')
    if (req.body.Techname != ''){
         let tech = b + req.body.Techname + b
         db.query('UPDATE submission SET techname = '+  tech + '  WHERE id = ' + req.body.id1);
    }
    if (req.body.Link != ''){
        let link1 = b + req.body.Link + b
        db.query('UPDATE submission SET link = '+  link1 + '  WHERE id = ' + req.body.id1);
   }
    if (req.body.description != ''){
        let des = b + req.body.description + b
        db.query('UPDATE submission SET description = '+  des + '  WHERE id = ' + req.body.id1);
   }
   if (req.body.display != ''){
        let display1 = b + req.body.display + b
        db.query('UPDATE submission SET displaytext = '+  display1 + '  WHERE id = ' + req.body.id1);
    }
    
    res.redirect('/admin')
})
// router.post('/signout', (req, res) => {
//     var user = {id: req.body.id}
//     console.log("worked")
//     res.session.islogin = false;
// 	res.redirect('/login');
// })

// delete
router.post('/2', (req, res) => {
    var user = {id: req.body.id}
    db.query('DELETE FROM submission WHERE id = ' + req.body.id)
    console.log("rejected tech tool: " + req.body.id)
})

router.post('/csvout', (req, res) => {


})
module.exports = router
