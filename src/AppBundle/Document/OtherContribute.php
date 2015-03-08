<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Type;

/**
 * Class OtherContribute
 * @package AppBundle\Document
 *
 * @ODM\Document()
 * @ExclusionPolicy("all")
 */
class OtherContribute extends Contribute
{
    /**
     * @var $id
     * @ODM\Id(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $title
     *
     * @ODM\Field(type="string")
     * @Expose()
     * @Type("String")
     */
    protected $title;

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

    /**
     * Set title
     *
     * @param  string $title
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }
}
