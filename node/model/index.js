var mysql = require('mysql');
require('dotenv').config()
exports.modelConnection = mysql.createConnection({
    host     : '192.168.32.2',
    user     : process.env.DB_USER,
    password : process.env.DB_PASS,
    database : process.env.DB_TABLE
  });