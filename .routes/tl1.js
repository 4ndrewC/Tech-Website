const express = require("express");
const router = express.Router();
const db = require('../database');

router.get("/", async (req, res) => {
    //get tech under tl1 category
    const subs = await db.promise().query(`select * from submissions`);
    const tl1true = await db.promise().query(`select * from domains where R = true or TP = true or MT = true or AR = true`);
    //list contains list of entrys with domains that are part of tl1
    const list = tl1true[0];
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
    res.render('tl1', {content: results});
})

module.exports = router;
