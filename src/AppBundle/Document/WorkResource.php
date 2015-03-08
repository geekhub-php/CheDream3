<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * Class WorkResource
 * @package AppBundle\Document
 *
 * @ODM\Document(collection="work_resource")
 * @ExclusionPolicy("all")
 */
class WorkResource extends Resource
{
    /**
     * @var $id
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
     * @var AppBundle\Document\Dream
     */
    protected $dream;

    /**
     * @var AppBundle\Document\Contribute
     */
    protected $contributes = [];

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
