<?php

namespace Library;

class Factory {
    private static $dbConnections;
    private static $config;

    public static function createController($parameters, $dbConnections, $config) {
        self::$config = $config;
        self::$dbConnections = $dbConnections;
        extract($parameters);

        // create an instance of child controller
        $c = new $controller();

        // even if not neede, assign a view instance
        $c->view = new View();

        // call action
        $c->{$action}($params);
    }

    public static function createModel($model) {
        $m = new $model();
        
        // assign db connection instances
        $m->dbConnections = self::$dbConnections;
        
        return $m;
    }
}