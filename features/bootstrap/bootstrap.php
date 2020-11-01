<?php

if (!isset($_SERVER['APP_ENV'])) {
    $_SERVER['APP_ENV'] = 'test';
    $_SERVER['APP_SECRET'] = 'foobar';
}
