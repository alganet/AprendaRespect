<?php

date_default_timezone_set('UTC');
chdir(__DIR__);
if (false === file_exists($vendor='vendor/autoload.php')) {
    error_log('Please, use Composer to install dependencies.');
    exit(2);
}

error_log(-1);
ini_set('display_errors',1);
require $vendor;
unset($vendor);
