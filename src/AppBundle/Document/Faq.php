<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Type;

/**
 * Class Faq
 * @package AppBundle\Document
 *
 * @ODM\Document(collection="faq")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ExclusionPolicy("all")
 */
class Faq
{
    use Timestampable;
    /**
     * @var integer
     *
     * @ODM\Id
     * @Type("integer")
     */
    protected $id;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @Assert\NotBlank()
     * @Expose()
     * @Type("string")
     */
    protected $title;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @Assert\NotBlank()
     * @Expose()
     * @Type("string")
     */
    protected $question;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @Expose()
     * @Type("string")
     */
    protected $answer;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"title"})
     * @ODM\Field(type="string")
     * @Expose()
     * @Type("string")
     */
    protected $slug;

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
     * Set question
     *
     * @param  string $question
     * @return self
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return string $question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set answer
     *
     * @param  string $answer
     * @return self
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return string $answer
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set slug
     *
     * @param  string $slug
     * @return self
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string $slug
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
