<?php

namespace AppBundle\Handler;

use Doctrine\Common\Persistence\ObjectManager;

class DreamHendler
{
    private $om;
    private $entityClass;
    private $repository;
    // ..
    public function __construct(ObjectManager $om, $entityClass)
    {
        $this->om = $om;
        $this->entityClass = $entityClass;
        $this->repository = $this->om->getRepository($this->entityClass);
    }

    public function all($limit = 5, $offset = 0, $orderby = null)
    {
        return $this->repository->findBy(array(), $orderby, $limit, $offset);
    }
}
