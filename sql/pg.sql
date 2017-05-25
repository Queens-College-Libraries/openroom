DROP TABLE IF EXISTS Users CASCADE;

CREATE TABLE Users (
  id               SERIAL PRIMARY KEY,
  username         TEXT                        NOT NULL UNIQUE,
  display_name     TEXT,
  password         TEXT                        NOT NULL,
  email            TEXT                        NOT NULL,
  last_login       TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT (now()),
  is_active        BOOLEAN                     NOT NULL DEFAULT FALSE,
  is_administrator BOOLEAN                     NOT NULL DEFAULT FALSE,
  is_reporter      BOOLEAN                     NOT NULL DEFAULT FALSE,
  is_banned        BOOLEAN                     NOT NULL DEFAULT FALSE
);

INSERT INTO Users (username, password, email, is_active)
VALUES ('admin', '$2b$12$bVGt6HWAxldbT4f2krB02uPQJTv6vWlWZjVH33.JdbP6ToA4THt2W', 'kushaldeveloper@gmail.com', TRUE);

UPDATE users
SET is_administrator = TRUE
WHERE username = 'admin';

SELECT *
FROM Users;

DROP TABLE IF EXISTS Settings;

CREATE TABLE Settings (
  id    SERIAL PRIMARY KEY,
  name  TEXT UNIQUE,
  value TEXT
);

INSERT INTO Settings (name, value)
VALUES ('allow_past_reservations', 'false'), ('allow_simultaneous_reservations', 'false'),
  ('email_can_gef', 'a:1:{i:0;s:0:\"\";}'), ('email_can_terse', 'a:1:{i:0;s:0:\"\";}'),
  ('email_can_verbose', 'a:1:{i:0;s:0:\"\";}'), ('email_condition', ''), ('email_condition_value', ''),
  ('email_cond_gef', 'a:1:{i:0;s:0:\"\";}'), ('email_cond_terse', 'a:1:{i:0;s:0:\"\";}'),
  ('email_cond_verbose', 'a:1:{i:0;s:0:\"\";}'),
  ('email_filter', 'a:2:{i:0;s:11:\"qc.cuny.edu\";i:1;s:14:\"qmail.cuny.edu\";}'),
  ('email_res_gef', 'a:1:{i:0;s:0:\"\";}'), ('email_res_terse', 'a:1:{i:0;s:0:\"\";}'),
  ('email_res_verbose', 'a:1:{i:0;s:0:\"\";}'), ('email_system', 'qc_ask_circ@qc.cuny.edu'), ('endtime', '22'),
  ('https', 'false'), ('instance_name', 'Rosenthal Room Reservations'),
  ('instance_url', 'library-test.qc.cuny.edu/rooms/'), ('interval', '30'), ('ldap_baseDN', 'ldap://149.4.100.201:3268'),
  ('ldap_host', 'DC=qc,DC=ads'), ('limit_duration', '240'), ('limit_frequency', 'a:2:{i:0;s:1:\"0\";i:1;s:3:\"day\";}'),
  ('limit_openingday', ''), ('limit_total', 'a:2:{i:0;s:3:\"240\";i:1;s:3:\"day\";}'),
  ('limit_window', 'a:2:{i:0;i:0;i:1;s:10:\"12/31/2016\";}'), ('login_method', 'ldap'),
  ('policies', 'Rosenthal Library usually has several rooms available to students for group study on a ' ||
               'first-come, first-serve basis. These rooms are available to currently registered Queens College ' ||
               'students only.\r\n\r\nImmediate use of a Group Study Room is made by presenting your valid Queens ' ||
               'College ID at the Circulation Desk (located on Level 3 of the Library). If available, a room will ' ||
               'be assigned to you for one 2-hour time block. If the room is in use a hold may be placed to secure ' ||
               'the next available time slot. Room use, like book use, is assigned to your record in our automated ' ||
               'circulation system. When a room is assigned to you, you will be handed a wooden block upon which ' ||
               'the room number and policies governing Group Study Rooms is adhered. Upon completing your use of ' ||
               'the room, the wooden block is to be returned to the Circulation Desk and the assignment of the room ' ||
               'to your record will be released.\r\n\r\nShould you wish to extend the use of the room you are ' ||
               'required to return to the Circulation desk with your ID and the wooden block at the end of the 2 ' ||
               'hours. The room will then be reassigned to you provided there are no other users awaiting use of ' ||
               'the room.'),
  ('remindermessage', 'The Library will be CLOSED, Monday, January 16.'), ('starttime', '8'), ('systemid', '80zhh73n5'),
  ('theme', 'default'),
  ('time_format', 'g:i a');

SELECT *
FROM Settings;

DROP TABLE IF EXISTS Groups CASCADE;

CREATE TABLE Groups (
  id   SERIAL PRIMARY KEY,
  name TEXT NOT NULL
);

INSERT INTO Groups (name) VALUES ('apple');
INSERT INTO Groups (name) VALUES ('ball');
INSERT INTO Groups (name) VALUES ('cat');
INSERT INTO Groups (name) VALUES ('dog');
INSERT INTO Groups (name) VALUES ('egg');
INSERT INTO Groups (name) VALUES ('fish');
INSERT INTO Groups (name) VALUES ('gun');
INSERT INTO Groups (name) VALUES ('hen');
INSERT INTO Groups (name) VALUES ('ice');
INSERT INTO Groups (name) VALUES ('jug');
INSERT INTO Groups (name) VALUES ('kite');

SELECT *
FROM Groups;

DROP TABLE IF EXISTS Rooms CASCADE;

CREATE TABLE Rooms (
  id          SERIAL PRIMARY KEY,
  name        TEXT,
  position    INTEGER,
  capacity    INTEGER,
  groupid     INTEGER REFERENCES Groups (id),
  description TEXT
);

INSERT INTO rooms (name, position, capacity, groupid, description)
VALUES ('방 101', 1, 8, 9, '이것은 시험이다.');

SELECT *
FROM Rooms;

DROP TABLE IF EXISTS Reservations;

CREATE TABLE Reservations (
  id                   SERIAL PRIMARY KEY,
  start_time           TIMESTAMP NOT NULL,
  end_time             TIMESTAMP NOT NULL,
  room_id              INTEGER   NOT NULL REFERENCES Rooms (id),
  user_id              INTEGER   NOT NULL REFERENCES Users (id),
  number_in_group      INTEGER   NOT NULL DEFAULT 1,
  time_of_request      TIMESTAMP NOT NULL DEFAULT (now()),
  time_of_cancellation TIMESTAMP          DEFAULT NULL
);

INSERT INTO Reservations (start_time, end_time, room_id, user_id)
VALUES ('2017-03-26 11:30:00.000000', '2017-03-26 11:55:00.000000', 1, 1);

UPDATE Reservations
SET time_of_cancellation = now()
WHERE id = 1;

SELECT *
FROM Reservations;

DROP TABLE IF EXISTS HOURS;

CREATE TABLE Hours (
  id          SERIAL PRIMARY KEY,
  room_id     INTEGER   NOT NULL REFERENCES Rooms (id),
  day_of_week SMALLINT  NOT NULL,
  start_time  TIMESTAMP NOT NULL,
  end_time    TIMESTAMP NOT NULL
);

INSERT INTO Rooms (name, position, capacity, groupid, description)
VALUES ('445', 0, 8, 1, 'Room 445'), ('446', 1, 8, 1, 'Room 446'), ('503', 2, 8, 1, 'Room 503'),
  ('541', 3, 8, 1, 'Room 541'), ('1', 0, 8, 2, 'MediaScape Room 1'), ('2', 1, 8, 2, 'MediaScape Room 2'),
  ('3', 2, 8, 2, 'MediaScape Room 3');

SELECT *
FROM Rooms;

SELECT *
FROM Hours;

DROP TABLE IF EXISTS SpecialHours;

CREATE TABLE SpecialHours (
  id         SERIAL PRIMARY KEY,
  room_id    INTEGER   NOT NULL REFERENCES Rooms (id),
  from_range TIMESTAMP NOT NULL,
  to_range   TIMESTAMP NOT NULL,
  start_time TIMESTAMP NOT NULL,
  end_time   TIMESTAMP NOT NULL
);

INSERT INTO SpecialHours
VALUES (1, 1, '2016-10-10 04:00:00', '2016-10-10 04:00:00', '2017-03-26 11:30:00.000000', '2017-03-26 13:30:00.000000'),
  (2, 2, '2016-10-10 04:00:00', '2016-10-10 04:00:00', '2017-03-26 11:30:00.000000', '2017-03-26 13:30:00.000000'),
  (3, 3, '2016-10-10 04:00:00', '2016-10-10 04:00:00', '2017-03-26 11:30:00.000000', '2017-03-26 13:30:00.000000'),
  (4, 4, '2016-10-10 04:00:00', '2016-10-10 04:00:00', '2017-03-26 11:30:00.000000', '2017-03-26 13:30:00.000000'),
  (5, 5, '2016-10-10 04:00:00', '2016-10-10 04:00:00', '2017-03-26 11:30:00.000000', '2017-03-26 13:30:00.000000'),
  (6, 6, '2016-10-10 04:00:00', '2016-10-10 04:00:00', '2017-03-26 11:30:00.000000', '2017-03-26 13:30:00.000000'),
  (7, 7, '2016-10-10 04:00:00', '2016-10-10 04:00:00', '2017-03-26 11:30:00.000000', '2017-03-26 13:30:00.000000');

SELECT *
FROM SpecialHours;

DROP TABLE IF EXISTS OptionalFields;

CREATE TABLE OptionalFields (
  id          SERIAL PRIMARY KEY,
  name        TEXT    NOT NULL,
  form_name   TEXT    NOT NULL,
  type        TEXT    NOT NULL,
  choices     JSON    NOT NULL,
  position    INTEGER NOT NULL,
  question    TEXT    NOT NULL,
  is_private  BOOLEAN NOT NULL DEFAULT FALSE,
  is_required BOOLEAN NOT NULL DEFAULT FALSE
);

INSERT INTO optionalfields (name, form_name, type, choices, position, question, is_private, is_required) VALUES
  ('campus affiliation', 'campus affiliation form', 1, '{
    "0": "Undergraduate",
    "1": "Graduate",
    "2": "Faculty / Staff"
  }', 1,
   '\"What is your Campus Affiliation?\"', FALSE, TRUE
  );

INSERT INTO optionalfields (name, form_name, type, choices, position, question, is_private, is_required) VALUES
  ('random question name', 'random question form name', 1, '{
    "0": "蘇步青",
    "1": "復旦大學",
    "2": "上海浦",
    "3": "也係世界跟到新加坡同香港後面嗰世界第三大貨櫃港",
    "4": "Cómo estás hoy?"
  }', 1,
   '\"¿Cuál es su afiliación en el campus?\"', FALSE, TRUE
  );
