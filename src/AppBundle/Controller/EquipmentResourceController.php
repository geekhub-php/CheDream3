<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request as RequestSymfony;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\View\View;

class EquipmentResourceController extends AbstractController
{
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
     * @param  RequestSymfony $request
     * @param $slug
     * @return View
     */
    public function postEquipmentResourcesAction(RequestSymfony $request, $slug)
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
     * @param RequestSymfony $request
     * @param $slugDream
     * @param $slugEquipmentResource
     *
     * @return View
     */
    public function putEquipmentResourcesAction(RequestSymfony $request, $slugDream, $slugEquipmentResource)
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
