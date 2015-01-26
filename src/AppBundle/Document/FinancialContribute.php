<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 26.01.15
 * Time: 11:10
 */
namespace AppBundle\Document;

use Doctrine\ORM\Mapping as ORM;use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Class FinancialContribute
 *
 * @ODM\Document(collection="financial_contributes", repositoryClass="AppBundle\Repository\CommonRepository")
 */
class FinancialContribute extends AbstractContribute
{
    /**
     * @var integer
     *
     * @ODM\Id
     */
    protected $id;
    /**
     * @ODM\ManyToOne(targetEntity="FinancialResource")
     */
    protected $financialResource;
}