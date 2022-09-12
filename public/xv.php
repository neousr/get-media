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

// Request to fetching a web page
$html = getFileContent($url);

/**
 * Ambiguous URL
 */
// if (str_contains($html, "Sorry, this URL is outdated")) {
if (strpos($html, "Sorry, this URL is outdated") !== false) {

    $url = update_url($url, $html);

    echo "URL has been updated: " . $url . "\n";

    $html = getFileContent($url);
}

$m3u8_url = get_m3u8_url($html);

$url_segments = explode("hls.m3u8", $m3u8_url);

$response = getFileContent($m3u8_url);

$m3u8_segments = get_m3u8_segments($response);

$resolutions = get_available_resolutions($m3u8_segments);

$n = 0;

foreach ($resolutions as $key => $resolution) {
    echo $key . ". " . $resolution . "\n";
    $n++;
}

do {
    $idx = get_int("SELECT VIDEO RESOLUTION: ");
} while (0 > $idx || $idx >= $n);

$URL = $url_segments[0] . $m3u8_segments[$idx] . $url_segments[1];

$r = getFileContent($URL);

$ts_segments = get_ts_segments($r);

$filename = uniqid();

$time = microtime(true);

create_media_file($filename, $ts_segments, $url_segments);

$time = microtime(true) - $time;
echo "### Total time: " . gmdate("H:i:s", $time) . "\n";
echo "### Finished at: " . date('j/n/Y H:i') . "\n";
