<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Type;

/**
 * @ODM\Document
 * @ODM\InheritanceType("SINGLE_COLLECTION")
 * @ODM\DiscriminatorField("type")
 * @ODM\DiscriminatorMap({"contribute" = "Contribute", "work_contribute" = "WorkContribute", "financial_contribute" = "FinancialContribute", "equipment_contribute" = "EquipmentContribute", "other_contribute" = "OtherContribute"})
 * @ExclusionPolicy("all")
 */
class Contribute
{
    /**
     * @ODM\Id(strategy="AUTO")
     * @Expose()
     */
    protected $id;

    /**
     * @ODM\ReferenceOne(targetDocument="AppBundle\Document\Dream")
     * @Expose()
     */
    protected $dream;

    /**
     * @ODM\ReferenceMany(targetDocument="AppBundle\Document\Resource")
     * @Expose()
     */
    protected $resources = [];

    /**
     * @var float $quantity
     *
     * @ODM\Field(type="float")
     * @Expose()
     * @Type("float")
     */
    protected $quantity;

    /**
     * @var boolean $hiddenContributor
     *
     * @ODM\Field(type="boolean")
     * @Expose()
     * @Type("boolean")
     */
    protected $hiddenContributor;

    /**
     * @ODM\ReferenceOne(targetDocument="AppBundle\Document\User")
     * @Expose()
     */
    protected $user;

    /**
     * @var date $createdAt
     *
     * @ODM\Field(type="date")
     * @Expose()
     * @Type("DateTime")
     */
    protected $createdAt;

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
     * @param  AppBundle\Document\Dream $dream
     * @return self
     */
    public function setDream(\AppBundle\Document\Dream $dream)
    {
        $this->dream = $dream;

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
     * @param AppBundle\Document\Resource $resource
     */
    public function addResource(\AppBundle\Document\Resource $resource)
    {
        $this->resources[] = $resource;
    }

    /**
     * Remove resource
     *
     * @param AppBundle\Document\Resource $resource
     */
    public function removeResource(\AppBundle\Document\Resource $resource)
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
     * @param  float $quantity
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
     * @param  boolean $hiddenContributor
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
     * @param  AppBundle\Document\User $user
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
     * @param  date $createdAt
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
