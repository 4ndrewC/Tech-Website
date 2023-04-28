const express = require("express");
const router = express.Router();
const db = require('../database');
const XLSX = require('xlsx');

router.get("/", async (req,res)=>{
    const workbook = XLSX.readFile('./tools2.xlsx');
    const worksheet = workbook.Sheets[workbook.SheetNames[0]];
    // Convert the worksheet data to JSON
    const data = XLSX.utils.sheet_to_json(worksheet, { header: 1 });

    // Get the header row (first row)
    const header = data[0];

    // Remove the header row from the data array
    data.shift();

    // Create an object to store the resulting data
    const result = {};

    // Loop through each row of data and create an object with keys based on the header row
    for (let i = 0; i < data.length-2; i++) {
        const row = data[i];
        const obj = {};
        for (let j = 0; j < header.length; j++) {
            obj[header[j]] = row[j];
        }
        var tl1 = obj['tl1_description']
        var tl2 = obj['tl2_description']
        var tl3 = obj['tl3_description']
        var tl4 = obj['tl4_description']
        var tl1final = ""
        var tl2final = ""
        var tl3final = ""
        var tl4final = ""
        var count = [];
        count.push(0)
        if(tl1!=null){
            for(let j = 0; j<tl1.length; j++){
                if(tl1.substring(j,j+1)==="\""){
                    count.push(j)
                }
            }
            for(let j = 0; j<count.length-1; j++){
                tl1final += tl1.substring(count[j], count[j+1]) +"\\"
            }
            tl1final += tl1.substring(count[count.length-1]);
        }
        
        
        count = []
        count.push(0)
        if(tl2!=null){
            for(let j = 0; j<tl2.length; j++){
                if(tl2.substring(j,j+1)==="\""){
                    count.push(j)
                }
            }
            for(let j = 0; j<count.length-1; j++){
                tl2final += tl2.substring(count[j], count[j+1]) +"\\"
            }
            tl2final += tl2.substring(count[count.length-1]);
        }
        
        
        count= []
        count.push(0)
        if(tl3!=null){
            for(let j = 0; j<tl3.length; j++){
                if(tl3.substring(j,j+1)==="\""){
                    count.push(j)
                }
            }
            for(let j = 0; j<count.length-1; j++){
                tl3final += tl3.substring(count[j], count[j+1]) +"\\"
            }
            tl3final += tl3.substring(count[count.length-1]);
        }
        
        
        count = []
        count.push(0)
        if(tl4!=null){
            for(let j = 0; j<tl4.length; j++){
                if(tl4.substring(j,j+1)==="\""){
                    count.push(j)
                }
            }
            for(let j = 0; j<count.length-1; j++){
                tl4final += tl4.substring(count[j], count[j+1]) +"\\"
            }
            tl4final += tl4.substring(count[count.length-1]);
        }
        
        // console.log(description.substring(0,1)+"\""+description.substring(1))
        await db.promise().query(`insert into submission values(${i+1}, "${obj['techname']}", "${tl1final}", "${tl2final}", "${tl3final}", "${tl4final}", "${obj['link']}", "${obj['displaytext']}", "${obj['accepted']}", "default", "default")`)
        await db.promise().query(`insert into domains values(${i+1}, ${obj['R']}, ${obj['TP']}, ${obj['MT']}, ${obj['AR']}, ${obj['U']}, ${obj['MDL']}, ${obj['RA']}, ${obj['RoTech']}, ${obj['LS']}, ${obj['RoThink']}, ${obj['EoST']}, ${obj['EF']}, ${obj['RTE']}, ${obj['DLoI']}, ${obj['RaAoC']})`)
    
        result[i+1] = obj;
    }
    

    res.send('real data entered')
})

module.exports = router