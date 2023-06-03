const express = require("express");
const { boolean } = require("yargs");
const router = express.Router();
const db = require('../database');

router.get("/", async (req, res) => {
    res.render('submissionpage');
})

router.post("/", async (req, res) => {
    const content = req.body;
    const results = await db.promise().query(`select * from submission`);
    const submissions = results[0];
    
    // console.log(content.UserName);
    // console.log(content.Techname);
    // console.log(content.Description);
    
    //parsing checkboxes
    var [R, TP, MT, AR, U, MDL, RA, RoTech, LS, RoThink, EoST, EF, RTE, DLoI, RaAoC] = [content.R, content.TP, content.MT, content.AR, content.U, content.MDL, content.RA, content.RoTech, content.LS, content.RoThink, content.EoST, content.EF, content.RTE, content.DLoI, content.RaAoC];
    if(!R) console.log("nice")
    if(!R) R = false; else R = true;
    if(!TP) TP = false; else TP = true;
    if(!MT) MT = false; else MT = true;
    if(!AR) AR = false; else AR = true;
    if(!U) U = false; else U = true;
    if(!MDL) MDL = false; else MDL = true;
    if(!RA) RA = false; else RA = true;
    if(!RoTech) RoTech = false; else RoTech = true;
    if(!LS) LS = false; else LS = true;
    if(!RoThink) RoThink = false; else RoThink = true;
    if(!EoST) EoST = false; else EoST = true;
    if(!EF) EF = false; else EF = true;
    if(!RTE) RTE = false; else RTE = true;
    if(!DLoI) DLoI = false; else DLoI = true;
    if(!RaAoC) RaAoC = false;  else RaAoC = true;

    //retrieve latest id generated and the increment by 1
    const current = await db.promise().query(`select * from submission`);
    var last = 0;
    if(current[0]!=0)last = current[0][current[0].length-1]["id"];
    last+=1;
    // db.promise().query(`insert into submission values(${last}, '${content.techname}', '${content.description}', '${content.categories}', accepted, '${content.username}', '${content.contact}')`);

    
    // file['name'] = req.body.Techname  + ".png";
    // file['name'] =str.replace(/\s+/g, '_')  + ".png";
    console.log(last)
    // file['name'] =last  + ".png";
    // console.log(file.name)
    if(req.files){
        console.log(req.files.file['name'])
        var file = req.files.file
        var str =  req.body.Techname 
        file.mv('./images/'+file.name, function(err){
            if(err){
                res.send(err)
            }
            else{
                console.log("file uploaded")
            }
        })
    }
    
    
    await db.promise().query(`insert into submission values(${last}, "${content.Techname}", "${content.tl1_desc}", "${content.tl2_desc}", "${content.tl3_desc}", "${content.tl4_desc}", "${content.link}", "${content.displaytext}", 0, "${content.UserName}", "${content.contact}")`);
    // await db.promise().query(`insert into submission values(123, "asdofm", "asdf", "adsf", "asd", "some", 1, "asdof", "asdf")`);
    await db.promise().query(`insert into domains values(${last}, ${R}, ${TP}, ${MT}, ${AR}, ${U}, ${MDL}, ${RA}, ${RoTech}, ${LS}, ${RoThink}, ${EoST}, ${EF}, ${RTE}, ${DLoI}, ${RaAoC})`)
    
    res.redirect("/");
})

module.exports = router
