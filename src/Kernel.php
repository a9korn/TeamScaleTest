<?php

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

class Kernel
{
    public $defaultControllerName = 'Main';
    public $defaultMethodName     = "index";


    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function run( Request $request )
    {
        $routeParam = $this->getParamRoute( $request );

        $response = $this->runMethod( $routeParam[ 'controller' ], $routeParam[ 'method' ], [] );

        if ( !$response instanceof Response ) {
            throw new \Exception('Need instanceof Response');
        }

        return $response;
    }

    /**
     * @param $controllerName
     * @param $methodName
     * @param $params
     * @return Response
     */
    private function runMethod( $controllerName, $methodName, $params )
    {
        $controllerName = empty( $controllerName ) ? $this->defaultControllerName : ucfirst( $controllerName );

        if ( !class_exists( "App\\Controller\\" . ucfirst( $controllerName ) ) ) {
            throw new \BadMethodCallException('No Controller Found');
        }
        $controllerName = "App\\Controller\\" . ucfirst( $controllerName );
        $controller     = new $controllerName;
        $methodName     = empty( $methodName ) ? $this->defaultMethodName : $methodName;
        if ( !method_exists( $controller, $methodName ) ) {
            throw new \BadMethodCallException('No Method Found');
        }

        return $controller->$methodName( $params );
    }

    /**
     * @param Request $request
     * @return array
     */
    private function getParamRoute( Request $request )
    {
        $routes = Router::routes();

        $context = new RequestContext();
        $context->fromRequest( $request );

        $matcher = new UrlMatcher( $routes, $context );

        return $matcher->match( $context->getPathInfo() );
    }
}