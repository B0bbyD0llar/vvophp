<?php declare(strict_types=1);

use VVOphp\Config;
use VVOphp\VVOphp;

mb_internal_encoding('UTF-8');

require '../vendor/autoload.php';

// Config
$config = new Config();
$vvo = new VVOphp($config);

// Tracy
Tracy\Debugger::enable(Tracy\Debugger::DEVELOPMENT, __DIR__ );
Tracy\Debugger::$showLocation = Tracy\Dumper::LOCATION_CLASS | Tracy\Dumper::LOCATION_LINK;
Tracy\Debugger::$maxDepth = 8;
Tracy\Debugger::$maxLength = 800;
