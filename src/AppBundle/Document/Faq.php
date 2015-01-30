<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;


/**
 * Faq
 *
 * @ODM\Document(collection="faq")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ExclusionPolicy("All")
 */
class Faq
{
    /**
     * @var integer
     *
     * @ODM\Id
     */
    protected $id;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $title;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @Expose()
     */
    protected $question;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $answer;

    /**
     * @var \DateTime
     *
     * @ODM\Field(type="date")
     */
    protected $deletedAt;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"title"})
     * @ODM\Field(type="string")
     */
    protected $slug;

    /**
     * Set title
     *
     * @param  string $title
     * @return Faq
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set question
     *
     * @param  string $question
     * @return Faq
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set answer
     *
     * @param  string $answer
     * @return Faq
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set deletedAt
     *
     * @param  \DateTime $deletedAt
     * @return Faq
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set slug
     *
     * @param  string $slug
     * @return Faq
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
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
}
