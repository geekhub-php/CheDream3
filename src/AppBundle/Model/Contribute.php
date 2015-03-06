<?php

namespace AppBundle\Model;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document
 * @ODM\InheritanceType("SINGLE_TABLE")
 * @ODM\DiscriminatorColumn(name="discr", type="string")
 * @ODM\DiscriminatorMap({"contribute" = "Contribute", "work_contribute" = "WorkContribute", "financial_contribute" = "FinancialContribute", "equipment_contribute" = "EquipmentContribute", "other_contribute" = "OtherContribute"})
 */
class Contribute
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
     * @ODM\ReferenceMany(targetDocument="AppBundle\Document\Resource")
     */
    protected $resources;

    /**
     * @ODM\Field(type="integer")
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
     */
    protected $user;
}