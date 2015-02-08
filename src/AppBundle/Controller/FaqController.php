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
     * Get Faqs,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets all Faq",
     * output =   { "class" = "AppBundle\Document\Faq", "collection" = true, "collectionName" = "faq" },
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the Faqs is not found"
     * }
     * )
     *
     *
     * RestView()
     * @param
     * @return mixed
     * @throws NotFoundHttpException when page not exist
     */
    public function getFaqsAction()
    {
        $manager = $this->get('doctrine_mongodb')->getManager();
        $faqs = $manager->getRepository('AppBundle:Faq')->findAll();
        $restView = View::create();

        if (count($faqs) == 0) {
            $restView->setStatusCode(204);
            return $restView;
        }


        $restView->setData($faqs);

        return $restView;
    }
}
