FROM golang:1.10

# Set the WORKDIR to the project path in your GOPATH, e.g. /go/src/github.com/go-martini/martini/
WORKDIR $GOPATH/src/github.com/edenriquez/go

# Copy the content of your repository into the image
COPY . ./
RUN go get github.com/ziutek/mymysql 
RUN go get github.com/ziutek/mymysql/native
RUN go get github.com/joho/godotenv