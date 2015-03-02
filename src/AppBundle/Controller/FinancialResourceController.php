<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request as RequestSymfony;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\View\View;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;

class FinancialResourceController extends AbstractController
{
    /**
     * @ApiDoc(
     * resource = true,
     * description = "Gets all FinancialResources",
     * parameters = {
     *      {"name" = "title", "required" = true, "dataType" = "string"},
     *      {"name" = "quantity", "required" = true, "dataType" = "integer"}
     * },
     * statusCodes = {
     *      201 = "Returned when successful create",
     *      400 = "Returned when the FinancialResources return error"
     * }
     * )
     *
     * @param RequestSymfony $request
     * @param $slug
     *
     * @return View
     */
    public function postFinancialResourcesAction(RequestSymfony $request, $slug)
    {
        $dm = $this->get('doctrine.odm.mongodb.document_manager');

        $data = $request->request->all();

        $dream = $dm->getRepository('AppBundle:EquipmentResource')
                    ->findOneBySlug($slug);

        $data = $this->get('serializer')->serialize($data, 'json');
        $financial_resource = $this->get('serializer')->deserialize($data, 'AppBundle\Document\FinancialResource', 'json');

        $financial_resource->setDream($dream);

        $dm->persist($financial_resource);
        $dm->flush();

        $restView = View::create();
        $restView->setStatusCode(201);

        return $restView;
    }

    /**
     * @ApiDoc(
     * resource = true,
     * description = "Create/Update single financial resource",
     * parameters={
     *     {"name" = "title", "required" = true, "dataType" = "string"},
     *     {"name" = "quantity", "required" = true, "dataType" = "integer"}
     * },
     * statusCodes = {
     * 200 = "Financial Resource successful update",
     * 404 = "Return when financial resource with current slug not isset"
     * }
     * )
     *
     * @param RequestSymfony $request
     * @param $slugDream
     * @param $slugFinancialResource
     *
     * @return View
     */
    public function putFinancialResourcesAction(RequestSymfony $request, $slugDream, $slugFinancialResource)
    {
        $data = $request->request->all();
        $dm = $this->get('doctrine.odm.mongodb.document_manager');

        $financial_resource_old = $dm->getRepository('AppBundle:EquipmentResource')
            ->findOneBySlug($slugFinancialResource);

        $data = $this->get('serializer')->serialize($data, 'json');
        $financial_resource_new = $this->get('serializer')->deserialize($data, 'AppBundle\Document\EquipmentResource', 'json');

        $view = View::create();

        if (!$financial_resource_old) {
            $dream = $dm->getRepository('AppBundle:Dream')
                ->findOneBySlug($slugDream);

            $financial_resource_new->setDream($dream);

            $dm->persist($financial_resource_new);
            $dm->flush();

            $view->setStatusCode(204);
        } else {
            $this->get('app.services.object_updater')->updateObject($financial_resource_old, $financial_resource_new);

            $dm->flush();

            $view->setStatusCode(200);
        }

        return $view;
    }
}
