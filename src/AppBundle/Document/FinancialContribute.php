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
     */
    protected $hiddenContributor;

    /**
     * @var date $createdAt
     */
    protected $createdAt;

    /**
     * @var float $quantity
     */
    protected $quantity;

    /**
     * @var \AppBundle\Document\User
     */
    protected $user;

    /**
     * @var \AppBundle\Document\Dream
     */
    protected $dream;

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
     * Set financialResource
     *
     * @param  \AppBundle\Document\FinancialResource $financialResource
     * @return self
     */
    public function setFinancialResource(\AppBundle\Document\FinancialResource $financialResource)
    {
        $this->financialResource = $financialResource;

        return $this;
    }

    /**
     * Get financialResource
     *
     * @return \AppBundle\Document\FinancialResource $financialResource
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
