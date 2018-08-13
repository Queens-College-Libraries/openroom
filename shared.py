from flask import Flask
from flask_sqlalchemy import SQLAlchemy
from secret import SQLALCHEMY_DATABASE_URI

app = Flask(__name__, static_url_path='')
app.config["SQLALCHEMY_DATABASE_URI"] = SQLALCHEMY_DATABASE_URI
app.config["SQLALCHEMY_TRACK_MODIFICATIONS"] = False
db = SQLAlchemy(app)
