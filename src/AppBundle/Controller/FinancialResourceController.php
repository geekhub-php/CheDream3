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
     * Get single FinancialResource,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets a FinancialResource for a given id",
     * output = "AppBundle\Document\FinancialResource",
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the FinancialResource is not found"
     * }
     * )
     *
     *
     * RestView()
     * @param
     * @return mixed
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function getFinancialResourceAction()
    {
        $manager = $this->get('doctrine_mongodb')->getManager();
        $financial_resource = $manager->getRepository('AppBundle:FinancialResource')->findAll();
        $restView = View::create();
        $restView->setData($financial_resource);

        return $restView;
    }
}
