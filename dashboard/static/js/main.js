document.addEventListener('DOMContentLoaded', loaded, false);

function loaded() {
    var classname = document.getElementsByClassName("turn-on");
    var classnameOff = document.getElementsByClassName("turn-off");

    function turnOnDocker() {
        var attribute = this.getAttribute("data-id");
        sendRequest(attribute, 'turn-on')
    };

    function turnOffDocker() {
        var attribute = this.getAttribute("data-id");
        sendRequest(attribute, 'turn-off')
    }

    for (var i = 0; i < classname.length; i++) {
        classname[i].addEventListener('click', turnOnDocker, false);
    }
    for (var i = 0; i < classnameOff.length; i++) {
        classnameOff[i].addEventListener('click', turnOffDocker, false);
    }

}

function sendRequest(id, endpoint) {
    const base = `http://localhost:5000/${endpoint}/`
    var url = base + id
    console.log(url)
    fetch(url)
        .then(function (response) {
            if (response.status != 200) {
                response.json().then(function (res) {
                    showError(res.response)
                })
            }
            return response.json()
        }).then(function (res) {
            showOk(res.response)
        })
}


function showError(err) {
    notyf.error(err)
}

function showOk(ok) {
    notyf.success(ok)
    window.setTimeout(reload, 2500)
}

function reload() {
    location.reload(true)
}