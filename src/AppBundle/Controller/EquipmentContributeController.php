<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\View\View;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;

class EquipmentContributeController extends AbstractController
{
    /**
     * Get EquipmentContributes,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets all EquipmentContributes",
     * output="array<AppBundle\Document\EquipmentContribute>",
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the EquipmentContributes is not found"
     * }
     * )
     *
     * @QueryParam(name="limit", requirements="\d+", default="10", description="Count equipment contributes at one page")
     * @QueryParam(name="page", requirements="\d+", default="1", description="Number of page to be shown")
     *
     * @RestView
     *
     * @param  ParamFetcher $paramFetcher
     * @return View
     *
     * @throws NotFoundHttpException when not exist
     */
    public function getEquipmentContributesAction(ParamFetcher $paramFetcher)
    {
        $manager = $this->getMongoDbManager();
        $equipmentQuery = $manager->createQueryBuilder('AppBundle:EquipmentContribute')->getQuery();

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
     *      resource = true,
     *      description = "create single equipment contribute",
     *      parameters = {
     *          {"name" = "equipment_resource", "dataType" = "array<AppBundle\Document\EquipmentResource>", "required" = true, "description" = "resource that contributet" },
     *          {"name" = "quantity", "dataType" = "integer", "required" = true, "description" = "count contributet resources" }
     *      },
     *      statusCodes = {
     *          204 = "Returned when successful create",
     *          404 = "Returned when dream is not found"
     *      }
     * )
     *
     * @param Request $request
     * @param $slug
     *
     * @return View
     */
    public function postEquipmentContributesAction(Request $request, $slug)
    {
        $data = $request->request->all();
        $user = $this->getUser();

        $dm = $this->get('doctrine.odm.mongodb.document_manager');

        $slugResource = $request->request->get('equipment_contribute');

        $dream = $this->get('doctrine_mongodb.odm.document_manager')
                        ->getRepository('AppBundle:Dream')
                        ->findOneBySlug($slug);

        $equipment_resource = $this->get('doctrine_mongodb.odm.document_manager')
                                    ->getRepository('AppBundle:EquipmentResource')
                                    ->findOneBySlug($slugResource);

        $view = View::create();

        if (!$dream) {
            $view->setStatusCode(404);
        } else {
            $data = $this->get('serializer')->serialize($data, 'json');
            $equipment_contribute = $this->get('serializer')->deserialize($data, 'AppBundle\Document\EquipmentContribute', 'json');

            $equipment_contribute->setEquipmentResource($equipment_resource);
            $equipment_contribute->setDream($dream);
            $equipment_contribute->setUser($user);

            $view->setStatusCode(204);

            $dm->persist($equipment_contribute);
            $dm->flush();
        }

        return $view;
    }
}
