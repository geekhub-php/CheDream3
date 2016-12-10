<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\View\View;

abstract class AbstractController extends FOSRestController
{
    public function getMongoDbManager()
    {
        return $this->get('doctrine.odm.mongodb.document_manager');
    }

    /**
     * @RestView
     *
     * @param $object
     * @return mixed
     */
    public function getValidation($object)
    {
        $validator = $this->get('validator');
        $errors = $validator->validate($object);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;

            $restView = View::create();
            $restView->setData($errorsString);
            return $restView;
        }
    }
}
