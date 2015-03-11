<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
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
    use Timestampable;
    /**
     * @ODM\Id(strategy="AUTO")
     * @Expose()
     * @Type("integer")
     */
    protected $id;

    /**
     * @ODM\ReferenceOne(targetDocument="AppBundle\Document\Dream")
     * @Expose()
     * @Type("AppBundle\Document\Dream")
     */
    protected $dream;

    /**
     * @ODM\ReferenceOne(targetDocument="AppBundle\Document\Resource")
     * @Assert\NotBlank()
     * @Expose()
     * @Type("AppBundle\Document\Resource")
     */
    protected $resource;

    /**
     * @var float $quantity
     *
     * @ODM\Field(type="float")
     * @Assert\NotBlank()
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
     * @Type("AppBundle\Document\User")
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
     * Set dream
     *
     * @param  \AppBundle\Document\Dream $dream
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
     * @return \AppBundle\Document\Dream $dream
     */
    public function getDream()
    {
        return $this->dream;
    }

    /**
     * Set resource
     *
     * @param  \AppBundle\Document\Resource $resource
     * @return self
     */
    public function setResource(\AppBundle\Document\Resource $resource)
    {
        $this->resource = $resource;
        $resource->addContribute($this);

        return $this;
    }

    /**
     * Get resource
     *
     * @return \AppBundle\Document\Resource $resource
     */
    public function getResource()
    {
        return $this->resource;
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
     * @param  \AppBundle\Document\User $user
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
     * @return \AppBundle\Document\User $user
     */
    public function getUser()
    {
        return $this->user;
    }
}
