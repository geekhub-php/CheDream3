<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class EquipmentContribute
 *
 * @ODM\Document(collection="equipment_contributes", repositoryClass="AppBundle\Repository\CommonRepository")
 */
class EquipmentContribute extends AbstractContribute
{
    /**
     * @var integer
     *
     * @ODM\Id
     */
    protected $id;

    /**
     * @ODM\ReferenceOne(targetDocument="EquipmentResource")
     */
    protected $equipmentResource;

    /**
     * @var boolean $hiddenContributor
     *
     * @ODM\Field(type="boolean")
     */
    protected $hiddenContributor;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ODM\Field(type="date")
     */
    protected $createdAt;

    /**
     * @var float $quantity
     *
     * @ODM\Field(type="float")
     */
    protected $quantity;

    /**
     * @var \AppBundle\Document\User
     *
     * @ODM\ReferenceOne(targetDocument="User")
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
     * Set dream
     *
     * @param  Dream $dream
     * @return $this
     */
    public function setDream(\AppBundle\Document\Dream $dream)
    {
        $this->dream = $dream;

        return $this;
    }

    /**
     * Get dream
     *
     * @return mixed
     */
    public function getDream()
    {
        return $this->dream;
    }
}
