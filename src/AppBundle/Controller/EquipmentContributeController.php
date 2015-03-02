<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\View\View;
use Symfony\Component\Config\Definition\Exception\Exception;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;

class EquipmentContributeController extends AbstractController
{
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
    public function postEquipmentContributesAction(SymfonyRequest $request, $slug)
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
