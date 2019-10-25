<?php

require_once __DIR__ . '/vendor/autoload.php';
use Library\{Config, Routes, Database};

try {
    // Load config file
    $config = new Config();

    // Create database connections
    $dbConnections = Database::createConnections($config);

    // Check for routes
    Routes::process($config, $dbConnections);

} catch (Exception $e) {
    if ($config->get('production'))
        error_log($e->getMessage());
    else
        echo $e->getMessage();
}
