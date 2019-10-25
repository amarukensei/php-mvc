<?php

namespace Controllers;

class HomeController extends Controller {
    private $model;

    function __construct() {
        $this->model = \Library\Factory::createModel('\Models\HomeModel');
    }

    function index($params) {
        // check whether we got a message via GET, otherwise get message from DB
        $message = isset($params['message']) && !empty($params['message']) ? 
            $params['message'] 
        : 
            $this->model->getMessage();

        $message = $this->model->transformText($message);

        $this->view->load('HomeView', ['message' => $message]);
    }
}