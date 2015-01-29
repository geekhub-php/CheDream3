<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\View\View;

class WorkContributeController extends FOSRestController
{
    /**
     * Get WorkContribute,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets all WorkContributors",
     * output = "AppBundle\Document\WorkContribute",
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the WorkContributors is not found"
     * }
     * )
     *
     *
     * RestView()
     * @param
     * @return View
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function getWorkContributorsAction()
    {
        $manager = $this->get('doctrine_mongodb')->getManager();
        $work_contribute = $manager->getRepository('AppBundle:WorkContribute')->findAll();
        $restView = View::create();
        $restView->setData($work_contribute);

        return $restView;
    }
}
