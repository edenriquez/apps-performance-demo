
import bisect
from flask import Flask, render_template, url_for, jsonify, make_response
import os
import docker
app = Flask(__name__, template_folder='./templates')
client = docker.from_env()


@app.route('/')
def index():
    containers = client.containers.list()
    inactive = get_inactive_containers(containers)
    return render_template('index.html', containers=containers, inactive_containers=inactive)

@app.route('/turn-on/<string:id>')
def turn_on(id):
    container = client.containers.get(id)
    try:
        container.start()
    except Exception as ex:
        return make_response(jsonify(response=str(ex)), 401)
    return  make_response(jsonify(response='ok'), 200)

@app.route('/turn-off/<string:id>')
def turn_off(id):
    container = client.containers.get(id)
    try:
        container.stop()
    except Exception as ex:
        return make_response(jsonify(response=str(ex)), 401)
    return  make_response(jsonify(response='ok'), 200)


def get_inactive_containers(active):
    inactive_containers = []
    all_containers = client.containers.list(all)
    for a in all_containers:
        if a not in active:
            inactive_containers.append(a)
    return inactive_containers


@app.context_processor
def override_url_for():
    return dict(url_for=dated_url_for)


def dated_url_for(endpoint, **values):
    if endpoint == 'static':
        filename = values.get('filename', None)
        if filename:
            file_path = os.path.join(app.root_path,
                                     endpoint, filename)
            values['q'] = int(os.stat(file_path).st_mtime)
    return url_for(endpoint, **values)

def before_request():
    app.jinja_env.cache = {}

if __name__ == '__main__':
    app.run()
    app.before_request(before_request)

