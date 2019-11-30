<?php


namespace App;


use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class Router
{
    public static function routes()
    {
        $home_route = new Route( '/', [
                'controller' => 'MainController',
                'method'     => 'index'
            ]
        );
        $upload_route = new Route( '/upload', [
                'controller' => 'StatisticController',
                'method'     => 'index'
            ]
        );

        $routes = new RouteCollection();
        $routes->add( 'home_route', $home_route );
        $routes->add( 'upload_route', $upload_route );

        return $routes;
    }
}