<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\View\View;

class ExportedUserController extends FOSRestController
{
    /**
     * Get ExportedUser,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets all ExportedUser",
     * output = "AppBundle\Document\ExportedUser",
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the ExportedUser is not found"
     * }
     * )
     *
     * RestView()
     * @param
     * @return View
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function getExportedUserAction()
    {
        $manager = $this->get('doctrine_mongodb')->getManager();
        $exported_user = $manager->getRepository('AppBundle:ExportedUser')->findAll();
        $restView = View::create();
        $restView->setData($exported_user);

        return $restView;
    }
}
