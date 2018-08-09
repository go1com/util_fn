<?php

namespace go1\util_fn;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class App
{
    private $matcher;
    private $swagger;

    public static function create(array $swagger): App
    {
        $app = new App;
        $app->swagger = $swagger;

        return $app;
    }

    private function matcher()
    {
        if (!$this->matcher) {
            $this->matcher = new UrlMatcher($routes = new RouteCollection, new RequestContext('/'));
            foreach ($this->swagger['paths'] as $path => $methods) {
                foreach ($methods as $method => $info) {
                    $routes->add($path . '__' . $method, new Route($path, ['_swagger' => $info]));
                }
            }
        }

        return $this->matcher;
    }

    public function handle(Request $req)
    {
        if (!$route = $this->matcher()->matchRequest($req)) {
            throw new RouteNotFoundException;
        }

        return $this->resolver($route);
    }

    private function resolver($params)
    {
        Fn::$paramsResolver = function () use ($params) {
            unset($params['_swagger']);
            unset($params['_route']);

            return array_values($params);
        };

        $paramsResolver = Fn::$paramsResolver;
        $return = require $params['_swagger']['operationId'];
        Fn::$paramsResolver = $paramsResolver;

        return $return;
    }
}
