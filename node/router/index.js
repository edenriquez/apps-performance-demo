var {modelConnection} = require('../model')
modelConnection.connect();
exports.serverRouter = (req, res) => {
   var url = req.url;

   if(url ==='/api/v1/health-check'){
      res.writeHead(...setHeader(200)); 
      res.end(
         JSON.stringify(
            {
               ping: "pong", 
               counter: 1 
            }
         )
      );
   }else if(url ==='/api/v1/product/create'){
      
      params = {
         name  : "product",
         price : 3,
         sku   : "AA0001",
         image : "image.png"
      }
      modelConnection.query(insertQuery(params),(err, result) => {
         if (err) throw err;
         res.writeHead(...setHeader(401)); 
         res.end(JSON.stringify(
            {
               status: 401,
               statusMessage: "There was an error creating the product"
            }
         ));
         return;
       });
      res.writeHead(...setHeader(200)); 
      res.end(JSON.stringify(
         {
            status: 200,
            statusMessage: "Product successfuly created"
         }
      ));
   }else if(url.indexOf('delete') != -1){
      
      id = url.slice(23)
      if (isNaN(parseInt(id))){
         res.writeHead(...setHeader(401)); 
         res.end(JSON.stringify(
            {
               status: 401,
               statusMessage: "There was an error deleting the product"
            }
         ));
         return;
      }
      modelConnection.query(deleteQuery(id))
      res.writeHead(...setHeader(200)); 
      res.end(JSON.stringify(
         {
            status: 200,
            statusMessage: "Product successfuly deleted"
         }
      ));
   }else if(url ==='/api/v1/product'){
      res.writeHead(...setHeader(200)); 
      modelConnection.query(selectAllQuery(), (err, result, fields) => {
         if (err) throw err;
         res.end(JSON.stringify(result));
       })
   }
}

const insertQuery = (params) => {
   return `INSERT INTO products SET name="${params.name}", price="${params.price}", sku="${params.sku}", image="${params.image}" `
}

const selectAllQuery = () => {
   return `SELECT * FROM  products; `
}

const deleteQuery = (id) => {
   return `DELETE FROM products WHERE id=${id}; `
}

const setHeader = (code) => {
   if (code != 200) {
      return [code, {'Content-Type': 'application/json'}]
   }
   return [200, {'Content-Type': 'application/json'}]  
}