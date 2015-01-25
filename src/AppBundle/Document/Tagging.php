<?php

namespace AppBundle\Document;

use \FPN\TagBundle\Entity\Tagging as BaseTagging;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceOne;

/**
 *@ODM\Document(collection="tagging")
 */
class Tagging extends BaseTagging
{
    /**
     * @var integer
     *
     * @ODM\Id
     */
    protected $id;

    /**
     * @ReferenceOne(targetDocument="Tag", mappedBy="tagging")
     */
    protected $tag;

}
