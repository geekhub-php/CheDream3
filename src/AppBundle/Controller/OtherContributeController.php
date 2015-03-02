<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\View\View;
use Symfony\Component\Config\Definition\Exception\Exception;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;

class OtherContributeController extends AbstractController
{
    /**
     * Get OtherContributes,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets other contributes your dream",
     * output="array<AppBundle\Document\OtherContribute>",
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the OtherContributes is not found"
     * }
     * )
     *
     * @QueryParam(name="limit", requirements="\d+", default="10", description="Count other contributes at one page")
     * @QueryParam(name="page", requirements="\d+", default="1", description="Number of page to be shown")
     *
     * @RestView
     *
     * @param  ParamFetcher $paramFetcher
     * @return View
     *
     * @throws NotFoundHttpException when not exist
     */
    public function getOtherContributesAction(ParamFetcher $paramFetcher)
    {
        $manager = $this->getMongoDbManager();
        $contributesQuery = $manager->createQueryBuilder('AppBundle:OtherContribute')->getQuery();

        if (count($contributesQuery) == 0) {
            throw new Exception("204 No Content");
        }

        $limit = $paramFetcher->get('limit');
        $page = $paramFetcher->get('page');

        $paginator  = $this->get('knp_paginator');
        $contributesQuery = $paginator->paginate(
            $contributesQuery,
            $paramFetcher->get('page', $page),
            $limit
        );

        return $contributesQuery;
    }
}
