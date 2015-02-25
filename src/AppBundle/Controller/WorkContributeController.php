<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\View\View;
use Symfony\Component\Config\Definition\Exception\Exception;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;

class WorkContributeController extends FOSRestController
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
        $manager = $this->get('doctrine_mongodb')->getManager();
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

    /**
     * @ApiDoc(
     *      resource = true,
     *      description = "create single work contribute",
     *      parameters = {
     *          {"name" = "financial_resource", "dataType" = "array<AppBundle\Document\WorkResource>", "required" = true, "description" = "resource that contributet" },
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
    public function postWorkContributesAction(Request $request, $slug)
    {
        $data = $request->request->all();
        $user = $this->getUser();

        $dm = $this->get('doctrine.odm.mongodb.document_manager');

        $slugResource = $request->request->get('work_contribute');

        $dream = $this->get('doctrine_mongodb.odm.document_manager')
            ->getRepository('AppBundle:Dream')
            ->findOneBySlug($slug);

        $work_resource = $this->get('doctrine_mongodb.odm.document_manager')
            ->getRepository('AppBundle:FinancialResource')
            ->findOneBySlug($slugResource);

        $view = View::create();

        if (!$dream) {
            $view->setStatusCode(404);
        } else {
            $data = $this->get('serializer')->serialize($data, 'json');
            $work_contribute = $this->get('serializer')
                ->deserialize($data, 'AppBundle\Document\WorkContribute', 'json');

            $work_contribute->setEquipmentResource($work_resource);
            $work_contribute->setDream($dream);
            $work_contribute->setUser($user);

            $view->setStatusCode(204);

            $dm->persist($work_contribute);
            $dm->flush();
        }

        return $view;
    }
}
