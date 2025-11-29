<?php

declare(strict_types=1);

// Bootstrap file for PHPUnit tests

// Load Composer autoloader
require_once dirname(__DIR__) . '/vendor/autoload.php';

// Manually require the TestCase base class since test files don't use namespaces
require_once __DIR__ . '/TestCase.php';

