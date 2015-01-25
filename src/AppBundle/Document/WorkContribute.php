<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceOne;

/**
 *@ODM\Document(collection="work_contributes", repositoryClass="AppBundle\Repository\CommonRepository")
 */
class WorkContribute extends AbstractContribute
{
    /**
     * @var integer
     *
     * @ODM\Id
     */
    protected $id;

    /**
     * @ReferenceOne(targetDocument="WorkResource")
     */
    protected $workResource;

}
