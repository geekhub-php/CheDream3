<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractController extends FOSRestController
{
    public function getMongoDbManager()
    {
        return $this->get('doctrine.odm.mongodb.document_manager');
    }

    public function getValidation($object)
    {
        $validator = $this->get('validator');
        $errors = $validator->validate($object);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;

            return new Response($errorsString);
        }
    }
}
