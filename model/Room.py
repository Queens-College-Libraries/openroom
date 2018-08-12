from shared import db


class Room(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    position = db.Column(db.Integer, nullable=False)
    capacity = db.Column(db.Integer, nullable=False)
    group_id = db.Column(db.Integer, db.ForeignKey("room_group.id"), nullable=False)
    name = db.Column(db.String(255), nullable=False)
    description = db.Column(db.Text, nullable=False)
    is_active = db.Column(db.Boolean, nullable=False, default=True)
    reservations = db.relationship("Reservation", backref="reservation", lazy=True)
    room_hours = db.relationship("RoomHour", backref="room_hour", lazy=True)
