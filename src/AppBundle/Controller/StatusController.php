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
     * Get status,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets status for a given id",
     * output = "AppBundle\Document\Status",
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the status is not found"
     * }
     * )
     *
     * RestView()
     * @param $title
     * @return View
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function getStatusAction($id)
    {
        $manager = $this->get('doctrine_mongodb')->getManager();
        $status = $manager->getRepository('AppBundle:Status')->findBy($id);
        $restView = View::create();
        $restView->setData($status);

        return $restView;
    }
}
