<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\View\View;

class WorkContributeController extends FOSRestController
{
    /**
     * Get WorkContributes,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets all WorkContributes",
     * output =   { "class" = "AppBundle\Document\WorkContribute", "collection" = true, "collectionName" = "work_contributes" },
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the WorkContributes is not found"
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
    public function getWorkContributesAction()
    {
        $manager = $this->get('doctrine_mongodb')->getManager();
        $workContributes = $manager->getRepository('AppBundle:WorkContribute')->findAll();
        $restView = View::create();

        if (count($workContributes) == 0) {
            $restView->setStatusCode(204);

            return $restView;
        }

        $restView->setData($workContributes);

        return $restView;
    }
}
