<?php

namespace AppBundle\Controller;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\View\View;
use Symfony\Component\Validator\Constraints\All;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;

class DreamController extends FOSRestController
{
    /**
     * Gets all Dreams,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets all Dream",
     * output="array<AppBundle\Document\Dream>",
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the Dream is not found"
     * }
     * )
     *
     * @QueryParam(name="limit", requirements="\d+", default="10", description="Count dreams at one page")
     * @QueryParam(name="page", requirements="\d+", default="1", description="Number of page to be shown")
     *
     * @RestView
     *
     * @param  ParamFetcher $paramFetcher
     * @param  Request      $request
     * @return View
     *
     * @throws NotFoundHttpException when not exist
     */
    public function getDreamsAction(Request $request, ParamFetcher $paramFetcher)
    {
        $manager = $this->get('doctrine_mongodb')->getManager();
        $dreamsQuery = $manager->createQueryBuilder('AppBundle:Dream')->getQuery();

        $limit = $paramFetcher->get('limit');
        $page = $paramFetcher->get('page');

        $paginator  = $this->get('knp_paginator');
        $dreamsQuery = $paginator->paginate(
            $dreamsQuery,
            $request->query->get('page', $page),
            $limit
        );

        if (count($dreamsQuery) == 0) {
            throw new Exception("204 No Content");
        }

        return $dreamsQuery;
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
