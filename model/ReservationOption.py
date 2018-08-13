from shared import db


class ReservationOption(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    reservation_id = db.Column(db.Integer, db.ForeignKey("reservation.id"), nullable=False)
    name = db.Column(db.String(255), unique=True)
    value = db.Column(db.String(255), unique=False)
