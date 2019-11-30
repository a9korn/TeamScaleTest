<?php

/** load my core */

use App\Kernel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'load.php';

$request = Request::createFromGlobals();
$app     = new Kernel();

try {
    $response = $app->run( $request );
} catch ( Exception $e ) {
    $response = new Response( $e->getMessage(), Response::HTTP_NOT_FOUND );
}

$response->send();
