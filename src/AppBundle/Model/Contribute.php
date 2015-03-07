<?php

namespace AppBundle\Model;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Type;

/**
 * @ODM\Document
 * @ODM\InheritanceType("SINGLE_COLLECTION")
 * @ODM\DiscriminatorField(name="type", type="string")
 * @ODM\DiscriminatorMap({"contribute" = "Contribute", "work_contribute" = "WorkContribute", "financial_contribute" = "FinancialContribute", "equipment_contribute" = "EquipmentContribute", "other_contribute" = "OtherContribute"})
 * @ExclusionPolicy("all")
 */
class Contribute
{
    /**
     * @ODM\Id(strategy="AUTO")
     * @Expose()
     */
    protected $id;

    /**
     * @ODM\ReferenceOne(targetDocument="AppBundle\Document\Dream")
     * @Expose()
     */
    protected $dream;

    /**
     * @ODM\ReferenceMany(targetDocument="AppBundle\Model\Resource")
     * @Expose()
     */
    protected $resources = [];

    /**
     * @var float $quantity
     *
     * @ODM\Field(type="float")
     * @Expose()
     * @Type("float")
     */
    protected $quantity;

    /**
     * @var boolean $hiddenContributor
     *
     * @ODM\Field(type="boolean")
     * @Expose()
     * @Type("boolean")
     */
    protected $hiddenContributor;

    /**
     * @ODM\ReferenceOne(targetDocument="AppBundle\Document\User")
     * @Expose()
     */
    protected $user;

    /**
     * @var date $createdAt
     *
     * @ODM\Field(type="date")
     * @Expose()
     * @Type("DateTime")
     */
    protected $createdAt;
}