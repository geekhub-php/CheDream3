<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\View\View;

class OtherController extends FOSRestController
{
    /**
     * Get other contribute,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets other contribute your dream",
     * output = "AppBundle\Document\OtherContribute",
     * statusCodes = {
     * 200 = "Returned when successful",
     * 404 = "Returned when the page is not found"
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
        $contribute = $manager->getRepository('AppBundle:OtherContribute')->findOneByTitle($title);
        $restView = View::create();
        $restView->setData($contribute);

        return $restView;
    }
}
