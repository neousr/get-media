<?php

function create_media_file($filename, $ts_segments, $url_segments)
{
    $total_segments = count($ts_segments);

    $fp = fopen(DEST_DIR . $filename . '.ts', 'wb');

    foreach ($ts_segments as $key => $ts_segment) {

        $url = $url_segments[0] . $ts_segment[0] . $url_segments[1];

        $response = getFileContent($url);

        fwrite($fp, $response);

        showProgressBar($key + 1, $total_segments);
    }

    fclose($fp);
}

function filter_url($url)
{
    $url = filter_var($url, FILTER_SANITIZE_URL);
    return filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED);
}

function clean_input($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

function getFileContent($url)
{
    $options = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_VERBOSE => 0
    ];
    $curl = curl_init($url);
    curl_setopt_array($curl, $options);
    // $response = mb_ereg_replace('/[[:^print:]]/', '', curl_exec($curl));
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function showProgressBar($done, $total, $decimals = 2, $bar_size = 100)
{
    if (PHP_SAPI !== 'cli') return;

    $percentage = ($done / $total) * 100;
    $percentageStringLength = 4;

    if ($decimals > 0) {
        $percentageStringLength += $decimals + 1;
    }
    // $ret = sprintf('%.2f', $float);
    $percentageString = number_format($percentage, $decimals) . '%';
    $percentageString = str_pad($percentageString, $percentageStringLength, " ", STR_PAD_LEFT);

    $status_bar = "\rProgress: [$percentageString] [";
    $bar = floor(($percentage * $bar_size) / 100);
    $status_bar .= str_repeat("#", $bar);

    if ($bar <= $bar_size) {
        $status_bar .= str_repeat(".", $bar_size - $bar);
    } else {
        $status_bar .= "#";
    }

    echo "$status_bar] $done/$total";

    flush();

    if ($done == $total) {
        echo "\n";
    }
}
function get_int($message)
{
    while (true) {
        $s = readline($message);
        if ($s === false) {
            return false;
        }
        if (preg_match("/^(\+|-)?\d+$/", $s)) {
            $n = intval($s);
            if (bccomp((string) $n, $s) === 0 && $n < PHP_INT_MAX) {
                return $n;
            }
        }
    }
}
function get_float($message)
{
    while (true) {
        $s = readline($message);
        if ($s === false) {
            return false;
        }
        if (preg_match("/^(\+|-)?\d*(\.\d*)?$/", $s)) {
            $f = floatval($s);
            if ($f !== -INF && $f !== INF) {
                return $f;
            }
        }
    }
}
function get_char($message)
{
    while (true) {
        $s = readline($message);
        if ($s === false) {
            return false;
        }
        if (strlen($s) === 1) {
            return $s[0];
        }
    }
}
