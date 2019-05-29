package controller

import (
	"path"
	"path/filepath"

	"github.com/joho/godotenv"
)

// LoadEnvVars find and load environment variables
func LoadEnvVars() {
	base, _ := filepath.Abs(".")
	envPath := path.Join(base, "demo.env")
	godotenv.Load(envPath)
}
