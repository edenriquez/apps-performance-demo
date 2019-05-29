module.exports = {
    "up": "CREATE TABLE products (id INT NOT NULL AUTO_INCREMENT, UNIQUE KEY id (id), name varchar(11), price double, sku varchar(255), image text)",
    "down": "DROP TABLE products"
}