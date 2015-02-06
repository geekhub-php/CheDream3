<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ODM\MappedSuperclass
 */
class AbstractResource extends AbstractContributeResource
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ODM\Field(type="string")
     */
    protected $title;
}
