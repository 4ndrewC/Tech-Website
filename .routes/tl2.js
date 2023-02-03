const express = require("express");
const router = express.Router();
const db = require('../database');

router.get("/", async (req, res) => {
    //get tech under tl1 category
    const subs = await db.promise().query(`select * from submissions`);
    const tl2true = await db.promise().query(`select * from domains where U = true or MDL = true or RA = true or RoTech = true or LS = true`);
    //list contains list of entrys with domains that are part of tl1
    const list = tl2true[0];
    var ids = [];
    for(let i = 0; i<list.length; i++){
        ids.push(list[i]["id"]);
    }
    var content = [];
    for(let i = 0; i<subs[0].length; i++){
        if(ids.includes(subs[0][i]["id"])){
            content.push(subs[0][i]);
        }
    }
    var results = [content, list];
    console.log(ids)
    console.log(content);
    res.render('tl2', {content: results});
})

module.exports = router;
