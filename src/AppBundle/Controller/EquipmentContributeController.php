<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\View\View;

class EquipmentContributeController extends FOSRestController
{
    /**
     * Get EquipmentContributes,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets all EquipmentContributes",
     * output = "AppBundle\Document\EquipmentContribute",
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the EquipmentContributes is not found"
     * }
     * )
     *
     *
     * RestView()
     * @return View
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function getEquipmentContributesAction()
    {
        $manager = $this->get('doctrine_mongodb')->getManager();
        $equipment_contributes = $manager->getRepository('AppBundle:EquipmentContribute')->findAll();
        $restView = View::create();
        $restView->setData($equipment_contributes);

        return $restView;
    }
}
