<?php

function get_ts_segments($response, $pattern = '/hls.*ts/')
{
    preg_match_all(
        $pattern,
        $response,
        $video_segments,
        PREG_SET_ORDER
    );
    return $video_segments;
}

// https://www.php.net/manual/es/book.pcre.php
// https://www.php.net/manual/es/reference.pcre.pattern.syntax.php
function get_m3u8_url($html, $pattern = '/https.*m3u8.*\'/i')
{
    preg_match_all(
        $pattern,
        $html,
        $matches, // will contain the article data
        PREG_SET_ORDER // formats data into an array of posts
    );
    return rtrim($matches[0][0], "\'");
}

function get_m3u8_segments($response, $pattern = '/hls.*m3u8/')
{
    // https://stackoverflow.com/questions/41870442/get-and-return-media-url-m3u8-using-php
    preg_match_all(
        $pattern,
        $response,
        $matches,
        PREG_SET_ORDER
    );
    $m3u8_segments = [];
    foreach ($matches as $match) {
        $m3u8_segments[] = $match[0];
    }
    return $m3u8_segments;
    // return $matches;
}

function get_available_resolutions($options)
{
    // Convert array to string
    $options = implode("|", $options);

    preg_match_all('/[0-9]+p/', $options, $matches, PREG_SET_ORDER);

    $ret = [];

    foreach ($matches as $match) {
        $ret[] = $match[0];
    }

    return $ret;
}
