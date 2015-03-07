<?php

namespace AppBundle\Document;

use AppBundle\Model\Contribute;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Gedmo\Mapping\Annotation as Gedmo;
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
     * @var AppBundle\Model\Resource
     */
    protected $resources = array();

    /**
     * @var AppBundle\Document\User
     */
    protected $user;

    public function __construct()
    {
        $this->resources = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set dream
     *
     * @param AppBundle\Document\Dream $dream
     * @return self
     */
    public function setDream(\AppBundle\Document\Dream $dream)
    {
        $this->dream = $dream;
        $dream->addContribute($this);

        return $this;
    }

    /**
     * Get dream
     *
     * @return AppBundle\Document\Dream $dream
     */
    public function getDream()
    {
        return $this->dream;
    }

    /**
     * Add resource
     *
     * @param \AppBundle\Model\Resource $resource
     */
    public function addResource(\AppBundle\Model\Resource $resource)
    {
        $this->resources[] = $resource;
        $resource->addContribute($this);

        return $this;
    }

    /**
     * Remove resource
     *
     * @param AppBundle\Model\Resource $resource
     */
    public function removeResource(\AppBundle\Model\Resource $resource)
    {
        $this->resources->removeElement($resource);
    }

    /**
     * Get resources
     *
     * @return Doctrine\Common\Collections\Collection $resources
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * Set quantity
     *
     * @param float $quantity
     * @return self
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * Get quantity
     *
     * @return float $quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set hiddenContributor
     *
     * @param boolean $hiddenContributor
     * @return self
     */
    public function setHiddenContributor($hiddenContributor)
    {
        $this->hiddenContributor = $hiddenContributor;
        return $this;
    }

    /**
     * Get hiddenContributor
     *
     * @return boolean $hiddenContributor
     */
    public function getHiddenContributor()
    {
        return $this->hiddenContributor;
    }

    /**
     * Set user
     *
     * @param AppBundle\Document\User $user
     * @return self
     */
    public function setUser(\AppBundle\Document\User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get user
     *
     * @return AppBundle\Document\User $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set createdAt
     *
     * @param date $createdAt
     * @return self
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return date $createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
