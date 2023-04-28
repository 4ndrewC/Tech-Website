const express = require("express");
const router = express.Router();
const db = require('../database');

router.get("/", async (req, res) => {
    var queryResult = "";
    var input = "";
    var checked = new Array(1, 1, 1);  

    //get tech under tl1 category
    const subs = await db.promise().query(`select * from submission`);
    const tl0true = await db.promise().query(`select * from domains where R = 1 or TP = 1 or MT = 1 or AR = 1`);
    const tl1true = await db.promise().query(`select * from domains where RoThink = true or EoST = true or EF = true`);
    const tl2true = await db.promise().query(`select * from domains where U = true or MDL = true or RA = true or RoTech= true or LS = true`);
    len = tl0true[0].length + tl2true[0].length
    var content = [];
    // console.log(subs);

    //list contains list of entrys with domains that are part of tl1
    const list = tl1true[0];
    var ids = [];
    for(let i = 0; i<list.length; i++){
        ids.push(list[i]["id"]);
    }
    var tools = [];
    for(let i = 0; i<subs[0].length; i++){
        
        if(ids.includes(subs[0][i]["id"]) && subs[0][i]["accepted"]){
            let temp = subs[0][i];
            tools.push(temp);
        }
    }
    //get set of domains for each tool in the tools array
    var tags = [];
    for(let i = 0; i<tools.length; i++){
        var id = tools[i]["id"];
        var subdict = {};
        for(let j = 0; j<list.length; j++){
            if(list[j]["id"]==id){
                subdict["RoThink"] = list[j]["RoThink"];
                subdict["EoST"] = list[j]["EoST"];
                subdict["EF"] = list[j]["EF"];
            }
        }
        tags.push(subdict);
        console.log(subdict);
    }
    content.push(tools);
    content.push(tags);
    console.log(content);
    console.log(content[0].length);

    res.render('tl3', {content: content, checked, input, queryResult, len});
})  

router.post('/', async (req,res) =>{
    var queryResult="";
    var input = "";
    var checked = new Array(req.body.s1, req.body.s2, req.body.s3); 
    for(let i=0; i<checked.length; i++){
        if(checked[i]!=1){
            checked[i] = 0;
        }
        console.log(checked[i]);
    } 

    const subs = await db.promise().query(`select * from submission`);
    const tl1true = await db.promise().query(`select * from domains where RoThink = true or EoST = true or EF = true`);
    var content = [];

    const list = tl1true[0];
    var ids = [];
    for(let i = 0; i<list.length; i++){
        ids.push(list[i]["id"]);
    }
    var tools = [];
    for(let i = 0; i<subs[0].length; i++){  
        if(ids.includes(subs[0][i]["id"]) && subs[0][i]["accepted"]){
            tools.push(subs[0][i]);
        }
    }

    var tags = [];
    for(let i = 0; i<tools.length; i++){
        var id = tools[i]["id"];
        var subdict = {};
        for(let j = 0; j<list.length; j++){
            if(list[j]["id"]==id){
                subdict["RoThink"] = list[j]["RoThink"];
                subdict["EoST"] = list[j]["EoST"];
                subdict["EF"] = list[j]["EF"];
            }
        }
        tags.push(subdict);
    }
    content.push(tools);
    content.push(tags);
    res.render('tl3', {content: content, checked, input, queryResult});
});

router.get("/:query", async function (req, res) {
    console.log("posted to search")
    var queryResult = req.query.query
    let query = queryResult.toLowerCase();
    var checked = [true, true, true, true]
    //copy and pasted code from router.get("/")
    const subs = await db.promise().query(`select * from submission`);
    const tl1true = await db.promise().query(`select * from domains where RoThink = true or EoST = true or EF = true`);
    var content = [];
    // console.log(subs);

    //list contains list of entrys with domains that are part of tl1
    const list = tl1true[0];
    var ids = [];
    for(let i = 0; i<list.length; i++){
        ids.push(list[i]["id"]);
    }

    
    var tools = [];
    for(let i = 0; i<subs[0].length; i++){
        //make change here: only push in technames related to the query
        if(ids.includes(subs[0][i]["id"]) && subs[0][i]["accepted"] && subs[0][i]["techname"].toLowerCase().indexOf(query)!=-1){
            let temp = subs[0][i]
            tools.push(temp)
        }
    }
    //get set of domains for each tool in the tools array
    var tags = []
    for(let i = 0; i<tools.length; i++){
        var id = tools[i]["id"]
        var subdict = {}
        for(let j = 0; j<list.length; j++){
            if(list[j]["id"]==id){
                subdict["RoThink"] = list[j]["RoThink"];
                subdict["EoST"] = list[j]["EoST"];
                subdict["EF"] = list[j]["EF"];
            }
        }
        tags.push(subdict)
        console.log(subdict)
    }
    content.push(tools)
    content.push(tags);
    console.log(content)
    res.render('tl3', {content: content, checked, queryResult})
})

module.exports = router;
