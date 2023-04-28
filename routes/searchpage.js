const express = require("express");
const router = express.Router();
const db = require('../database');
const Fuse = require('fuse.js');
const { tags } = require("fuse/lib/mustache");

let q = ""
router.get("/:query", async function(req, res) {
    var queryResult = req.query['query'];
    console.log(queryResult);
    if(queryResult!=null){
        q = queryResult
    }
    let query = q.toLowerCase();
    // var checked = new Array(1, 1, 1, 1); 
    // const links = await db.promise().query(`select link from submission`);

    const subs = await db.promise().query(`select * from submission where accepted = 1`);
    const domains = await db.promise().query(`select * from domains`);
    var content = subs[0]
    var contenttags = domains[0]

    // Create a new instance of Fuse with the data and search options
    const fuse = new Fuse(content, {
        includeScore: true,
        keys: ['techname', 'tl1_desc', 'tl2_desc', 'tl3_desc', 'tl4_desc', 'link'],
        threshold: 0.4,
    });
    
    // Search for the query string in the data using Fuse
    const tools = fuse.search(q);
    // console.log(tools)

    result = []

    let tags = []
    for(let i = 0; i<tools.length; i++){
        let id = tools[i]['item']['id']
        for(let j = 0; j<contenttags.length; j++){
            if(contenttags[j]['id']==id){
                tags.push(contenttags[j]);
            }
        }
    }

    let tags2 = []
    for(let i = 0; i<tags.length; i++){
        tags2.push(tags[i])
    }

    result.push(tools)
    result.push(tags)
    // console.log(result[0])
    let tool = result[0]
    console.log(tool)
    console.log("tags: " + tags2)
    // console.log(tags)
    // Send the search result as a response
    res.render('searchpage', {'tools': result[0], 'tags': tags, query});
    
})

module.exports = router