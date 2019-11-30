<?php


namespace App\Controller;


use App\Controller;
use App\Service\statisticService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StatisticController extends Controller
{
    /**
     * Upload Page
     *
     * @return Response
     * @throws \Exception
     */
    public function index()
    {
        $request = Request::createFromGlobals();

        $array_statistics = [];
        $total_calls = 0;
        $total_duration = 0;
        if ( $request->isMethod( 'POST' ) && $request->files->get( 'fileCSV' ) ) {
            $fileCSV = $request->files->get( 'fileCSV' );

            $statisticService = new statisticService();
            $statisticService->setData($fileCSV->getRealPath());
            $array_statistics = $statisticService->getStatistic();
            $total_calls = $statisticService->getTotalCalls();
            $total_duration = $statisticService->getTotalDuration();
        }

        $view = $this->render( 'upload', [
            'statistics' => $array_statistics,
            'total_calls' => $total_calls,
            'total_duration' => $total_duration
        ] );

        return new Response( $view );
    }

}