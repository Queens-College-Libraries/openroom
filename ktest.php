<?php
require_once 'vendor/autoload.php';
$conn_string = "host=elmer-02.db.elephantsql.com port=5432 dbname=fxeqznuv user=fxeqznuv password=qwb8CwvSpuvbb-JwRa4EXskQaaaPN8Uz";
$dbconn = \pg_connect($conn_string);
//simple check
$conn = \pg_connect($conn_string);
$result = \pg_query($conn, "SELECT data->'name' AS name, data->'keybase' AS keybase, data->'email' AS email FROM People");
\var_dump(\pg_fetch_all($result));