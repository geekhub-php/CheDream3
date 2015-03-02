<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\View\View;
use Symfony\Component\Config\Definition\Exception\Exception;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;

class EquipmentResourceController extends AbstractController
{
    /**
     * Get EquipmentResources,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets all EquipmentResources",
     * output="array<AppBundle\Document\EquipmentResource>",
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the EquipmentResources is not found"
     * }
     * )
     *
     * @QueryParam(name="limit", requirements="\d+", default="10", description="Count resources contributes at one page")
     * @QueryParam(name="page", requirements="\d+", default="1", description="Number of page to be shown")
     *
     * @RestView
     *
     * @param  ParamFetcher $paramFetcher
     * @return View
     *
     * @throws NotFoundHttpException when not exist
     */
    public function getEquipmentResourcesAction(ParamFetcher $paramFetcher, $slug)
    {
        $manager = $this->getMongoDbManager();
        $equipmentQuery = $manager->createQueryBuilder('AppBundle:EquipmentResource')->getQuery();

        if (count($equipmentQuery) == 0) {
            throw new Exception("204 No Content");
        }

        $limit = $paramFetcher->get('limit');
        $page = $paramFetcher->get('page');

        $paginator  = $this->get('knp_paginator');
        $equipmentQuery = $paginator->paginate(
            $equipmentQuery,
            $paramFetcher->get('page', $page),
            $limit
        );

        return $equipmentQuery;
    }

    /**
     * @ApiDoc(
     * resource = true,
     * description = "Gets all EquipmentResources",
     * parameters = {
     *      {"name" = "quantity_type", "required" = true, "dataType" = "string"},
     *      {"name" = "title", "required" = true, "dataType" = "string"},
     *      {"name" = "quantity", "required" = true, "dataType" = "integer"}
     * },
     * statusCodes = {
     *      201 = "Returned when successful create",
     *      400 = "Returned when the EquipmentResources return error"
     * }
     * )
     *
     * @param  Request $request
     * @param $slug
     * @return View
     */
    public function postEquipmentResourcesAction(Request $request, $slug)
    {
        $dm = $this->get('doctrine.odm.mongodb.document_manager');

        $data = $request->request->all();

        $dream = $dm->getRepository('AppBundle:EquipmentResource')
                    ->findOneBySlug($slug);

        $data = $this->get('serializer')->serialize($data, 'json');
        $equipment_resource = $this->get('serializer')->deserialize($data, 'AppBundle\Document\EquipmentResource', 'json');

        $equipment_resource->setDream($dream);

        $dm->persist($equipment_resource);
        $dm->flush();

        $restView = View::create();
        $restView->setStatusCode(201);

        return $restView;
    }

    /**
     * @ApiDoc(
     * resource = true,
     * description = "Create/Update single equipment resource",
     * parameters={
     *     {"name" = "quantity_type", "required" = true, "dataType" = "string"},
     *     {"name" = "title", "required" = true, "dataType" = "string"},
     *     {"name" = "quantity", "required" = true, "dataType" = "integer"}
     * },
     * statusCodes = {
     * 200 = "Equipment Resource successful update",
     * 404 = "Return when equipment resource with current slug not isset"
     * }
     * )
     *
     * @param  Request $request
     * @param $slugDream
     * @param $slugEquipmentResource
     *
     * @return View
     */
    public function putEquipmentResourcesAction(Request $request, $slugDream, $slugEquipmentResource)
    {
        $data = $request->request->all();
        $dm = $this->get('doctrine.odm.mongodb.document_manager');

        $equipment_resource_old = $dm->getRepository('AppBundle:EquipmentResource')
                                     ->findOneBySlug($slugEquipmentResource);

        $data = $this->get('serializer')->serialize($data, 'json');
        $equipment_resource_new = $this->get('serializer')->deserialize($data, 'AppBundle\Document\EquipmentResource', 'json');

        $view = View::create();

        if (!$equipment_resource_old) {
            $dream = $dm->getRepository('AppBundle:Dream')
                        ->findOneBySlug($slugDream);

            $equipment_resource_new->setDream($dream);

            $dm->persist($equipment_resource_new);
            $dm->flush();

            $view->setStatusCode(204);
        } else {
            $this->get('app.services.object_updater')->updateObject($equipment_resource_old, $equipment_resource_new);

            $dm->flush();

            $view->setStatusCode(200);
        }

        return $view;
    }
}
