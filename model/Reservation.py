from shared import db


class Reservation(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    room_id = db.Column(db.Integer, db.ForeignKey("room.id"), nullable=False)
    start_time = db.Column(db.DateTime, nullable=False)
    end_time = db.Column(db.DateTime, nullable=False)
    is_cancelled = db.Column(db.Boolean, nullable=False, default=False)
    user = db.Column(db.Integer, db.ForeignKey('person.id'), nullable=False)
    reservation_options = db.relationship("Reservation", backref="reservation_option", lazy=True)
