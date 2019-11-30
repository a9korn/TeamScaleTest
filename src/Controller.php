<?php


namespace App;


use Symfony\Component\Routing\Exception\ResourceNotFoundException;

abstract class Controller
{
    private $layout = 'Views/Layout.php';

    /**
     * @param string $viewName
     * @param array $params
     * @return string
     */
    public function render( string $viewName, array $params = [] )
    {
        $viewFile = SRCPATH . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . $viewName . '.php';
        if ( !file_exists( $viewFile ) ) {
            throw new ResourceNotFoundException( sprintf("View '%s' not found!",$viewName) );
        }
        extract( $params );
        ob_start();

        /** include view */
        require $viewFile;
        $body = ob_get_clean();

        /** include main layout */
        require SRCPATH . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . "Layout.php";

        return ob_get_clean();
    }
}