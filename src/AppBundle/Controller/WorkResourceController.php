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
     * Get work resource,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets Work resource for a given title",
     * output = "AppBundle\Document\WorkResource",
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the page is not found"
     * }
     * )
     *
     * RestView()
     * @param $title
     * @return View
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function getOtherContributeAction($title)
    {
        $manager = $this->get('doctrine_mongodb')->getManager();
        $work_resource = $manager->getRepository('AppBundle:WorkResource')->findOneByTitle($title);
        $restView = View::create();
        $restView->setData($work_resource);

        return $restView;
    }
}
