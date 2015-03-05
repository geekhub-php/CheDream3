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
}