<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\View\View;

class WorkResourceController extends FOSRestController
{
    /**
     * Get WorkResources,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets all WorkContributes",
     * output =   { "class" = "AppBundle\Document\WorkResource", "collection" = true, "collectionName" = "work_resource" },
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the WorkContributes is not found"
     * }
     * )
     *
     * RestView()
     * @param
     * @return View
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function getWorkResourcesAction()
    {
        $manager = $this->get('doctrine_mongodb')->getManager();
        $workResources = $manager->getRepository('AppBundle:WorkResource')->findAll();
        $restView = View::create();

        if (count($workResources) == 0) {
            $restView->setStatusCode(204);

            return $restView;
        }

        $restView->setData($workResources);

        return $restView;
    }
}
