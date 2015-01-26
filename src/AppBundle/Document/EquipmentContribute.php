<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 25.01.15
 * Time: 20:46
 */
namespace AppBundle\Document;

use Doctrine\ORM\Mapping as ORM;use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Class EquipmentContribute
 *
 * @ODM\Document(collection="equipment_contributes", repositoryClass="AppBundle\Repository\CommonRepository")
 */
class EquipmentContribute extends AbstractContribute
{
    /**
     * @var integer
     *
     * @ODM\Id
     */
    protected $id;
    /**
     * @ODM\ManyToOne(targetEntity="EquipmentResource")
     */
    protected $equipmentResource;
}