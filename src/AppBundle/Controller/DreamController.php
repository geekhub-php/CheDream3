<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\View\View;

class DreamController extends FOSRestController
{
    /**
     * Return array of dreams
     *
     * @ApiDoc(
     * resource = true,
     * description = "Return array of all dreams",
     * output = "AppBundle\Document\Dream",
     * statusCodes = {
     *      200 = "Return when database has more that one dream",
     *      204 = "Return when database don't has dreams"
     *    }
     * )
     *
     * @return mixed
     *
     * @throws NotFoundHttpException when not exist
     */
    public function getDreamsAction()
    {
        $manager = $this->get('doctrine_mongodb')->getManager();
        $dream = $manager->getRepository('AppBundle:Dream')->findAll();

        $restView = View::create();

        if (count($dream) == 0) {
            $restView->setStatusCode(204);

            return $restView;
        }

        $restView->setData($dream);

        return $restView;
    }
}
