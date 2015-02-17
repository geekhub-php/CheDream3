<?php

namespace AppBundle\Controller;

use AppBundle\Document\Dream;
use AppBundle\Document\EquipmentResource;
use AppBundle\Document\FinancialResource;
use AppBundle\Document\WorkResource;
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
     * @return View
     *
     * @throws NotFoundHttpException when not exist
     */
    public function getDreamsAction(ParamFetcher $paramFetcher)
    {
        $manager = $this->get('doctrine_mongodb')->getManager();
        $dreamsQuery = $manager->createQueryBuilder('AppBundle:Dream')->getQuery();

        if (count($dreamsQuery) == 0) {
            throw new Exception("204 No Content");
        }

        $limit = $paramFetcher->get('limit');
        $page = $paramFetcher->get('page');

        $paginator  = $this->get('knp_paginator');
        $dreamsQuery = $paginator->paginate(
            $dreamsQuery,
            $paramFetcher->get('page', $page),
            $limit
        );

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
        $dream = $manager->getRepository('AppBundle:Dream')->findOneBySlug($slug);
        $restView = View::create();

        if (count($dream) == 0) {
            $restView->setStatusCode(204);
        }

        $restView->setData($dream);

        return $restView;
    }

    /**
     * Create dream
     *
     * @ApiDoc(
     *      resource = true,
     *      description = "Create single dream",
     *      parameters={
     *          {"name"="title", "dataType"="string", "required"=true, "description"="Dream name"},
     *          {"name"="description", "dataType"="string", "required"=true, "description"="Description about dream"},
     *          {"name"="phone", "dataType"="integer", "required"=true, "description"="Phone number", "format"="(xxx) xxx xxx xxx"}
     *      },
     *      statusCodes = {
                201 = "Dream sucessful created"
     *      }
     * )
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function postDreamAction(Request $request)
    {
        $data = $request->request->all();
        $user = $this->getUser();

        $data = $this->get('serializer')->serialize($data, 'json');
        $dream = $this->get('serializer')->deserialize($data, 'AppBundle\Document\Dream', 'json');
        $dream->setAuthor($user);

        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $dm->persist($dream);
        $dm->flush();

        $restView = View::create();
        $restView->setStatusCode(201);

        return $restView;
    }
}
за