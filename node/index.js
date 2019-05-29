require('dotenv').config()
var http = require('http');
var {serverRouter} = require('./router')

http.createServer(serverRouter).listen(process.env.PORT, function(){
 console.log(`server start at port ${process.env.PORT}`); 
});