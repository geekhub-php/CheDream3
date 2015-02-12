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

class FinancialResourceController extends FOSRestController
{
    /**
     * Get FinancialResources,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets all FinancialResources",
     * output="array<AppBundle\Document\FinancialResource>",
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the FinancialResources is not found"
     * }
     * )
     *
     * @QueryParam(name="limit", requirements="\d+", default="10", description="Count financial resources at one page")
     * @QueryParam(name="page", requirements="\d+", default="1", description="Number of page to be shown")
     *
     * @RestView
     *
     * @param  ParamFetcher $paramFetcher
     * @param  Request $request
     * @return View
     *
     * @throws NotFoundHttpException when not exist
     */
    public function getFinancialResourcesAction(Request $request, ParamFetcher $paramFetcher)
    {
        $manager = $this->get('doctrine_mongodb')->getManager();
        $financialResourcesQuery = $manager->createQueryBuilder('AppBundle:FinancialResource')->getQuery();

        if (count($financialResourcesQuery) == 0) {
            throw new Exception("204 No Content");
        }

        $limit = $paramFetcher->get('limit');
        $page = $paramFetcher->get('page');


        $paginator  = $this->get('knp_paginator');
        $financialResourcesQuery = $paginator->paginate(
            $financialResourcesQuery,
            $request->query->get('page', $page),
            $limit
        );

        return $financialResourcesQuery;
    }
}
