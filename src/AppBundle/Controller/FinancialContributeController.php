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

class FinancialContributeController extends AbstractController
{
    /**
     * Get FinancialContributes,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets all FinancialContributes",
     * output="array<AppBundle\Document\FinancialContribute>",
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the FinancialContributes is not found"
     * }
     * )
     *
     * @QueryParam(name="limit", requirements="\d+", default="10", description="Count financial contributes at one page")
     * @QueryParam(name="page", requirements="\d+", default="1", description="Number of page to be shown")
     *
     * @RestView
     *
     * @param  ParamFetcher $paramFetcher
     * @return View
     *
     * @throws NotFoundHttpException when not exist
     */
    public function getFinancialContributesAction(ParamFetcher $paramFetcher)
    {
        $manager = $this->getMongoDbManager();
        $financialQuery = $manager->createQueryBuilder('AppBundle:FinancialContribute')->getQuery();

        if (count($financialQuery) == 0) {
            throw new Exception("204 No Content");
        }

        $limit = $paramFetcher->get('limit');
        $page = $paramFetcher->get('page');

        $paginator  = $this->get('knp_paginator');
        $financialQuery = $paginator->paginate(
            $financialQuery,
            $paramFetcher->get('page', $page),
            $limit
        );

        return $financialQuery;
    }

    /**
     * @ApiDoc(
     *      resource = true,
     *      description = "create single financial contribute",
     *      parameters = {
     *          {"name" = "financial_resource", "dataType" = "array<AppBundle\Document\FinancialResource>", "required" = true, "description" = "resource that contributet" },
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
    public function postFinancialContributesAction(Request $request, $slug)
    {
        $data = $request->request->all();
        $user = $this->getUser();

        $dm = $this->get('doctrine.odm.mongodb.document_manager');

        $slugResource = $request->request->get('equipment_contribute');

        $dream = $this->get('doctrine_mongodb.odm.document_manager')
            ->getRepository('AppBundle:Dream')
            ->findOneBySlug($slug);

        $financial_resource = $this->get('doctrine_mongodb.odm.document_manager')
            ->getRepository('AppBundle:FinancialResource')
            ->findOneBySlug($slugResource);

        $view = View::create();

        if (!$dream) {
            $view->setStatusCode(404);
        } else {
            $data = $this->get('serializer')->serialize($data, 'json');
            $financial_contribute = $this->get('serializer')
                                        ->deserialize($data, 'AppBundle\Document\FinancialContribute', 'json');

            $financial_contribute->setEquipmentResource($financial_resource);
            $financial_contribute->setDream($dream);
            $financial_contribute->setUser($user);

            $view->setStatusCode(204);

            $dm->persist($financial_contribute);
            $dm->flush();
        }

        return $view;
    }
}
