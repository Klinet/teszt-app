<?php

use App\Controllers\MainController;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/App/Helpers/helper.php';

$controller = new MainController();

$controller->index();