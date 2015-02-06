<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * ExportedUser
 *
 * @ODM\Document(collection="exported_user")
 * @ExclusionPolicy("all")
 */
class ExportedUser
{
    /**
     * @var integer
     *
     * @ODM\Id
     * @Expose()
     */
    private $id;

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }
}
