const express = require("express");
const router = express.Router();
const db = require('../database');
const XLSX = require('xlsx');

router.get("/", async (req,res)=>{
    
    db.query('TRUNCATE submission');
    db.query('TRUNCATE domains');
    res.send('database truncated')
})

module.exports = router