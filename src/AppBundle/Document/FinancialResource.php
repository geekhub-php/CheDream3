<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 26.01.15
 * Time: 11:13
 */
namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Class FinancialResource
 *
 * @ODM\Document(collection="financial_resource", repositoryClass="AppBundle\Repository\CommonRepository")
 */
class FinancialResource extends AbstractResource
{
    /**
     * @var integer
     *
     * @ODM\Id
     */
    private $id;
}
