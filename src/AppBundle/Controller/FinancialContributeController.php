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
     * Get FinancialContributes,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets all FinancialContributes",
     * output =   { "class" = "AppBundle\Document\FinancialContribute", "collection" = true, "collectionName" = "financial_contributes" },
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the FinancialContributes is not found"
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
    public function getFinancialContributesAction()
    {
        $manager = $this->get('doctrine_mongodb')->getManager();
        $financialContributes = $manager->getRepository('AppBundle:FinancialContribute')->findAll();
        $restView = View::create();

        if (count($financialContributes) == 0) {
            $restView->setStatusCode(204);
        }

        $restView->setData($financialContributes);

        return $restView;
    }
}
