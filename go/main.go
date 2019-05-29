package main

import (
	controller "github.com/edenriquez/go/controller"
	server "github.com/edenriquez/go/handlers"
	model "github.com/edenriquez/go/models"
)

func main() {
	controller.LoadEnvVars()
	model.SetUpDB()
	server.Init()
}
