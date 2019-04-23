<?php

require __DIR__."/Vendor/System/Application.php";
require __DIR__."/Vendor/System/File.php";
use System\File;
use System\Application;

$file = new File(__DIR__);

$app = new Application($file);

$app->run();


