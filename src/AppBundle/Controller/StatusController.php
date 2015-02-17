<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;

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
     * @throws Exception
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

    /**
     * Gets Dreams by status,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets Dreams by status",
     * output =   { "class" = "AppBundle\Document\Dream", "collection" = true, "collectionName" = "status" },
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the status is not found"
     * }
     * )
     *
     * RestView()
     *
     * @QueryParam(name="status", strict=true, requirements="[a-z]+", description="Status", nullable=false)
     * @QueryParam(name="limit", requirements="\d+", default="10", description="Count statuses at one page")
     * @QueryParam(name="page", requirements="\d+", default="1", description="Number of page to be shown")
     * @param  ParamFetcher $paramFetcher
     * @return View
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function getDreamsAction(ParamFetcher $paramFetcher)
    {
        $status = $paramFetcher->get('status');

        $manager = $this->get('doctrine_mongodb')->getManager();

        $dreams = $manager->createQueryBuilder('AppBundle:Dream')
            ->field('currentStatus')->equals($status)
            ->getQuery()->execute()->toArray();

        $limit = $paramFetcher->get('limit');
        $page = $paramFetcher->get('page');

        $paginator  = $this->get('knp_paginator');

        $dreams = $paginator->paginate(
            $dreams,
            $paramFetcher->get('page', $page),
            $limit
        );

        $restView = View::create();

        if (!in_array($paramFetcher->get('status'), ['submitted', 'rejected'])) {
            $restView->setStatusCode(400);
        }

        $restView->setData($dreams);

        return $restView;
    }
}
