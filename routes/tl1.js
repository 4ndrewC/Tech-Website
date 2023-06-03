const express = require("express");
const router = express.Router();
const db = require('../database');

router.get("/", async (req, res) => {
    // const externalLinkUrl = 'https://www.baidu.com';
    // const links = await db.promise().query(`select link from submission`);
    // console.log(links[0][0].link)
    console.log("yes")


    
    var queryResult="";
    //input = search phrase
    var input = "";
    //checked = filters, initialized to true
    var checked = new Array(1, 1, 1, 1);  

    //get tech under tl1 category
    const subs = await db.promise().query(`select * from submission`);
    const tl1true = await db.promise().query(`select * from domains where R = 1 or TP = 1 or MT = 1 or AR = 1`);
    // console.log('length'+tl1true[0].length)
    var content = [];
    //tech tool information for those under tl1
    const list = tl1true[0];
    // console.log(list)
    var ids = [];
    for(let i = 0; i<list.length; i++){
        ids.push(list[i]["id"]);
    }
    // console.log(ids)
    var tools = [];
    for(let i = 0; i<subs[0].length; i++){
        if(ids.includes(subs[0][i]["id"]) && subs[0][i]["accepted"]){
            let temp = subs[0][i];
            tools.push(temp);
        }
    }

    //tech tool domain information for those under tl1
    var tags = [];
    for(let i = 0; i<tools.length; i++){
        var id = tools[i]["id"];
        var subdict = {};
        for(let j = 0; j<list.length; j++){
            if(list[j]["id"]==id){
                subdict["R"] = list[j]["R"];
                subdict["TP"] = list[j]["TP"];
                subdict["MT"] = list[j]["MT"];
                subdict["AR"] = list[j]["AR"];
            }
        }
        tags.push(subdict);
        // console.log(subdict);
    }
    content.push(tools);
    content.push(tags);
    // console.log(content);
    // console.log(content[0].length);
    // console.log('length'+tl1true[0].length)
    console.log(tools)
    res.render('tl1', {content: content, checked, input, queryResult});
})  

//filtering, same structure as router.get("/")
router.post('/', async (req,res) =>{

    

    var queryResult="";
    var input = "";
    var checked = new Array(req.body.s1, req.body.s2, req.body.s3, req.body.s4); 
    for(let i=0; i<checked.length; i++){
        if(checked[i]!=1){
            checked[i] = 0;
        }
    } 
    const links = await db.promise().query(`select link from submission`);

    const subs = await db.promise().query(`select * from submission`);
    const tl1true = await db.promise().query(`select * from domains where R = true or TP = true or MT = true or AR = true`);
    
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
                subdict["R"] = list[j]["R"];
                subdict["TP"] = list[j]["TP"];
                subdict["MT"] = list[j]["MT"];
                subdict["AR"] = list[j]["AR"];
            }
        }
        tags.push(subdict);
    }
    content.push(tools);
    content.push(tags);
    console.log(tools)
    res.render('tl1', {content: content, checked, input, queryResult, links});
});
let queryContent = []
//searching, same structure as router.get("/") with additions
// router.get("/:query", async function (req, res) {
//     var queryResult = req.query.query;
//     let query = queryResult.toLowerCase();
//     var checked = new Array(1, 1, 1, 1); 
//     // const links = await db.promise().query(`select link from submission`);

//     const subs = await db.promise().query(`select * from submission`);
//     const tl1true = await db.promise().query(`select * from domains where R = true or TP = true or MT = true or AR = true`);
//     var content = [];
//     var input = "";
//     const list = tl1true[0];
//     var ids = [];
//     for(let i = 0; i<list.length; i++){
//         ids.push(list[i]["id"]);
//     }

//     var tools = [];
//     for(let i = 0; i<subs[0].length; i++){
//         //change made here: only push in technames related to the query
//         if(ids.includes(subs[0][i]["id"]) && subs[0][i]["accepted"] && subs[0][i]["techname"].toLowerCase().indexOf(query)!=-1){
//             let temp = subs[0][i]
//             tools.push(temp)
//         }
//     }

//     var tags = []
//     for(let i = 0; i<tools.length; i++){
//         var id = tools[i]["id"]
//         var subdict = {}
//         for(let j = 0; j<list.length; j++){
//             if(list[j]["id"]==id){
//                 subdict["R"] = list[j]["R"]
//                 subdict["TP"] = list[j]["TP"]
//                 subdict["MT"] = list[j]["MT"]
//                 subdict["AR"] = list[j]["AR"]
//             }
//         }
//         tags.push(subdict)
//         console.log(subdict)
//     }
//     content.push(tools)
//     content.push(tags);
//     console.log(content)
//     queryContent = content;

//     // res.render('tl1', {content: content, checked, input, queryResult, links});
//     res.redirect('/searchpage')
// })

module.exports = router;   