<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use AppBundle\Service\MarsClockService;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * HelloController.
 *
 * @Route("/api",name="api_")
 */
class MarsClockController extends AbstractFOSRestController
{

    /**
     *
     * @Rest\Get("/marsclock")
     * @QueryParam(name="utc", default="")
     * @return Response
     */
    public function marsAction(ParamFetcher $paramFetcher)
    {
        try {
            $utcTime = $paramFetcher->get('utc');
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