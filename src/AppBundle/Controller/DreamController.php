<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\View\View;
use Symfony\Component\Validator\Constraints\All;

class DreamController extends FOSRestController
{
    /**
     * Gets all Dream,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets all Dream",
     * output="array<AppBundle\Document\Dream>",
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the Dream is not found"
     * }
     * )
     *
     *
     * RestView()
     * @param  Request $request
     * @return View
     *
     * @throws NotFoundHttpException when not exist
     */
    public function getDreamsAction(Request $request)
    {
        $manager = $this->get('doctrine_mongodb')->getManager();
        $dreams = $manager->getRepository('AppBundle:Dream')->findAll();

        $paginator  = $this->get('knp_paginator');
        $dreams = $paginator->paginate(
            $dreams,
            $request->query->get('page', 1)/*page number*/,
            10/*limit per page*/
        );

        $restView = View::create();

        if (count($dreams) == 0) {
            $restView->setStatusCode(204);
        }

        $restView->setData($dreams);

        return $restView;
    }

    /**
     * Get single Dream for slug,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets Dream for slug",
     * output="array<AppBundle\Document\Dream>",
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the Dream is not found"
     * }
     * )
     *
     *
     * RestView()
     * @param
     * @return View
     *
     * @throws NotFoundHttpException when not exist
     */
    public function getDreamAction($slug)
    {
        $manager = $this->get('doctrine_mongodb')->getManager();
        $dream = $manager->getRepository('AppBundle:Dream')->findBySlug($slug);
        $restView = View::create();

        if (count($dream) == 0) {
            $restView->setStatusCode(204);
        }

        $restView->setData($dream);

        return $restView;
    }
}
