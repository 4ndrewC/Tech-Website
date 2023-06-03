const express = require("express");
const { boolean } = require("yargs");
const router = express.Router();
const db = require('../database');
const e = require("express");
var fs = require('fs');



router.get("/", async (req, res) => {
    const sqlstr = 'select * from submission'
    const dom = await db.promise().query(`select * from domains`)
    var domains = dom[0];
    console.log(domains)
    const subs = await db.promise().query(`select * from submission`)
    const subs1 = await db.promise().query(`select * from submission`)
    var results = []
    var des = subs[0]
    des.forEach((object) => {
        results.push(object);
    })


    var reg = subs1[0];
    // db.query(sqlstr, (err, results) => {
    //     if (err) return res.cc(err)
    //     console.log("session test 1" + req.session.islogin)
    //     var des = results;
    //     for (let i = 0; i < des.length; i++){
    //        des[i].tl1_desc = des[i].tl1_desc.replace(/"/g, '\\"');  
    //        des[i].tl2_desc = des[i].tl2_desc.replace(/"/g, '\\"');  
    //        des[i].tl3_desc = des[i].tl3_desc.replace(/"/g, '\\"');  
    //        des[i].tl4_desc = des[i].tl4_desc.replace(/"/g, '\\"');  
    //     }
    //     if (req.session.islogin) {
    //         res.render('admin', {results, domains, des});
    //     }
    //     else{
    //         res.redirect('/login');
    //     }
    // })
 

    // db.query(sqlstr, (err, results) => {
    //     if (err) return res.cc(err)
    //     des = results;
    //     result = results;
    //     // for (let i = 0; i < des.length; i++){
    //     //     des[i].tl1_desc = des[i].tl1_desc.replace(/"/g, '\"');
    //     //     des[i].tl1_desc = des[i].tl1_desc.replace(/’/g, "\\'");

    //     //     des[i].tl2_desc = des[i].tl2_desc.replace(/"/g, '\"');
    //     //     des[i].tl2_desc = des[i].tl2_desc.replace(/’/g, "\\'");

    //     //     des[i].tl3_desc = des[i].tl3_desc.replace(/"/g, '\"');
    //     //     des[i].tl3_desc = des[i].tl3_desc.replace(/’/g, "\\'");

    //     //     des[i].tl4_desc = des[i].tl4_desc.replace(/"/g, '\"');
    //     //     des[i].tl4_desc = des[i].tl4_desc.replace(/’/g, "\\'");
            

    //     // }
    //     console.log(des[0].tl1_desc)
        
    // })
    
   for (let i = 0; i < des.length; i++) {
        des[i].tl1_desc = des[i].tl1_desc.replace(/"/g, `\\"`);
        des[i].tl1_desc = des[i].tl1_desc.replace(/’/g, `\\’`);
        des[i].tl1_desc = des[i].tl1_desc.replace(/'/g, `\\'`);  
        des[i].tl1_desc = des[i].tl1_desc.replace(/”/g, `\\”`);
        des[i].tl1_desc = des[i].tl1_desc.replace(/‘/g, `\\‘`);
        des[i].tl1_desc = des[i].tl1_desc.replace(/”/g, `\\“`);
        des[i].tl1_desc = des[i].tl1_desc.replace(/\//g, "\\/");




        des[i].tl2_desc = des[i].tl2_desc.replace(/"/g, `\\"`);
        des[i].tl2_desc = des[i].tl2_desc.replace(/’/g, `\\’`);
        des[i].tl2_desc = des[i].tl2_desc.replace(/'/g, `\\'`);  
        des[i].tl2_desc = des[i].tl2_desc.replace(/”/g, `\\”`);
        des[i].tl2_desc = des[i].tl2_desc.replace(/‘/g, `\\‘`);
        des[i].tl2_desc = des[i].tl2_desc.replace(/”/g, `\\“`);
        des[i].tl2_desc = des[i].tl2_desc.replace(/\?/g, '\\?');
        des[i].tl2_desc = des[i].tl2_desc.replace(/\//g, "\\/");

        des[i].tl3_desc = des[i].tl3_desc.replace(/"/g, `\\"`);
        des[i].tl3_desc = des[i].tl3_desc.replace(/’/g, `\\’`);
        des[i].tl3_desc = des[i].tl3_desc.replace(/'/g, `\\'`);  
        des[i].tl3_desc = des[i].tl3_desc.replace(/”/g, `\\”`);
        des[i].tl3_desc = des[i].tl3_desc.replace(/‘/g, `\\‘`);
        des[i].tl3_desc = des[i].tl3_desc.replace(/”/g, `\\“`);
        des[i].tl3_desc = des[i].tl3_desc.replace(/\?/g, '\\?');
        des[i].tl3_desc = des[i].tl3_desc.replace(/\//g, "\\/");

        des[i].techname = des[i].techname.replace(/"/g, `\\"`);
        des[i].techname = des[i].techname.replace(/’/g, `\\’`);
        des[i].techname = des[i].techname.replace(/'/g, `\\'`);  
        des[i].techname = des[i].techname.replace(/”/g, `\\”`);
        des[i].techname = des[i].techname.replace(/‘/g, `\\‘`);
        des[i].techname = des[i].techname.replace(/”/g, `\\“`);
        des[i].techname = des[i].techname.replace(/\//g, "\\/");

        des[i].link = des[i].link.replace(/"/g, `\\"`);
        des[i].link = des[i].link.replace(/’/g, `\\’`);
        des[i].link = des[i].link.replace(/'/g, `\\'`);  
        des[i].link = des[i].link.replace(/”/g, `\\”`);
        des[i].link = des[i].link.replace(/‘/g, `\\‘`);
        des[i].link = des[i].link.replace(/”/g, `\\“`);
        des[i].link = des[i].link.replace(/\//g, "\\/");

        des[i].displaytext = des[i].displaytext.replace(/"/g, `\\"`);
        des[i].displaytext = des[i].displaytext.replace(/’/g, `\\’`);
        des[i].displaytext = des[i].displaytext.replace(/'/g, `\\'`);  
        des[i].displaytext = des[i].displaytext.replace(/”/g, `\\”`);
        des[i].displaytext = des[i].displaytext.replace(/‘/g, `\\‘`);
        des[i].displaytext = des[i].displaytext.replace(/”/g, `\\“`);
        des[i].displaytext = des[i].displaytext.replace(/\//g, "\\/");

        des[i].tl4_desc = des[i].tl4_desc.replace(/"/g, `\\"`);
        des[i].tl4_desc = des[i].tl4_desc.replace(/’/g, `\\’`);
        des[i].tl4_desc = des[i].tl4_desc.replace(/'/g, `\\'`);  
        des[i].tl4_desc = des[i].tl4_desc.replace(/”/g, `\\”`);
        des[i].tl4_desc = des[i].tl4_desc.replace(/‘/g, `\\‘`);
        des[i].tl4_desc = des[i].tl4_desc.replace(/”/g, `\\“`);
        des[i].tl4_desc = des[i].tl4_desc.replace(/\?/g, '\\?');
        des[i].tl4_desc = des[i].tl4_desc.replace(/\//g, "\\/");
        
    }
    // for (let i = 0; i < des.length; i++) {
    // des[i].tl1_desc = JSON.stringify(des[i].tl1_desc ).slice(1, -1);
    // des[i].tl2_desc = JSON.stringify(des[i].tl2_desc ).slice(1, -1);
    // des[i].tl3_desc = JSON.stringify(des[i].tl3_desc ).slice(1, -1);
    // des[i].tl4_desc = JSON.stringify(des[i].tl4_desc ).slice(1, -1);
    // des[i].displaytext = JSON.stringify(des[i].displaytext ).slice(1, -1);
    // des[i].techname = JSON.stringify(des[i].techname ).slice(1, -1);
    // des[i].link = JSON.stringify(des[i].link ).slice(1, -1);
    // }
    console.log(des)
    console.log(results[17].techname)
    console.log(reg[6].techname)
    console.log(des[15].tl1_desc)
    // if (req.session.islogin) {
    //             res.render('admin', {results, domains, des, reg});
    //         }
    //         else{
    //             res.redirect('/login');
    //         }
    res.render('admin', {results, domains, des, reg});


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

  router.post('/delete', function (req, res, next) {
    console.log("posted to admin")
    var user = { id: req.body.id}
    db.query(
        'DELETE FROM `submission` WHERE id = ' + req.body.id
    )
    db.query(
        'DELETE FROM `domains` WHERE id = ' + req.body.id
    )
    console.log("totally deleted tech tool: " + req.body.id)
    res.redirect('/admin')
  })

router.post('/add', (req, res) => {
    var user = {id: req.body.id}
  
    db.query('UPDATE submission SET accepted = ' + 1 + ' WHERE id = ' + req.body.id)
    console.log("accepted tech tool: " + req.body.id)
    res.redirect('/admin')
})
router.post('/edit', (req, res) => {
    console.log("1")
   
   console.log(req.body.tl1_desc)
   



   let b = "\'"

    //if (req.body.Techname != ''){
        //  let tech = b + req.body.Techname + b
        //  const sqlstr = 'select Techname from submission where id =' +  req.body.id1;

        //  db.query('UPDATE submission SET techname = '+  tech + '  WHERE id = ' + req.body.id1);
        
        // console.log( 'asdasdasd')
        let sql = "UPDATE submission SET techname = ? WHERE id = ?";
        let params = [req.body.Techname, req.body.id1];
        db.query(sql, params, (error, results, fields) => {
            if (error) {
            console.log(error);
            } else {
            console.log(results);
            }
        });
        


         
    //}
    //if (req.body.Link != ''){
        let sqllink = "UPDATE submission SET link = ? WHERE id = ?";
        let paramslink = [req.body.Link, req.body.id1];
        db.query(sqllink, paramslink, (error, results, fields) => {
            if (error) {
            console.log(error);
            } else {
            console.log(results);
            }
        });
        // let link1 = b + req.body.Link + b
        // db.query('UPDATE submission SET link = '+  link1 + '  WHERE id = ' + req.body.id1);
// }


    //if (req.body.description != ''){
        // let esc =  req.body.description.replace("'", "\\'")
        // let des1 = b + esc + b
        // db.query('UPDATE submission SET tl1_desc = '+  des1 + '  WHERE id = ' + req.body.id1);
        let sql1 = "UPDATE submission SET tl1_desc = ? WHERE id = ?";
        let params1 = [req.body.description, req.body.id1];
        db.query(sql1, params1, (error, results, fields) => {
            if (error) {
            console.log(error);
            } else {
            console.log(results);
            }
        });




  // }
  // if (req.body.description2 != ''){
    // let esc1 =  req.body.description2.replace("'", "\\'")
    // let des2 = b + esc1 + b

    // db.query('UPDATE submission SET tl2_desc = '+  des2 + '  WHERE id = ' + req.body.id1);

        let sql2 = "UPDATE submission SET tl2_desc = ? WHERE id = ?";
        let params2 = [req.body.description2, req.body.id1];
        db.query(sql2, params2, (error, results, fields) => {
        if (error) {
            console.log(error);
        } else {
            console.log(results);
        }
        });
   // }

   //if (req.body.description3 != ''){
    // let esc2=  req.body.description3.replace("'", "\\'")
    // let des3 = b +esc2 + b
    // db.query('UPDATE submission SET tl3_desc = '+  des3 + '  WHERE id = ' + req.body.id1);
        let sql3 = "UPDATE submission SET tl3_desc = ? WHERE id = ?";
        let params3 = [req.body.description3, req.body.id1];
        db.query(sql3, params3, (error, results, fields) => {
        if (error) {
            console.log(error);
        } else {
            console.log(results);
        }
        });
       // }
   // if (req.body.description4 != ''){
        // let esc3=  req.body.description4.replace("'", "\\'")
        // let des4 = b + esc3 + b
        // db.query('UPDATE submission SET tl4_desc = '+  des4 + '  WHERE id = ' + req.body.id1);
        let sql4 = "UPDATE submission SET tl4_desc = ? WHERE id = ?";
        let params4 = [req.body.description4, req.body.id1];
        db.query(sql4, params4, (error, results, fields) => {
        if (error) {
            console.log(error);
        } else {
            console.log(results);
        }
        });
   // }



   //if (req.body.display != ''){
        // let display1 = b + req.body.display + b
        // db.query('UPDATE submission SET displaytext = '+  display1 + '  WHERE id = ' + req.body.id1);

        let sql5 = "UPDATE submission SET displaytext = ? WHERE id = ?";
        let params5 = [req.body.display, req.body.id1];
        db.query(sql5, params5, (error, results, fields) => {
        if (error) {
            console.log(error);
        } else {
            console.log(results);
        }
        });


    //}
    // console.log(req.body.R)
    var response = new Array(req.body.R, req.body.TP, req.body.MT, req.body.AR,  req.body.U, req.body.MDL, req.body.RA, req.body.RoTech,
         req.body.LS, req.body.RoThink, req.body.EoST,req.body.EF,req.body.RTE,req.body.DLoI,req.body.RaAoC); 
     console.log(response)    
     for(let i=0; i<response.length; i++){
            if(response[i]==='on' || response[i]==='true' ){
                response[i] = 1;
            }
            else{
                response[i] = 0;
            }
            }
     console.log(response)


    db.query('UPDATE domains SET R = '+   response[0] + '  WHERE id = ' + req.body.id1);
    db.query('UPDATE domains SET TP = '+   response[1] + '  WHERE id = ' + req.body.id1);
    db.query('UPDATE domains SET MT = '+   response[2] + '  WHERE id = ' + req.body.id1);
    db.query('UPDATE domains SET AR = '+   response[3] + '  WHERE id = ' + req.body.id1);
    db.query('UPDATE domains SET U = '+   response[4] + '  WHERE id = ' + req.body.id1);
    db.query('UPDATE domains SET MDL = '+   response[5] + '  WHERE id = ' + req.body.id1);
    db.query('UPDATE domains SET RA = '+   response[6] + '  WHERE id = ' + req.body.id1);
    db.query('UPDATE domains SET RoTech = '+   response[7] + '  WHERE id = ' + req.body.id1);
    db.query('UPDATE domains SET LS = '+   response[8] + '  WHERE id = ' + req.body.id1);
    db.query('UPDATE domains SET RoThink = '+   response[9] + '  WHERE id = ' + req.body.id1);
    db.query('UPDATE domains SET EoST = '+   response[10] + '  WHERE id = ' + req.body.id1);
    db.query('UPDATE domains SET EF = '+  response[11] + '  WHERE id = ' + req.body.id1);
    db.query('UPDATE domains SET RTE = '+  response[12] + '  WHERE id = ' + req.body.id1);
    db.query('UPDATE domains SET DLoI = '+   response[13] + '  WHERE id = ' + req.body.id1);
    db.query('UPDATE domains SET RaAoC = '+   response[14] + '  WHERE id = ' + req.body.id1);


    
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
