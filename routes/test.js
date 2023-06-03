// const express = require("express");
// const router = express.Router();
// const db = require('../database');

// router.get("/", async (req, res) => {
//     const alphabet = 'abcdefghijklmnopqrstuvwxyz';
//     for(let i = 0; i<100; i++){
//         //random domains
//         let R = Math.round(Math.random())
//         var TP = Math.round(Math.random())
//         var MT = Math.round(Math.random())
//         var AR = Math.round(Math.random())
//         var U  = Math.round(Math.random())
//         var MDL= Math.round(Math.random()) 
//         var RA = Math.round(Math.random())
//         var RoTech = Math.round(Math.random())
//         var LS = Math.round(Math.random())
//         var RoThink= Math.round(Math.random()) 
//         var EoST = Math.round(Math.random())
//         var EF = Math.round(Math.random())
//         var RTE = Math.round(Math.random())
//         var DLoI = Math.round(Math.random())
//         var RaAoC = Math.round(Math.random())

//         const current = await db.promise().query(`select * from submission`);
//         var last = 0;
//         console.log(current[0])
//         if(current[0]!=0)last = current[0][current[0].length-1]["id"];
//         last+=1;

//         //random techs
        
//         var techname = "";
//         for(let j = 0; j<10; j++){
//             const randomIndex = Math.floor(Math.random() * alphabet.length);
//             techname+=alphabet[randomIndex] 
//         }
//         db.query(`insert into submission values(${last}, "${techname}", "", "", "", 0, "", "")`);
//         db.query(`insert into domains values(${last}, ${R}, ${TP}, ${MT}, ${AR}, ${U}, ${MDL}, ${RA}, ${RoTech}, ${LS}, ${RoThink}, ${EoST}, ${EF}, ${RTE}, ${DLoI}, ${RaAoC})`)
//     }

//     console.log("100 new testing data entered")
//     res.send("100 new testing data entered")
// })

// module.exports = router


//<button type="button" name="id" id="7" onclick="show('popup');reply_click('7', 'OXFORD LEARNER&#39;S DICTIONARY', '', '', '', 'The Oxford Learner\&#39;s Dictionary of Academic English (OLDAE) focuses on words and phrases used in academic writing, and helps you to use them in your own academic written work. ', 'https://www.oxfordlearnersdictionaries.com/', 'Link', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0')">Edit</button>
