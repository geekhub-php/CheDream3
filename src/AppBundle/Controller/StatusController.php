<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\View\View;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;

class StatusController extends FOSRestController
{
    /**
     * Get Status,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets all statuses",
     * output="array<AppBundle\Document\Status>",
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the status is not found"
     * }
     * )
     *
     * @QueryParam(name="limit", requirements="\d+", default="10", description="Count statuses at one page")
     * @QueryParam(name="page", requirements="\d+", default="1", description="Number of page to be shown")
     *
     * @RestView
     *
     * @param  ParamFetcher $paramFetcher
     * @return View
     *
     * @throws NotFoundHttpException when not exist
     */
    public function getStatusAction(ParamFetcher $paramFetcher)
    {
        $manager = $this->get('doctrine_mongodb')->getManager();
        $status = $manager->createQueryBuilder('AppBundle:Status')->getQuery();

        if (count($status) == 0) {
            throw new Exception("204 No Content");
        }

        $limit = $paramFetcher->get('limit');
        $page = $paramFetcher->get('page');

        $paginator  = $this->get('knp_paginator');
        $status = $paginator->paginate(
            $status,
            $paramFetcher->get('page', $page),
            $limit
        );

        return $status;
    }
}
