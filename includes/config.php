<?php

// Otra alternativa es utilizar la constante PHP_SAPI
if (php_sapi_name() !== 'cli') {
    echo '<p>PHP code to execute directly on the command line.</p>';
    exit;
}

// Modificado en el INI => date.timezone=America/Argentina/Buenos_Aires
// date_default_timezone_set("AMERICA/ARGENTINA/BUENOS_AIRES");

require_once 'constants.php';
require_once 'functions.php';
require_once 'm3u8.php';
