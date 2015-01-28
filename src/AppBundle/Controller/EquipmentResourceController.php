<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\View\View;

class EquipmentResourceController extends FOSRestController
{
    /**
     * Get single EquipmentResource,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets a EquipmentResource for a given id",
     * output = "AppBundle\Document\EquipmentResource",
     * statusCodes = {
     * 200 = "Returned when successful",
     * 404 = "Returned when the EquipmentResourcee is not found"
     * }
     * )
     *
     *
     * RestView()
     * @param
     * @return mixed
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function getEquipmentResourceAction()
    {
        $manager = $this->get('doctrine_mongodb')->getManager();
        $equipment_resource = $manager->getRepository('AppBundle:EquipmentResource')->findAll();
        $restView = View::create();
        $restView->setData($equipment_resource);

        return $restView;
    }
}
