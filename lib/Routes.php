<?php

namespace Library;

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class Routes {
    public static function process($config, $dbConnections) {
        $fileLocator = new FileLocator([__DIR__ . '/../app/config']);
        $requestContext = new RequestContext();
        $requestContext->fromRequest(Request::createFromGlobals());
    
        $router = new Router(
            new YamlFileLoader($fileLocator),
            'routes.yml',
            $config->get('production') ? ['cache_dir' => __DIR__.'/../app/cache'] : [], // save in cache
            $requestContext
        );
    
        // Find the current route
        $parameters = $router->match($requestContext->getPathInfo());
    
        // add params to an array
        $params = [];
        if (!empty($parameters))
            foreach ($parameters as $key => $value)
                if ($key != '_route' && $key != '_controller')
                    $params[$key] = $value;

        // call proper controller's method with params
        list($controllerClassName, $action) = explode('::', $parameters['_controller']);
        $controllerParams = [
            'controller' => $controllerClassName,
            'action' => $action,
            'params' => $params
        ];

        // Create controller with params and db connections
        Factory::createController($controllerParams, $dbConnections, $config);
    }
}