<?php

namespace Library;

class Config {
    private $config;

    function __construct() {
        require_once __DIR__ . '/../app/config/config.php';
        $this->config = $config;
    }

    public function get($key) {
        return $this->config[$key] ?: false;
    }
}