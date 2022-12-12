const express = require("express");
const router = express.Router();
const db = require('../database');

router.get("/", async (req, res) => {
    //get tech under tl1 category
    //send in render
    const content = await db.promise().query(`select * from submissions`);
    var results = content[0];
    console.log(results);
    res.render('tl4', {content: results});
})

module.exports = router;