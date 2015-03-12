<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Type;

/**
 * Class Status
 * @package AppBundle\Document
 *
 * @ODM\Document(collection="status")
 * @ExclusionPolicy("all")
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

    use Timestampable;
    /**
     * @var integer
     *
     * @ODM\Id
     * @Expose()
     * @Type("integer")
     */
    protected $id;

    /**
     * @var    string
     * @return string
     *
     * @ODM\Field(type="string")
     * @Assert\NotBlank()
     * @Expose()
     * @Type("string")
     */
    protected $title;

    /**
     * @ODM\ReferenceOne(targetDocument="Dream")
     * @Expose()
     */
    protected $dream;

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
     * @param  string $title
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
     * @param  Dream $dream
     * @return $this
     */
    public function setDream(\AppBundle\Document\Dream $dream)
    {
        $this->dream = $dream;

        return $this;
    }

    /**
     * Set dream
     *
     * @return mixed
     */
    public function getDream()
    {
        return $this->dream;
    }

    public function __toString()
    {
        return $this->getTitle();
    }

    public static function getStatusesArray()
    {
        return array(
            self::SUBMITTED => self::SUBMITTED,
            self::COLLECTING_RESOURCES => self::COLLECTING_RESOURCES,
            self::REJECTED => self::REJECTED,
            self::IMPLEMENTING => self::IMPLEMENTING,
            self::COMPLETED => self::COMPLETED,
            self::SUCCESS => self::SUCCESS,
            self::FAIL => self::FAIL,
        );
    }
    /**
     * @var date $createdAt
     */
    protected $createdAt;

    /**
     * @var date $updatedAt
     */
    protected $updatedAt;

    /**
     * @var date $deletedAt
     */
    protected $deletedAt;

    /**
     * Set createdAt
     *
     * @param  date $createdAt
     * @return self
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return date $createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param  date $updatedAt
     * @return self
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return date $updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set deletedAt
     *
     * @param  date $deletedAt
     * @return self
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return date $deletedAt
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }
}
