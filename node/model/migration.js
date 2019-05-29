var mysql = require('mysql');
var migration = require('mysql-migrations');
var connection = mysql.createPool({
  connectionLimit : 10,
  host     : 'localhost',// set to localhost to run migrations
  user     : 'root',
  password : 'rootpassword',
  database : 'product',
  port     : "3307"
});

migration.init(connection, __dirname + '/migrations');

/*
node migration.js add migration create_table_product
*/ 
