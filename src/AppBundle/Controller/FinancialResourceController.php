<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\View\View;

class FinancialResourceController extends FOSRestController
{
    /**
     * Get FinancialResources,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets all FinancialResources",
     * output = "AppBundle\Document\FinancialResource",
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the FinancialResources is not found"
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
    public function getFinancialResourcesAction()
    {
        $manager = $this->get('doctrine_mongodb')->getManager();
        $financial_resources = $manager->getRepository('AppBundle:FinancialResource')->findAll();
        $restView = View::create();
        $restView->setData($financial_resources);

        return $restView;
    }
}
