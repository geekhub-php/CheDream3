<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Class EquipmentResource
 *
 * @ODM\Document(collection="equipment_resource")
 */
class EquipmentResource extends AbstractResource
{
    const TON = 'ton';
    const KG = 'kg';
    const PIECE = 'piece';
    public static function getReadableQuantityTypes()
    {
        return array(
            self::PIECE => 'dream.equipment.piece',
            self::KG => 'dream.equipment.kg',
            self::TON => 'dream.equipment.ton',
        );
    }
    /**
     * @var integer
     *
     * @ODM\Id
     */
    private $id;
    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $quantityType;
    /**
     * @var string $title
     */
    protected $title;

    /**
     * @var date $createdAt
     */
    protected $createdAt;

    /**
     * @var float $quantity
     */
    protected $quantity;

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
     * Set quantityType
     *
     * @param string $quantityType
     * @return self
     */
    public function setQuantityType($quantityType)
    {
        $this->quantityType = $quantityType;
        return $this;
    }

    /**
     * Get quantityType
     *
     * @return string $quantityType
     */
    public function getQuantityType()
    {
        return $this->quantityType;
    }

    /**
     * Set title
     *
     * @param string $title
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
     * Set dream
     *
     * @param \AppBundle\Document\Dream $dream
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
