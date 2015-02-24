<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\Config\Definition\Exception\Exception;
use FOS\RestBundle\Controller\Annotations\QueryParam;

class FaqController extends FOSRestController
{
    /**
     * Get Faqs,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets all Faq",
     * output="array<AppBundle\Document\Faq>",
     * statusCodes = {
     *      200 = "Returned when successful",
     *      204 = "Returned when the Faqs is not found"
     * }
     * )
     *
     * @Rest\View()
     *
     * @return View
     *
     * @throws NotFoundHttpException when not exist
     */
    public function getFaqsAction()
    {
        $manager = $this->get('doctrine_mongodb.odm.document_manager');
        $faqsQuery = $manager->getRepository('AppBundle:Faq')->findAll();

        if (count($faqsQuery) == 0) {
            throw new Exception("204 No Content");
        }

        return [
            "faqs" => $faqsQuery
        ];
    }
}
