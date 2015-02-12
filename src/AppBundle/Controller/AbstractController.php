<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

class AbstractController extends FOSRestController
{
    public function getMongoDbManager()
    {
        return $this->get('doctrine.odm.mongodb.document_manager');
    }
}