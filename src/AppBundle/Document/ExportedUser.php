<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * ExportedUser
 *
 * @ODM\Document(collection="exported_user")
 */
class ExportedUser
{
    /**
     * @var integer
     *
     * @ODM\Id
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
