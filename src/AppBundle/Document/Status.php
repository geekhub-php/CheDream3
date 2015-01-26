<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Status
 *
 * @ODM\Document(collection="status", repositoryClass="AppBundle\Repository\CommonRepository")
 */
class Status implements EventInterface
{
    const SUBMITTED            = 'submitted';
    const REJECTED             = 'rejected';
    const COLLECTING_RESOURCES = 'collecting-resources';
    const IMPLEMENTING         = 'implementing';
    const COMPLETED            = 'completed';
    const SUCCESS              = 'success';
    const FAIL                 = 'fail';

    /**
     * @var integer
     *
     * @ODM\Id
     */
    protected $id;

    /**
     * @var    string
     * @return string
     *
     * @ODM\Field(type="string")
     */
    protected $title;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ODM\Field(type="date")
     */
    protected $createdAt;

    /**
     * @ODM\ReferenceOne(targetDocument="Dream", inversedBy="statuses")
     */
    protected $dream;

    /**
     * Set createdAt
     *
     * @param  \DateTime $createdAt
     * @return Status
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getEventImage()
    {
        return $this->getDream()->getMediaPoster();
    }

    public function getEventTitle()
    {
        return sprintf('Dream "%s", has changed status to "%s"', $this->getDream()->getTitle(), $this->getTitle());
    }

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set dream
     *
     * @param \AppBundle\Document\Dream $dream
     * @return self
     */
    public function setDream(\AppBundle\Document\Dream $dream)
    {
        $this->dream = $dream;
        return $this;
    }

    /**
     * Get dream
     *
     * @return \AppBundle\Document\Dream $dream
     */
    public function getDream()
    {
        return $this->dream;
    }
}
