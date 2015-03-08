<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * Class EquipmentContribute
 * @package AppBundle\Document
 *
 * @ODM\Document()
 * @ExclusionPolicy("all")
 */
class EquipmentContribute extends Contribute
{
    /**
     * @var $id
     * @ODM\Id(strategy="AUTO")
     */
    protected $id;

    /**
     * @var float $quantity
     */
    protected $quantity;

    /**
     * @var boolean $hiddenContributor
     */
    protected $hiddenContributor;

    /**
     * @var date $createdAt
     */
    protected $createdAt;

    /**
     * @var AppBundle\Document\Dream
     */
    protected $dream;

    /**
     * @var AppBundle\Document\Resource
     */
    protected $resources = array();

    /**
     * @var AppBundle\Document\User
     */
    protected $user;

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
