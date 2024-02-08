#!/usr/bin/php
<?php

require_once '../includes/config.php';

do {
    $err = null;
    $url = readline("INPUT THE URL: ");

    if (empty(trim($url))) {
        $err = "Input a URL\n";
    } else if (!filter_url($url)) {
        $err = "Input invalid URL\n";
    }
} while ($err);

$html = getFileContent($url);

$m3u8_url = get_m3u8_url($html, '/https.*m3u8/i');

$url_segments = explode("_TPL_.h264.mp4.m3u8", $m3u8_url);

$response = getFileContent($m3u8_url);

$m3u8_segments = get_m3u8_segments($response, '/[0-9]*p.*m3u8/');

$resolutions = get_available_resolutions($m3u8_segments);

$n = 0;

foreach ($resolutions as $key => $resolution) {
    echo $key . ". " . $resolution . "\n";
    $n++;
}

do {
    $idx = get_int("CHOOSE A RESOLUTION: ");
} while (0 > $idx || $idx >= $n);

$URL = $url_segments[0] . $m3u8_segments[$idx] . $url_segments[1];

$r = getFileContent($URL);

$ts_segments = get_ts_segments($r, '/[0-9]*p.*ts/');

$filename = uniqid();

$time = microtime(true);

create_media_file($filename, $ts_segments, $url_segments);

$time = microtime(true) - $time;
echo "### Total time: " . gmdate("H:i:s", $time) . "\n";
// echo "### Total time: " . round($time, 3) . " seconds\n";
echo "### Finished at: " . date('j/n/Y H:i') . "\n";
