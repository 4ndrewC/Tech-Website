const mysql = require('mysql2')

module.exports = mysql.createConnection({
    host: 'localhost',
    user: 'basis',
    password: 'basis123',
    database: 'basistechtools',
})
