<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Type;

/**
 * Class EquipmentResource
 * @package AppBundle\Document
 *
 * @ODM\Document(collection="equipment_resource")
 * @ExclusionPolicy("all")
 */
class EquipmentResource extends AbstractResource
{
    const TON = 'ton';
    const KG = 'kg';
    const PIECE = 'piece';

    use Timestampable;

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
     * @var integer
     *
     * @ODM\Id
     * @Expose()
     * @Type("integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @Expose()
     * @Type("string")
     */
    protected $quantityType;

    /**
     * @var string $title
     *
     * @ODM\Field(type="string")
     * @Expose()
     * @Type("string")
     */
    protected $title;

    /**
     * @var float $quantity
     *
     * @ODM\Field(type="float")
     * @Expose()
     * @Type("float")
     */
    protected $quantity;

    /**
     * @var \AppBundle\Document\Dream
     *
     * @ODM\ReferenceOne(targetDocument="Dream", )
     * @Expose()
     */
    protected $dream;

    /**
     * @var array
     *
     * @ODM\ReferenceMany(targetDocument="EquipmentContribute")
     * @Expose()
     */
    protected $equipmentContributes = [];

    public function __construct()
    {
        $this->equipmentContributes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set quantityType
     *
     * @param  string $quantityType
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
     * Add equipmentContribute
     *
     * @param  EquipmentContribute $equipmentContribute
     * @return $this
     */
    public function addEquipmentContribute(\AppBundle\Document\EquipmentContribute $equipmentContribute)
    {
        $this->equipmentContributes[] = $equipmentContribute;

        return $this;
    }

    /**
     * Remove equipmentContribute
     *
     * @param  EquipmentContribute $equipmentContribute
     * @return $this
     */
    public function removeEquipmentContribute(\AppBundle\Document\EquipmentContribute $equipmentContribute)
    {
        $this->equipmentContributes->removeElement($equipmentContribute);

        return $this;
    }

    /**
     * Get equipmentContributes
     *
     * @return array|\Doctrine\Common\Collections\ArrayCollection
     */
    public function getEquipmentContributes()
    {
        return $this->equipmentContributes;
    }

    public function __toString()
    {
        return $this->getTitle();
    }
}
