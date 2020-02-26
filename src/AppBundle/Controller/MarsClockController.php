<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use AppBundle\Service\MarsClockService;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * HelloController.
 *
 * @Route("/api",name="api_")
 */
class MarsClockController extends FOSRestController
{

    /**
     *
     * @Rest\Get("/marsclock/utcTime={utcTime}")
     * @return Response
     */
    public function marsAction($utcTime)
    {
        try {
            $marsClockService = new MarsClockService();
            $MSD = $marsClockService->getMSD($utcTime);
            $MTC = $marsClockService->getMTC($MSD);
            $response = new \stdClass();
            $response->MSD = $MSD;
            $response->MTC = $MTC;
            return new Response(json_encode($response));
        } catch (BadRequestHttpException $e) {
            $response = new \stdClass();
            $response->message = $e->getMessage();
            return new Response(json_encode($response), 400);
        } catch (NotFoundHttpException $e) {
            echo "hereeee";
            $response = new \stdClass();
            $response->message = "Please check if the input url is valid";
            return new Response(json_encode($response), 404);
        }
    }

    public function checkIsAValidDate($utcDate)
    {
        return (bool) strtotime($utcDate);
    }
}