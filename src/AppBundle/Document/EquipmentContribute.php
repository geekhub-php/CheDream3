<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Type;

/**
 * Class EquipmentContribute
 * @package AppBundle\Document
 *
 * @ODM\Document(collection="equipment_contributes")
 * @ExclusionPolicy("all")
 */
class EquipmentContribute extends AbstractContribute
{
    /**
     * @var integer
     *
     * @ODM\Id
     * @Expose()
     * @Type("integer")
     */
    protected $id;

    /**
     * @ODM\ReferenceOne(targetDocument="AppBundle\Document\EquipmentResource")
     * @Expose()
     */
    protected $equipmentResource;

    /**
     * @var boolean $hiddenContributor
     *
     * @ODM\Field(type="boolean")
     * @Expose()
     * @Type("boolean")
     */
    protected $hiddenContributor;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ODM\Field(type="date")
     * @Expose()
     * @Type("DateTime")
     */
    protected $createdAt;

    /**
     * @var float $quantity
     *
     * @ODM\Field(type="float")
     * @Expose()
     * @Type("float")
     */
    protected $quantity;

    /**
     * @var \AppBundle\Document\User
     *
     * @ODM\ReferenceOne(targetDocument="User")
     * @Expose()
     */
    protected $user;

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
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
     * set EquipmentResource
     *
     * @param  EquipmentResource $equipmentResource
     * @return $this
     */
    public function setEquipmentResource(\AppBundle\Document\EquipmentResource $equipmentResource)
    {
        $this->equipmentResource = $equipmentResource;
        $equipmentResource->addEquipmentContribute($this);

        return $this;
    }

    /**
     * Get equipmentResource
     *
     * @return mixed
     */
    public function getEquipmentResource()
    {
        return $this->equipmentResource;
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
     * Set user
     *
     * @param  User  $user
     * @return $this
     */
    public function setUser(\AppBundle\Document\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * @var \AppBundle\Document\Dream
     */
    protected $dream;

    /**
     * Set dream
     *
     * @param  \AppBundle\Document\Dream $dream
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
     * @return \AppBundle\Document\Dream $dream
     */
    public function getDream()
    {
        return $this->dream;
    }
}
