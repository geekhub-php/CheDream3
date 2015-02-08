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
     * output =   { "class" = "AppBundle\Document\FinancialResource", "collection" = true, "collectionName" = "financial_resource" },
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
        $financialResources = $manager->getRepository('AppBundle:FinancialResource')->findAll();
        $restView = View::create();

        if (count($financialResources) == 0) {
            $restView->setStatusCode(204);

            return $restView;
        }

        $restView->setData($financialResources);

        return $restView;
    }
}
