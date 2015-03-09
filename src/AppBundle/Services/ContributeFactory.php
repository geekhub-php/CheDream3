<?php

namespace AppBundle\Tests\Services;

use AppBundle\Document\Dream;
use AppBundle\Document\Resource;
use AppBundle\Document\User;
use Doctrine\ODM\MongoDB\DocumentManager;
use AppBundle\Document\OtherContribute;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\SecurityContext;

class ContributeFactory
{
    /**
     * @var Dream $dream
     */
    private $dream;

    /**
     * @var Resource $resource
     */
    private $resource;

    /**
     * @var User $user
     */
    private $user;

    public function setDream(Dream $dream)
    {
        $this->dream = $dream;

        return $dream;
    }

    public function setUser(User $user)
    {
        $this->user = $user;

        return $user;
    }

    public function setResource(Resource $resource)
    {
        $this->resource = $resource;

        return $resource;
    }

    public function contribute($data)
    {
        $contribute = null;

        if (!is_null($this->resource)) {


            $type = "\\AppBundle\\Document\\".str_replace('Resource', 'Contribute', $this->resource->getType());

            $contribute = new $type();
            $contribute->setResource($this->resource);
        } else {
            $contribute = new OtherContribute();
            $contribute->setTitle($data->title);
        }

        $contribute->setDream($this->dream)
                    ->setUser($this->user)
                    ->setQuantity($data->quantity)
                    ->setHiddenContributor($data->hiddenContributor)
        ;

        return $contribute;
    }
}