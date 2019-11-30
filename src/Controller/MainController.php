<?php

namespace App\Controller;

use App\Controller;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{
    /**
     * Main page
     *
     * @return Response
     */
    public function index()
    {
        $view = $this->render( 'main' );

        return new Response( $view );
    }
}