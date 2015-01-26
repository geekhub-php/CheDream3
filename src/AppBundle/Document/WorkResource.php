<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 *@ODM\Document(collection="work_resource")
 */
class WorkResource extends AbstractResource
{
    /**
     * @var integer
     *
     * @ODM\Id
     */
    protected $id;
}
