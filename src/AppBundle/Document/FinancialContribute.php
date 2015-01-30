<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Class FinancialContribute
 *
 * @ODM\Document(collection="financial_contributes", repositoryClass="AppBundle\Repository\CommonRepository")
 */
class FinancialContribute extends AbstractContribute
{
    /**
     * @var integer
     *
     * @ODM\Id
     */
    protected $id;

    /**
     * @ODM\ReferenceOne(targetDocument="FinancialResource")
     */
    protected $financialResource;

    /**
     * @var boolean $hiddenContributor
     *
     * @ODM\Field(type="boolean")
     */
    protected $hiddenContributor;

    /**
     * @var date $createdAt
     *
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

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

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
     * Set financialResource
     *
     * @param  FinancialResource $financialResource
     * @return $this
     */
    public function setFinancialResource(\AppBundle\Document\FinancialResource $financialResource)
    {
        $this->financialResource = $financialResource;

        return $this;
    }

    /**
     * Get financialResource
     *
     * @return mixed
     */
    public function getFinancialResource()
    {
        return $this->financialResource;
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
