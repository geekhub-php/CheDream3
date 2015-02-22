<?php

namespace AppBundle\Controller;

use AppBundle\Document\Dream;
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
     *  resource = true,
     *  description = "Gets all Dream",
     *  output="array<AppBundle\Document\Dream>",
     *  statusCodes = {
     *      200 = "Returned when successful",
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
     */
    public function getDreamsAction(ParamFetcher $paramFetcher)
    {
        $manager = $this->get('doctrine_mongodb')->getManager();
        $dreamsQuery = $manager->createQueryBuilder('AppBundle:Dream')->getQuery();

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
     * @RestView()
     * @param
     * @return View
     *
     * @throws NotFoundHttpException when not exist
     */
    public function getDreamAction($slug)
    {
        $dream = $this->get('doctrine_mongodb')->getManager()->getRepository('AppBundle:Dream')->findBySlug($slug);

        if (!$dream) {
            throw new NotFoundHttpException();
        }

        return $dream;
    }

    /**
     * Update existing dream from the submitted data or create a new dream at a specific location.
     *
     * @ApiDoc(
     * resource = true,
     * description = "Create/Update single dream",
     * parameters={
     * {"name"="title", "dataType"="string", "required"=true, "description"="Dream name"},
     * {"name"="description", "dataType"="string", "required"=true, "description"="Description about dream"},
     * {"name"="phone", "dataType"="integer", "required"=true, "description"="Phone number", "format"="(xxx) xxx xxx xxx"},
     * {"name"="dreamFinancialResources", "dataType"="array<AppBundle\Document\EquipmentResource>", "required"=true, "description"="Equipment resources"},
     * {"name"="dreamWorkResources", "dataType"="array<AppBundle\Document\WorkResource>", "required"=true, "description"="Work resources"},
     * {"name"="dreamFinancialResources", "dataType"="array<AppBundle\Document\FinancialResource>", "required"=true, "description"="Financial resources"}
     * },
     * statusCodes = {
     * 200 = "Dream successful update",
     * }
     * )
     *
     *
     * @param  Request $request the request object
     * @param  string  $slug    the page id
     * @return mixed
     */
    public function putDreamAction(Request $request, $slug)
    {
        $data = $request->request->all();
        $dm = $this->get('doctrine.odm.mongodb.document_manager');

        $dreamOld = $dm->getRepository('AppBundle:Dream')
                        ->findOneBySlug($slug);

        $data = $this->get('serializer')->serialize($data, 'json');
        $dreamNew = $this->get('serializer')->deserialize($data, 'AppBundle\Document\Dream', 'json');

        $dreamOld = $this->get('app.services.object_updater')->updateObject($dreamOld, $dreamNew);

        $dm->flush();

        return View::create();
    }
}
