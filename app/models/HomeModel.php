<?php

namespace Models;

class HomeModel extends Model {

    public function transformText($text) {
        // just do something as an example
        return strtoupper($text);
    }

    public function getMessage() {
        // first try mysql database
        if (isset($this->dbConnections['mysql'])) {
            $data = $this->dbConnections['mysql']->run('SELECT message FROM messages')->fetch();
            return $data['message'];
        }

        // if no mongodb setup, fallback to a simple message
        if (!isset($this->dbConnections['mongodb']))
            return 'Hellow World!!';

        $cursor = $this->dbConnections['mongodb']->test->myCollection->find();
        $output = [];
        
        foreach ($cursor as $document)
            $output[] = $document['message'];
        
        return implode(' ', $output);
    }
}