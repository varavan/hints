<?php

if (file_exists(__DIR__ . '/../../autoload.php')) {
    require __DIR__ . '/../../autoload.php';
} elseif (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require __DIR__ . '/vendor/autoload.php';
} else {
    throw new Exception("No vendors found");

}