const mysql = require('mysql2')

module.exports = mysql.createConnection({
    host: '175.178.17.67',
    port: 3306,
    user: '175_178_17_67',
    password: 'Basis2023',
    database: '175_178_17_67',
})
