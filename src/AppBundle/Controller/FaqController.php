<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\View\View;

class FaqController extends FOSRestController
{
    /**
     * Get single Faq,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets a Faq for a given id",
     * output = "AppBundle\Document\Faq",
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the Faq is not found"
     * }
     * )
     *
     *
     * RestView()
     * @return View
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function getFaqAction()
    {
        $manager = $this->get('doctrine_mongodb')->getManager();
        $faq = $manager->getRepository('AppBundle:Faq')->findAll();
        $restView = View::create();
        $restView->setData($faq);

        return $restView;
    }
}
