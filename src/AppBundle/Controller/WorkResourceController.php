<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\View\View;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;

class WorkResourceController extends AbstractController
{
    /**
     * @ApiDoc(
     * resource = true,
     * description = "Gets all WorkResources",
     * parameters = {
     *      {"name" = "title", "required" = true, "dataType" = "string"},
     *      {"name" = "quantity", "required" = true, "dataType" = "integer"}
     * },
     * statusCodes = {
     *      201 = "Returned when successful create",
     *      400 = "Returned when the WorkResources return error"
     * }
     * )
     *
     * @param SymfonyRequest $request
     * @param $slug
     *
     * @return View
     */
    public function postWorkResourcesAction(SymfonyRequest $request, $slug)
    {
        $dm = $this->get('doctrine.odm.mongodb.document_manager');

        $data = $request->request->all();

        $dream = $dm->getRepository('AppBundle:WorkResource')
                    ->findOneBySlug($slug);

        $data = $this->get('serializer')->serialize($data, 'json');
        $work_resource = $this->get('serializer')->deserialize($data, 'AppBundle\Document\WorkResource', 'json');

        $work_resource->setDream($dream);

        $dm->persist($work_resource);
        $dm->flush();

        $restView = View::create();
        $restView->setStatusCode(201);

        return $restView;
    }

    /**
     * @ApiDoc(
     * resource = true,
     * description = "Create/Update single work resource",
     * parameters={
     *     {"name" = "title", "required" = true, "dataType" = "string"},
     *     {"name" = "quantity", "required" = true, "dataType" = "integer"}
     * },
     * statusCodes = {
     * 200 = "Work Resource successful update",
     * 404 = "Return when work resource with current slug not isset"
     * }
     * )
     *
     * @param SymfonyRequest $request
     * @param $slugDream
     * @param $slugWorkResource
     *
     * @return View
     */
    public function putWorkResourcesAction(SymfonyRequest $request, $slugDream, $slugWorkResource)
    {
        $data = $request->request->all();
        $dm = $this->get('doctrine.odm.mongodb.document_manager');

        $work_resource_old = $dm->getRepository('AppBundle:WorkResource')
                                ->findOneBySlug($slugWorkResource);

        $data = $this->get('serializer')->serialize($data, 'json');
        $work_resource_new = $this->get('serializer')->deserialize($data, 'AppBundle\Document\WorkResource', 'json');

        $view = View::create();

        if (!$work_resource_old) {
            $dream = $dm->getRepository('AppBundle:Dream')
                        ->findOneBySlug($slugDream);

            $work_resource_new->setDream($dream);

            $dm->persist($work_resource_new);
            $dm->flush();

            $view->setStatusCode(204);
        } else {
            $this->get('app.services.object_updater')->updateObject($work_resource_old, $work_resource_new);

            $dm->flush();

            $view->setStatusCode(200);
        }

        return $view;
    }
}
