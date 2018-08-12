from flask import render_template, send_from_directory
from flask.views import View

from shared import app


@app.route("/faq")
def faq() -> View:
    return render_template("faq.html")


@app.route('/vendor/<path:path>')
def send_js(path):
    return send_from_directory('templates/vendor', path)


if __name__ == "__main__":
    app.run()
