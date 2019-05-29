package handlers

import (
	"fmt"
	"log"
	"net/http"
	"os"

	"github.com/ziutek/mymysql/mysql"
	_ "github.com/ziutek/mymysql/native"
)

type Product struct {
	Name  string
	Price int
	Sku   string
	Image string
}

func ping(w http.ResponseWriter, r *http.Request) {
	w.Write([]byte([]byte("{ping: pong}")))
}

func create(w http.ResponseWriter, r *http.Request) {
	prod := &Product{
		Name:  "Product",
		Price: 3,
		Sku:   "AA",
		Image: "Image",
	}
	query := fmt.Sprintf(
		`INSERT INTO products SET name="%s", price=%d, sku="%s", image="%s"`,
		prod.Name,
		prod.Price,
		prod.Sku,
		prod.Image)

	fmt.Println(query)
	db := mysql.New(
		"tcp",
		"",
		os.Getenv("DB_HOST")+":"+os.Getenv("DB_PORT"),
		os.Getenv("DB_USER"),
		os.Getenv("DB_PASS"),
		os.Getenv("DB_NAME"),
	)
	db.Connect()
	_, _, err := db.Query(query)
	if err != nil {
		w.Write([]byte([]byte("{message: error inserting product}")))
		return
	}
	w.Write([]byte([]byte("{message: product successfully inserted}")))
}

func all(w http.ResponseWriter, r *http.Request) {

	w.Write([]byte([]byte("{ping: pong}")))
}

// http://local.wsj.com:3001/api/v1/product/delete?id=1
func delete(w http.ResponseWriter, r *http.Request) {
	id, ok := r.URL.Query()["id"]
	if !ok {
		log.Print("id is not type")
	}
	db := mysql.New(
		"tcp",
		"",
		os.Getenv("DB_HOST")+":"+os.Getenv("DB_PORT"),
		os.Getenv("DB_USER"),
		os.Getenv("DB_PASS"),
		os.Getenv("DB_NAME"),
	)
	db.Connect()
	_, _, err := db.Query("DELETE FROM products WHERE id=" + id[0])
	if err != nil {
		fmt.Println(err)
		w.Write([]byte([]byte("{message: error deleting product}")))
		return
	}
	w.Write([]byte([]byte("{message: product  " + id[0] + "successfully deleted}")))
}

// Init creates http server
func Init() {
	http.HandleFunc("/api/v1/health-check", ping)

	http.HandleFunc("/api/v1/product", all)
	http.HandleFunc("/api/v1/product/create", create)
	http.HandleFunc("/api/v1/product/delete", delete)

	// start http server
	if err := http.ListenAndServe(os.Getenv("PORT"), nil); err != nil {
		panic(err)
	}
}
