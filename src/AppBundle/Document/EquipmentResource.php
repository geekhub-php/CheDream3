<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\MaxDepth;

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
     *
     * @ODM\Field(type="string")
     */
    protected $title;

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
     * @var \AppBundle\Document\Dream
     *
     * @ODM\ReferenceOne(targetDocument="Dream", )
     * @MaxDepth(1)
     */
    protected $dream;

    /**
     * @var array
     *
     * @ODM\ReferenceMany(targetDocument="EquipmentContribute")
     * @MaxDepth(1)
     */
    protected $equipmentContributes = array();

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
     * Set createdAt
     *
     * @param  \DateTime $createdAt
     * @return self
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime $createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    public function __construct()
    {
        $this->equipmentContributes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param AppBundle\Document\Dream $dream
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
     * @return AppBundle\Document\Dream $dream
     */
    public function getDream()
    {
        return $this->dream;
    }

    /**
     * Add equipmentContribute
     *
     * @param AppBundle\Document\EquipmentContribute $equipmentContribute
     */
    public function addEquipmentContribute(\AppBundle\Document\EquipmentContribute $equipmentContribute)
    {
        $this->equipmentContributes[] = $equipmentContribute;
    }

    /**
     * Remove equipmentContribute
     *
     * @param AppBundle\Document\EquipmentContribute $equipmentContribute
     */
    public function removeEquipmentContribute(\AppBundle\Document\EquipmentContribute $equipmentContribute)
    {
        $this->equipmentContributes->removeElement($equipmentContribute);
    }

    /**
     * Get equipmentContributes
     *
     * @return Doctrine\Common\Collections\Collection $equipmentContributes
     */
    public function getEquipmentContributes()
    {
        return $this->equipmentContributes;
    }
}
