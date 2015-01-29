<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\View\View;

class StatusController extends FOSRestController
{
    /**
     * Get single status,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets a status for a given title",
     * output = "AppBundle\Document\Status",
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
    public function getStatusAction($title)
    {
        $manager = $this->get('doctrine_mongodb')->getManager();
        $status = $manager->getRepository('AppBundle:Status')->findByTitle($title);
        $restView = View::create();
        $restView->setData($status);

        return $restView;
    }
}
