<?php

foreach ($_POST as $key => $value) {
    if (!is_array($value)) {
        $_POST[$key] = $value;
    } else {
        foreach ($value as $key2 => $value2) {
            $_POST[$key][$key2] = $value2;
        }
    }
}

foreach ($_GET as $key => $value) {
    if (!is_array($value)) {
        $_GET[$key] = $value;
    } else {
        foreach ($value as $key2 => $value2) {
            $_GET[$key][$key2] = $value2;
        }
    }
}
