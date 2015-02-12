<?php

namespace AppBundle\Controller;

use AppBundle\Document\Dream;
use AppBundle\Document\EquipmentResource;
use AppBundle\Document\FinancialResource;
use AppBundle\Document\WorkResource;
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
     * @param
     * @return View
     *
     * @throws NotFoundHttpException when not exist
     */
    public function getDreamsAction()
    {
        $manager = $this->get('doctrine_mongodb')->getManager();
        $dreams = $manager->getRepository('AppBundle:Dream')->findAll();
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

    /**
     * Create dream
     *
     * @ApiDoc(
     *      resource = true,
     *      description = "Create single dream"
     * )
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function postDreamAction(Request $request)
    {
        $data = $request->request->all();
        $user = $this->getUser();

        $data = $this->get('serializer')->serialize($data, 'json');
        $dream = $this->get('serializer')->deserialize($data, 'AppBundle\Document\Dream', 'json');

        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $dm->persist($dream);
        $dm->flush();

        $restView = View::create();
        $restView->setStatusCode(201);

        return $restView;
    }
}
