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
     * Get WorkResource,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets all WorkContribute",
     * output = "AppBundle\Document\WorkResource",
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the page is not found"
     * }
     * )
     *
     * RestView()
     * @param
     * @return View
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function getWorkResourceAction()
    {
        $manager = $this->get('doctrine_mongodb')->getManager();
        $work_resource = $manager->getRepository('AppBundle:WorkResource')->findAll();
        $restView = View::create();
        $restView->setData($work_resource);

        return $restView;
    }
}
