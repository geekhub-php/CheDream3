<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Class FinancialResource
 *
 * @ODM\Document(collection="financial_resource")
 * @ExclusionPolicy("all")
 */
class FinancialResource extends AbstractResource
{
    /**
     * @var integer
     *
     * @ODM\Id
     * @Expose()
     */
    private $id;

    /**
     * @var string $title
     *
     * @ODM\Field(type="string")
     * @Expose()
     */
    protected $title;

    /**
     * @var date $createdAt
     *
     * @ODM\Field(type="date")
     * @Expose()
     */
    protected $createdAt;

    /**
     * @var float $quantity
     *
     * @ODM\Field(type="float")
     * @Expose()
     */
    protected $quantity;

    /**
     * @var \AppBundle\Document\Dream
     *
     * @ODM\ReferenceOne(targetDocument="Dream")
     * @Expose()
     */
    protected $dream;

    /**
     * @var array
     *
     * @ODM\ReferenceMany(targetDocument="FinancialContribute")
     * @Expose()
     */
    protected $financialContributes = [];

    public function __construct()
    {
        $this->financialContributes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Dream
     */
    public function getDream()
    {
        return $this->dream;
    }

    /**
     * Add financialContribute
     *
     * @param  FinancialContribute $financialContribute
     * @return $this
     */
    public function addFinancialContribute(\AppBundle\Document\FinancialContribute $financialContribute)
    {
        $this->financialContributes[] = $financialContribute;

        return $this;
    }

    /**
     * Remove financial contribute
     *
     * @param  FinancialContribute $financialContribute
     * @return $this
     */
    public function removeFinancialContribute(\AppBundle\Document\FinancialContribute $financialContribute)
    {
        $this->financialContributes->removeElement($financialContribute);

        return $this;
    }

    /**
     * Get financialContributes
     *
     * @return array|\Doctrine\Common\Collections\ArrayCollection
     */
    public function getFinancialContributes()
    {
        return $this->financialContributes;
    }
}
