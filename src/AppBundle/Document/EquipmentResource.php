<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * Class EquipmentResource
 * @package AppBundle\Document
 *
 * @ODM\Document(collection="equipment_resource")
 * @ExclusionPolicy("all")
 */
class EquipmentResource extends Resource
{
    const TON = 'ton';
    const KG = 'kg';
    const PIECE = 'piece';

    /**
     * @return array
     */
    public static function getReadableQuantityTypes()
    {
        return array(
            self::PIECE => 'dream.equipment.piece',
            self::KG => 'dream.equipment.kg',
            self::TON => 'dream.equipment.ton',
        );
    }

    /**
     * @var $id
     * @ODM\Id(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $title
     */
    protected $title;

    /**
     * @var float $quantity
     */
    protected $quantity;

    /**
     * @var \AppBundle\Document\Dream
     */
    protected $dream;

    /**
     * @var \AppBundle\Document\Contribute
     */
    protected $contributes = array();

    public function __construct()
    {
        $this->contributes = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Add contribute
     *
     * @param \AppBundle\Document\Contribute $contribute
     */
    public function addContribute(\AppBundle\Document\Contribute $contribute)
    {
        $this->contributes[] = $contribute;
    }

    /**
     * Remove contribute
     *
     * @param \AppBundle\Document\Contribute $contribute
     */
    public function removeContribute(\AppBundle\Document\Contribute $contribute)
    {
        $this->contributes->removeElement($contribute);
    }

    /**
     * Get contributes
     *
     * @return \Doctrine\Common\Collections\Collection $contributes
     */
    public function getContributes()
    {
        return $this->contributes;
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

    public function __toString()
    {
        return $this->getTitle();
    }
}
