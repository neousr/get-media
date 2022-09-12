<?php

define('DEST_DIR', str_replace('\\', '/', dirname(__DIR__)) . '/media/');

if (!file_exists(DEST_DIR)) {
    if (mkdir(DEST_DIR)) {
        echo 'Target directory ' . DEST_DIR . ' has been created!' . "\n";
    } else {
        echo "The fopen function will attempt to create the target directory!\n";
    }
}
