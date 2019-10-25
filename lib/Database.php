<?php

namespace Library;
use \PDO;

class MyPDO extends PDO
{
    public function __construct($dsn, $username = null, $password = null, $options = []) {
        $default_options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];
        $options = array_replace($default_options, $options);
        parent::__construct($dsn, $username, $password, $options);
    }

    public function run($sql, $args = NULL) {
        if (!$args)
             return $this->query($sql);

        $stmt = $this->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }
}

class Database {
    private static function mysql($config) {
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['name']};charset=utf8mb4";
        return new MyPDO($dsn, $config['username'], $config['password']);
    }

    private static function pgsql($config) {
        $dsn = "pgsql:host={$config['host']};port={$config['port']};dbname={$config['name']}";
        return new MyPDO($dsn, $config['username'], $config['password']);
    }
    private static function mongodb($config) {
        $dsn = !empty($config['username']) ?
            sprintf('mongodb://%s:%s@%s:%s/%s', 
                $config['username'],
                $config['password'],
                $config['host'],
                $config['port'],
                $config['database']
            )
        :
            sprintf('mongodb://%s:%s/%s',
                $config['host'],
                $config['port'],
                $config['database']
            );

        return new \MongoDB\Client($dsn);
    }

    public static function createConnections($config) {
        $connections = [];
        $dbs = $config->get('databases');

        if (!empty($dbs))
            foreach ($dbs as $type => $params)
                if (method_exists(__CLASS__, $type))
                    $connections[$type] = self::$type($params);

        return $connections;
    }
}
