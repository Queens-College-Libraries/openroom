from shared import db


class RoomGroup(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(255), nullable=False, unique=True)
    description = db.Column(db.Text, nullable=False)
    rooms = db.relationship("Room", backref="room", lazy=True)
