<?php

namespace AppBundle\Document;

use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Class AbstractContributeResource
 * @package AppBundle\Document
 *
 * @ODM\MappedSuperclass
 */
abstract class AbstractContributeResource
{

    /**
     * @var float
     *
     * @Assert\NotBlank
     * @Assert\GreaterThan(value = 0)
     * @ODM\Field(type="float")
     */
    protected $quantity;

    /**
     * @ODM\ReferenceOne(targetDocument="Dream")
     */
    protected $dream;
}
