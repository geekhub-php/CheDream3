<?php
namespace Geekhub\UserBundle\Entity;

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
}
