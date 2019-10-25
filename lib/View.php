<?php

namespace Library;

class View {
    public function load($view, $data = []) {
        require_once __DIR__ . '/../app/views/' . $view . '.php';
    }
}