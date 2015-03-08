<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * Class FinancialResource
 * @package AppBundle\Document
 *
 * @ODM\Document(collection="financial_resource")
 * @ExclusionPolicy("all")
 */
class FinancialResource extends Resource
{
    /**
     * @var $id
     *
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
     * @var \AppBundle\Document\Dream
     */
    protected $dream;

    /**
     * @var \AppBundle\Model\Contribute
     */
    protected $contributes = array();

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
