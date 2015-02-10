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

class DreamController extends FOSRestController
{
    /**
     * Get single Dream,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets all Dream",
     * output = "AppBundle\Document\Dream",
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the Dream is not found"
     * }
     * )
     *
     *
     * RestView()
     * @param
     * @return mixed
     *
     * @throws NotFoundHttpException when not exist
     */
    public function getDreamsAction()
    {
        $manager = $this->get('doctrine_mongodb')->getManager();
        $dream = $manager->getRepository('AppBundle:Dream')->findAll();
        $restView = View::create();
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
        $data = $request->request;
        $user = $this->getUser();
        $dm = $this->get('doctrine.odm.mongodb.document_manager');

        $dream = new Dream();
        $dream->setTitle($data->get('title'));
        $dream->setDescription($data->get('description'));
        $dream->setPhone($data->get('phone'));
        $dream->setAuthor($user);

        foreach ($data->get('equipment_resource') as $equipment) {
            $er = new EquipmentResource();

            $er->setTitle($equipment['title']);
            $er->setQuantity($equipment['quantity']);
            $er->setQuantityType($equipment['quantityType']);

            $dm->persist($er);
        }

        foreach ($data->get('financial_resource') as $financial) {
            $fr = new FinancialResource();

            $fr->setTitle($financial['title']);
            $fr->setQuantity($financial['quantity']);;

            $dm->persist($fr);
        }

        foreach ($data->get('work_resource') as $work) {
            $wr = new WorkResource();

            $wr->setTitle($work['title']);
            $wr->setQuantity($work['quantity']);

            $dm->persist($wr);
        }

        $restView = View::create();
        $restView->setStatusCode(201);

        return $restView;
    }
}
