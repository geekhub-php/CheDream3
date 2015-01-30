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
     * output = "AppBundle\Document\FinancialContribute",
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the FinancialContributes is not found"
     * }
     * )
     *
     *
     * RestView()
     * @return mixed
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function getFinancialContributesAction()
    {
        $manager = $this->get('doctrine_mongodb')->getManager();
        $financial_contributes = $manager->getRepository('AppBundle:FinancialContribute')->findAll();
        $restView = View::create();
        $restView->setData($financial_contributes);

        return $restView;
    }
}
