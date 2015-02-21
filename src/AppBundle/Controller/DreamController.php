<?php

namespace AppBundle\Controller;

use AppBundle\Model\DreamsResponse;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;

class DreamController extends FOSRestController
{
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
     * @QueryParam(name="status", strict=true, requirements="[a-z]+", default="submitted", description="Status", nullable=true)
     * @QueryParam(name="limit", requirements="\d+", default="10", description="Count statuses at one page")
     * @QueryParam(name="page", requirements="\d+", default="1", description="Number of page to be shown")
     * @QueryParam(name="sort_by", strict=true, requirements="[a-z]+", default="status_update", description="Sort by", nullable=true)
     * @QueryParam(name="sort_order", strict=true, requirements="[a-z]+", default="DESC", description="Sort order", nullable=true)
     * @param  ParamFetcher $paramFetcher
     * @return View
     *
     * @throws NotFoundHttpException when page not exist
     */

    public function getDreamsAction(ParamFetcher $paramFetcher)
    {
        $status = $paramFetcher->get('status');
        $sortBy = $paramFetcher->get('sort_by');
        $sortOrder = $paramFetcher->get('sort_order');

        $manager = $this->get('doctrine_mongodb')->getManager();

        $dreams = $manager->createQueryBuilder('AppBundle:Dream')
            ->sort($sortBy, $sortOrder)
            ->field('currentStatus')->equals($status)
            ->getQuery();

        if (!in_array($paramFetcher->get('status'), ['submitted', 'rejected'])) {
            throw new Exception("400");
        }

        $limit = $paramFetcher->get('limit');
        $page = $paramFetcher->get('page');

        $dreamsManager = new DreamsResponse();
        $dreamsManager->setLimit($limit);
        $dreamsManager->setPage($page);
        $dreamsManager->setSortBy($sortBy);
        $dreamsManager->setSortOrder($sortOrder);

        $paginator  = $this->get('knp_paginator');

        $dreamsPagination = $paginator->paginate(
            $dreams,
            $paramFetcher->get('page', $page),
            $limit
        );

        $dreamsManager->setDreams($dreamsPagination);

        return $dreamsManager;
    }

    /**
     * Get single Dream for slug,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets Dream for slug",
     * output="array<AppBundle\Document\Dream>",
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the Dream is not found"
     * }
     * )
     *
     *
     * RestView()
     * @param
     * @return View
     *
     * @throws NotFoundHttpException when not exist
     */
    public function getDreamAction($slug)
    {
        $manager = $this->get('doctrine_mongodb')->getManager();
        $dream = $manager->getRepository('AppBundle:Dream')->findBySlug($slug);
        $restView = View::create();

        if (count($dream) == 0) {
            $restView->setStatusCode(204);
        }

        $restView->setData($dream);

        return $restView;
    }
}
