#!/usr/bin/php
<?php

/**
 * Filtrar en herramientas para desarroladores la url master.m3u8
 * El master cambia cada 1 hora mas o menos actualizandose los parámetros de la URL
 */

require_once '../includes/config.php';

do {
    $err = null;
    $m3u8_url = readline("INPUT THE URL: ");

    if (empty(trim($m3u8_url))) {
        $err = "Input a URL\n";
    } else if (!filter_url($m3u8_url)) {
        $err = "Input invalid URL\n";
    }
} while ($err);

$url_segments = explode("master.m3u8", $m3u8_url);

$response = getFileContent($m3u8_url);

$m3u8_segments = get_m3u8_segments($response, '/index.*\.m3u8/'/* /x[0-9]+/ */);

$n = 0;

foreach ($m3u8_segments as $key => $m3u8_segment) {
    echo $key . '. ' . $m3u8_segment . "\n";
    $n++;
}

$idx = null;

do {
    $idx = get_int("SELECT VIDEO RESOLUTION: ");
} while (0 > $idx || $idx >= $n);

$URL = $url_segments[0] . $m3u8_segments[$idx] . $url_segments[1];

$response = getFileContent($URL);

$ts_segments = get_ts_segments($response, '/seg.*\.ts/');

// foreach ($ts_segments as $key => $ts_segment) {
//     echo $url_segments[0] . $ts_segment[0] . $url_segments[1] . "\n";
// }

$filename = uniqid();

$time = microtime(true);

create_media_file($filename, $ts_segments, $url_segments);

$time = microtime(true) - $time;
echo "### Total time: " . gmdate("H:i:s", $time) . "\n";
echo "### Finished at: " . date('j/n/Y H:i') . "\n";
