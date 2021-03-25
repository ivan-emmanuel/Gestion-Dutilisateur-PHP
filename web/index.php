<?php

define("APP_BASE_DIR", dirname(__DIR__));

$loader = require APP_BASE_DIR . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

require APP_BASE_DIR . DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR . "router.php";

if (session_status() === PHP_SESSION_ACTIVE) session_start();

router_instance()->run();
