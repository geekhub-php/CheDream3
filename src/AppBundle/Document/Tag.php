<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use \FPN\TagBundle\Entity\Tag as BaseTag;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceMany;

/**
 *@ODM\Document(collection="tag", repositoryClass="AppBundle\Repository\TagRepository")
 */
class Tag extends BaseTag
{
    /**
     * @var integer
     *
     * @ODM\Id
     */
    protected $id;

    /**
     * @ReferenceMany(targetDocument="Tagging", mappedBy="tag")
     */
    protected $tagging;

}
