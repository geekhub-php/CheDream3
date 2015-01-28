<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\View\View;

class FinancialContributeController extends FOSRestController
{
    /**
     * Get single FinancialContribute,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets a FinancialContribute for a given id",
     * output = "AppBundle\Document\FinancialContribute",
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the FinancialContribute is not found"
     * }
     * )
     *
     *
     * RestView()
     * @return mixed
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function getFinancialContributeAction()
    {
        $manager = $this->get('doctrine_mongodb')->getManager();
        $financial_contribute = $manager->getRepository('AppBundle:FinancialContribute')->findAll();
        $restView = View::create();
        $restView->setData($financial_contribute);

        return $restView;
    }
}
