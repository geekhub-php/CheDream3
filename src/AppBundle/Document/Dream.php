<?php

namespace AppBundle\Document;

use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Class Dream
 * @package AppBundle\Document
 *
 * @ODM\Document(collection="dreams")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ExclusionPolicy("all")
 */
class Dream
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
     * Dream name
     *
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(min = "5", minMessage = "dream.min_length")
     * @ODM\Field(type="string")
     * @Expose()
     * @Type("string")
     */
    protected $title;

    /**
     * Dream description
     *
     * @var string
     *
     * @Assert\NotBlank(message = "dream.not_blank")
     * @ODM\Field(type="string")
     * @Expose()
     * @Type("string")
     */
    protected $description;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @Expose()
     * @Type("string")
     */
    protected $rejectedDescription;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @Expose()
     * @Type("string")
     */
    protected $implementedDescription;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @Expose()
     * @Type("string")
     */
    protected $completedDescription;

    /**
     * @var string
     *
     * @Assert\NotBlank(message = "dream.not_blank")
     * @Assert\Regex(pattern="/^[+0-9 ()-]+$/", message="dream.only_numbers")
     * @ODM\Field(type="string")
     * @Expose()
     * @Type("string")
     */
    protected $phone;

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
     * @var \DateTime
     *
     * @ODM\Field(type="date")
     * @Expose()
     * @Type("DateTime")
     */
    protected $expiredDate;

    /**
     * @var integer
     *
     * @ODM\Field(type="int")
     * @Expose()
     * @Type("integer")
     */
    protected $financialCompleted;

    /**
     * @var integer
     *
     * @ODM\Field(type="int")
     * @Expose()
     * @Type("integer")
     */
    protected $workCompleted;

    /**
     * @var integer
     *
     * @ODM\Field(type="int")
     * @Expose()
     * @Type("integer")
     */
    protected $equipmentCompleted;

    /**
     * @ODM\ReferenceMany(targetDocument="AppBundle\Document\User")
     * @Expose()
     * @Type("array<string, AppBundle\Document\User>")
     */
    protected $usersWhoFavorites = [];

    /**
     * @var integer
     *
     * @ODM\Field(type="int")
     * @Expose()
     * @Type("integer")
     */
    protected $favoritesCount;

    /**
     * @ODM\ReferenceOne(targetDocument="AppBundle\Document\User")
     * @Expose()
     * @Type("string")
     */
    protected $author;

    /**
     * @ODM\ReferenceMany(targetDocument="Status", cascade={"persist"})
     */
    protected $statuses = [];

    /**
     * @ODM\Field(type="string")
     * @Expose()
     * @Type("string")
     */
    protected $currentStatus;

    /**
     * @ODM\ReferenceMany(targetDocument="Application\Sonata\MediaBundle\Document\Media")
     */
    protected $mediaPictures = [];

    /**
     * @ODM\ReferenceMany(targetDocument="Application\Sonata\MediaBundle\Document\Media")
     */
    protected $mediaCompletedPictures;
//
//    /**
//     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media")
//     */
//    protected $mediaPoster;
//
//    /**
//     * @ORM\ManyToMany(targetEntity="Application\Sonata\MediaBundle\Entity\Media")
//     * @ORM\JoinTable(name="mediaFiles_media")
//     */
//    protected $mediaFiles;
//
//    /**
//     * @ORM\ManyToMany(targetEntity="Application\Sonata\MediaBundle\Entity\Media")
//     * @ORM\JoinTable(name="mediaVideos_media")
//     */
//    protected $mediaVideos;

//    protected $dreamPictures;
//    protected $dreamPoster;
//    protected $dreamFiles;
//    protected $dreamVideos;

    /**
     * @var array
     *
     * @ODM\ReferenceMany(targetDocument="AppBundle\Document\Contribute")
     * @Expose()
     * @Type("array<AppBundle\Document\Contribute>")
     */
    protected $contributes = [];

    /**
     * @var array
     *
     * @ODM\ReferenceMany(targetDocument="AppBundle\Document\Resource")
     * @Expose()
     * @Type("array<AppBundle\Document\Resource>")
     */
    protected $resources = [];

    public function __construct()
    {
        $this->usersWhoFavorites = new \Doctrine\Common\Collections\ArrayCollection();
        $this->statuses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->contributes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->resources = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set description
     *
     * @param  string $description
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set rejectedDescription
     *
     * @param  string $rejectedDescription
     * @return self
     */
    public function setRejectedDescription($rejectedDescription)
    {
        $this->rejectedDescription = $rejectedDescription;

        return $this;
    }

    /**
     * Get rejectedDescription
     *
     * @return string $rejectedDescription
     */
    public function getRejectedDescription()
    {
        return $this->rejectedDescription;
    }

    /**
     * Set implementedDescription
     *
     * @param  string $implementedDescription
     * @return self
     */
    public function setImplementedDescription($implementedDescription)
    {
        $this->implementedDescription = $implementedDescription;

        return $this;
    }

    /**
     * Get implementedDescription
     *
     * @return string $implementedDescription
     */
    public function getImplementedDescription()
    {
        return $this->implementedDescription;
    }

    /**
     * Set completedDescription
     *
     * @param  string $completedDescription
     * @return self
     */
    public function setCompletedDescription($completedDescription)
    {
        $this->completedDescription = $completedDescription;

        return $this;
    }

    /**
     * Get completedDescription
     *
     * @return string $completedDescription
     */
    public function getCompletedDescription()
    {
        return $this->completedDescription;
    }

    /**
     * Set phone
     *
     * @param  string $phone
     * @return self
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string $phone
     */
    public function getPhone()
    {
        return $this->phone;
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

    /**
     * Set expiredDate
     *
     * @param  date $expiredDate
     * @return self
     */
    public function setExpiredDate($expiredDate)
    {
        $this->expiredDate = $expiredDate;

        return $this;
    }

    /**
     * Get expiredDate
     *
     * @return date $expiredDate
     */
    public function getExpiredDate()
    {
        return $this->expiredDate;
    }

    /**
     * Set financialCompleted
     *
     * @param  int  $financialCompleted
     * @return self
     */
    public function setFinancialCompleted($financialCompleted)
    {
        $this->financialCompleted = $financialCompleted;

        return $this;
    }

    /**
     * Get financialCompleted
     *
     * @return int $financialCompleted
     */
    public function getFinancialCompleted()
    {
        return $this->financialCompleted;
    }

    /**
     * Set workCompleted
     *
     * @param  int  $workCompleted
     * @return self
     */
    public function setWorkCompleted($workCompleted)
    {
        $this->workCompleted = $workCompleted;

        return $this;
    }

    /**
     * Get workCompleted
     *
     * @return int $workCompleted
     */
    public function getWorkCompleted()
    {
        return $this->workCompleted;
    }

    /**
     * Set equipmentCompleted
     *
     * @param  int  $equipmentCompleted
     * @return self
     */
    public function setEquipmentCompleted($equipmentCompleted)
    {
        $this->equipmentCompleted = $equipmentCompleted;

        return $this;
    }

    /**
     * Get equipmentCompleted
     *
     * @return int $equipmentCompleted
     */
    public function getEquipmentCompleted()
    {
        return $this->equipmentCompleted;
    }

    /**
     * Add usersWhoFavorite
     *
     * @param \AppBundle\Document\User $usersWhoFavorite
     */
    public function addUsersWhoFavorite(\AppBundle\Document\User $usersWhoFavorite)
    {
        $this->usersWhoFavorites[] = $usersWhoFavorite;
    }

    /**
     * Remove usersWhoFavorite
     *
     * @param \AppBundle\Document\User $usersWhoFavorite
     */
    public function removeUsersWhoFavorite(\AppBundle\Document\User $usersWhoFavorite)
    {
        $this->usersWhoFavorites->removeElement($usersWhoFavorite);
    }

    /**
     * Get usersWhoFavorites
     *
     * @return \Doctrine\Common\Collections\Collection $usersWhoFavorites
     */
    public function getUsersWhoFavorites()
    {
        return $this->usersWhoFavorites;
    }

    /**
     * Set favoritesCount
     *
     * @param  int  $favoritesCount
     * @return self
     */
    public function setFavoritesCount($favoritesCount)
    {
        $this->favoritesCount = $favoritesCount;

        return $this;
    }

    /**
     * Get favoritesCount
     *
     * @return int $favoritesCount
     */
    public function getFavoritesCount()
    {
        return $this->favoritesCount;
    }

    /**
     * Set author
     *
     * @param  \AppBundle\Document\User $author
     * @return self
     */
    public function setAuthor(\AppBundle\Document\User $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \AppBundle\Document\User $author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Add status
     *
     * @param \AppBundle\Document\Status $status
     */
    public function addStatus(\AppBundle\Document\Status $status)
    {
        $this->statuses[] = $status;
    }

    /**
     * Remove status
     *
     * @param \AppBundle\Document\Status $status
     */
    public function removeStatus(\AppBundle\Document\Status $status)
    {
        $this->statuses->removeElement($status);
    }

    /**
     * Get statuses
     *
     * @return \Doctrine\Common\Collections\Collection $statuses
     */
    public function getStatuses()
    {
        return $this->statuses;
    }

    /**
     * Set currentStatus
     *
     * @param  string $currentStatus
     * @return self
     */
    public function setCurrentStatus($currentStatus)
    {
        $this->currentStatus = $currentStatus;

        return $this;
    }

    /**
     * Get currentStatus
     *
     * @return string $currentStatus
     */
    public function getCurrentStatus()
    {
        return $this->currentStatus;
    }

    /**
     * Add contribute
     *
     * @param \AppBundle\Document\Contribute $contribute
     */
    public function addContribute(\AppBundle\Document\Contribute $contribute)
    {
        $this->contributes[] = $contribute;
        $contribute->setDream($this);

        return $this;
    }

    /**
     * Remove contribute
     *
     * @param \AppBundle\Document\Contribute $contribute
     */
    public function removeContribute(\AppBundle\Document\Contribute $contribute)
    {
        $this->contributes->removeElement($contribute);
    }

    /**
     * Get contributes
     *
     * @return \Doctrine\Common\Collections\Collection $contributes
     */
    public function getContributes()
    {
        return $this->contributes;
    }

    /**
     * Add resource
     *
     * @param \AppBundle\Document\Resource $resource
     */
    public function addResource(\AppBundle\Document\Resource $resource)
    {
        $this->resources[] = $resource;
        $resource->setDream($this);

        return $this;
    }

    /**
     * Remove resource
     *
     * @param \AppBundle\Document\Resource $resource
     */
    public function removeResource(\AppBundle\Document\Resource $resource)
    {
        $this->resources->removeElement($resource);
    }

    /**
     * Get resources
     *
     * @return \Doctrine\Common\Collections\Collection $resources
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * Add mediaPicture.
     *
     * @param \Application\Sonata\MediaBundle\Document\Media $mediaPicture
     */
    public function addMediaPicture(\Application\Sonata\MediaBundle\Document\Media $mediaPicture)
    {
        $this->mediaPictures[] = $mediaPicture;
    }

    /**
     * Remove mediaPicture.
     *
     * @param \Application\Sonata\MediaBundle\Document\Media $mediaPicture
     */
    public function removeMediaPicture(\Application\Sonata\MediaBundle\Document\Media $mediaPicture)
    {
        $this->mediaPictures->removeElement($mediaPicture);
    }

    /**
     * Get mediaPictures.
     *
     * @return \Doctrine\Common\Collections\Collection $mediaPictures
     */
    public function getMediaPictures()
    {
        return $this->mediaPictures;
    }

    /**
     * Add mediaCompletedPicture.
     *
     * @param \Application\Sonata\MediaBundle\Document\Media $mediaCompletedPicture
     */
    public function addMediaCompletedPicture(\Application\Sonata\MediaBundle\Document\Media $mediaCompletedPicture)
    {
        $this->mediaCompletedPictures[] = $mediaCompletedPicture;
    }

    /**
     * Remove mediaCompletedPicture.
     *
     * @param \Application\Sonata\MediaBundle\Document\Media $mediaCompletedPicture
     */
    public function removeMediaCompletedPicture(\Application\Sonata\MediaBundle\Document\Media $mediaCompletedPicture)
    {
        $this->mediaCompletedPictures->removeElement($mediaCompletedPicture);
    }

    /**
     * Get mediaCompletedPictures.
     *
     * @return \Doctrine\Common\Collections\Collection $mediaCompletedPictures
     */
    public function getMediaCompletedPictures()
    {
        return $this->mediaCompletedPictures;
    }

    public function __toString()
    {
        return $this->getTitle();
    }
}
