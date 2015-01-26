<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 25.01.15
 * Time: 21:25
 */
namespace AppBundle\Document;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Class AbstractResource
 * @package AppBundle\Document
 *
 * @ODM\MappedSuperclass
 */
class AbstractResource extends AbstractContributeResource
{
     /**
     * @var string
     *
     * @Assert\NotBlank(message = "dream.not_blank")
     * @ODM\Field(length="100", type="string")
     */
    protected $title;
}