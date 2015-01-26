<?php
namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\MappedSuperclass
 */
class AbstractContribute extends AbstractContributeResource implements EventInterface
{
    /**
     * @var boolean
     *
     * @ODM\Field(type="boolean")
     */
    protected $hiddenContributor;

    /**
     * @ODM\ReferenceOne(targetDocument="AppBundle\Document\User", inversedBy="equipmentContributions")
     */
    protected $user;

    public function getEventImage()
    {
        return $this->getUser()->getAvatar();
    }

    public function getEventTitle()
    {
        return sprintf('%s %s contributed %s', $this->getUser()->getFirstName(), $this->getUser()->getLastName(), $this->getDream()->getTitle());
    }


}
