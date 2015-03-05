<?php

namespace AppBundle\Model;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document
 * @ODM\InheritanceType("SINGLE_TABLE")
 * @ODM\DiscriminatorColumn(name="discr", type="string")
 * @ODM\DiscriminatorMap({"resource" = "Resource", "work_resource" = "WorkResource", "financial_resource" = "FinancialResource", "equipment_resource" = "EquipmentResource"})
 */
class Resource
{
    /**
     * @ODM\Id(strategy="AUTO")
     */
    protected $id;
}