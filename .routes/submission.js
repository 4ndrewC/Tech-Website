const express = require("express");
const { boolean } = require("yargs");
const router = express.Router();
const db = require('../database');

router.get("/", async (req, res) => {
    res.render('submissionpage');
})

router.post("/", async (req, res) => {
    // const content = req.body;
    // const results = await db.promise().query(`select * from submission`);
    // const submissions = results[0];
    // var currentID = results[0][-1].id;
    // db.promise().query(`insert into submission values(currentID+1, '${content.techname}', '${content.description}', '${content.categories}', accepted, '${content.username}', '${content.contact}')`);
    
})

module.exports = router
