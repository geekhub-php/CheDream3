<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\View\View;
use Symfony\Component\Config\Definition\Exception\Exception;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;

class WorkContributeController extends AbstractController
{
    /**
     * Get WorkContributes,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets all WorkContributes",
     * output="array<AppBundle\Document\WorkContribute>",
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the WorkContributes is not found"
     * }
     * )
     *
     * @QueryParam(name="limit", requirements="\d+", default="10", description="Count work contributes at one page")
     * @QueryParam(name="page", requirements="\d+", default="1", description="Number of page to be shown")
     *
     * @RestView
     *
     * @param  ParamFetcher $paramFetcher
     * @return View
     *
     * @throws NotFoundHttpException when not exist
     */
    public function getWorkContributesAction(ParamFetcher $paramFetcher)
    {
        $manager = $this->getMongoDbManager();
        $workQuery = $manager->createQueryBuilder('AppBundle:WorkContribute')->getQuery();

        if (count($workQuery) == 0) {
            throw new Exception("204 No Content");
        }

        $limit = $paramFetcher->get('limit');
        $page = $paramFetcher->get('page');

        $paginator  = $this->get('knp_paginator');
        $workQuery = $paginator->paginate(
            $workQuery,
            $paramFetcher->get('page', $page),
            $limit
        );

        return $workQuery;
    }
}
