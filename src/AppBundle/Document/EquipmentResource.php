<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 25.01.15
 * Time: 20:58
 */
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
}
