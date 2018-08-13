from shared import db


class OptionalField(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(255), unique=True)
    choices = db.Column(db.JSON)
