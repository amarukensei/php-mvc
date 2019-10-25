<?php

$config = [
    'production' => false,
    'databases' => [ // for now valid keys are: mysql, pgsql, mongodb
        'mysql' => [
            'host' => 'localhost',
            'port' => 3306,
            'name' => '',
            'username' => '',
            'password' => ''
        ],
        'mongodb' => [
            'host' => 'localhost',
            'port' => 27017,
            'database' => '',
            'username' => '',
            'password' => ''
        ]
    ]
];
