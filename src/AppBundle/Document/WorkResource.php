<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 *@ODM\Document(collection="work_resource")
 * @ExclusionPolicy("all")
 */
class WorkResource extends AbstractResource
{
    /**
     * @var integer
     *
     * @ODM\Id
     * @Expose()
     */
    protected $id;

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
     * @ODM\ReferenceOne(targetDocument="Dream")
     * @Expose()
     */
    protected $dream;

    /**
     * @var array
     *
     * @ODM\ReferenceMany(targetDocument="WorkContribute")
     * @Expose()
     */
    protected $workContributions = [];

    public function __construct()
    {
        $this->workContributions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * set dream
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
     * Get Dream
     *
     * @return Dream
     */
    public function getDream()
    {
        return $this->dream;
    }

    /**
     * Add workContribution
     *
     * @param  WorkContribute $workContribution
     * @return $this
     */
    public function addWorkContribution(\AppBundle\Document\WorkContribute $workContribution)
    {
        $this->workContributions[] = $workContribution;

        return $this;

    }

    /**
     * Remove workContribution
     *
     * @param  WorkContribute $workContribution
     * @return $this
     */
    public function removeWorkContribution(\AppBundle\Document\WorkContribute $workContribution)
    {
        $this->workContributions->removeElement($workContribution);

        return $this;

    }

    /**
     * Get workContributions
     *
     * @return array|\Doctrine\Common\Collections\ArrayCollection
     */
    public function getWorkContributions()
    {
        return $this->workContributions;
    }
}
