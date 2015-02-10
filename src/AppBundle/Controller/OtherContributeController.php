<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\View\View;

class OtherContributeController extends FOSRestController
{
    /**
     * Get OtherContributes,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets other contributes your dream",
     * output="array<AppBundle\Document\OtherContribute>",
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the OtherContributes is not found"
     * }
     * )
     *
     * RestView()
     * @param
     * @return View
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function getOtherContributesAction()
    {
        $manager = $this->get('doctrine_mongodb')->getManager();
        $contribute = $manager->getRepository('AppBundle:OtherContribute')->findAll();
        $restView = View::create();

        if (count($contribute) == 0) {
            $restView->setStatusCode(204);
        }

        $restView->setData($contribute);

        return $restView;
    }
}
