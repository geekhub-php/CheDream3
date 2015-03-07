<?php

namespace AppBundle\Model;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document
 * @ODM\InheritanceType("SINGLE_COLLECTION")
 * @ODM\DiscriminatorColumn(name="type", type="string")
 * @ODM\DiscriminatorMap({"resource" = "Resource", "work_resource" = "WorkResource", "financial_resource" = "FinancialResource", "equipment_resource" = "EquipmentResource"})
 */
class Resource
{
    /**
     * @ODM\Id(strategy="AUTO")
     */
    protected $id;

    /**
     * @ODM\ReferenceOne(targetDocument="AppBundle\Document\Dream")
     */
    protected $dream;

    /**
     * @ODM\ReferenceMany(targetDocument="AppBundle\Document\Contributes")
     */
    protected $contributes = [];

    /**
     * @var string $title
     *
     * @ODM\Field(type="string")
     * @Expose()
     * @Type("string")
     */
    protected $title;

    /**
     * @var date $createdAt
     *
     * @ODM\Field(type="date")
     * @Expose()
     * @Type("DateTime")
     */
    protected $createdAt;

    /**
     * @var float $quantity
     *
     * @ODM\Field(type="float")
     * @Expose()
     * @Type("float")
     */
    protected $quantity;
}