<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\View\View;

class UserController extends FOSRestController
{
    /**
     * Get single user,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets a User for a given slug",
     * output = "AppBundle\Document\OtherContribute",
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the page is not found"
     * }
     * )
     *
     * RestView()
     * @param $firstName
     * @return View
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function getUserAction($firstName)
    {
        $manager = $this->get('doctrine_mongodb')->getManager();
        $user = $manager->getRepository('AppBundle:User')->findOneByfirstName($firstName);
        $restView = View::create();
        $restView->setData($user);

        return $restView;
    }
}
