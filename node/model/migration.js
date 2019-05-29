var mysql = require('mysql');
var migration = require('mysql-migrations');
var connection = mysql.createPool({
  connectionLimit : 10,
  host     : '192.168.32.2',
  user     : 'root',
  password : 'rootpassword',
  database : 'product'
  
});

migration.init(connection, __dirname + '/migrations');

/*
node migration.js add migration create_table_product
*/ 
