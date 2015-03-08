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
     * @var date $createdAt
     */
    protected $createdAt;

    /**
     * @var float $quantity
     */
    protected $quantity;

    /**
     * @var AppBundle\Document\Dream
     */
    protected $dream;

    /**
     * @var AppBundle\Document\Contribute
     */
    protected $contributes = [];

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }
}
