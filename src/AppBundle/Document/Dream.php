<?php

namespace AppBundle\Document;

use Gedmo\Mapping\Annotation as Gedmo;;
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
    /**
     * @var integer
     *
     * @ODM\Id
     * @Expose()
     * @Type("integer")
     */
    protected $id;

    /**
     * @var string
     *
     * @Assert\NotBlank(message = "dream.not_blank")
     * @Assert\Length(min = "5", minMessage = "dream.min_length")
     * @ODM\Field(type="string")
     * @Expose()
     * @Type("string")
     */
    protected $title;

    /**
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
     * @Type("string")
     */
    protected $rejectedDescription;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @Type("string")
     */
    protected $implementedDescription;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
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
     * @Gedmo\Timestampable(on="create")
     * @ODM\Field(type="date")
     * @Type("DateTime")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ODM\Field(type="date")
     * @Type("DateTime")
     */
    protected $updatedAt;

    /**
     * @var \DateTime
     *
     * @ODM\Field(type="date")
     * @Type("DateTime")
     */
    protected $deletedAt;

    /**
     * @var \DateTime
     *
     * @ODM\Field(type="date")
     * @Type("DateTime")
     */
    protected $expiredDate;

    /**
     * @var integer
     *
     * @ODM\Field(type="int")
     * @Type("integer")
     */
    protected $financialCompleted;

    /**
     * @var integer
     *
     * @ODM\Field(type="int")
     * @Type("integer")
     */
    protected $workCompleted;

    /**
     * @var integer
     *
     * @ODM\Field(type="int")
     * @Type("integer")
     */
    protected $equipmentCompleted;

    protected $tags;

    /**
     * @ODM\ReferenceMany(targetDocument="User")
     * @Type("array<string, User>")
     */
    protected $usersWhoFavorites = [];

    /**
     * @var integer
     *
     * @ODM\Field(type="int")
     * @Type("integer")
     */
    protected $favoritesCount;

    /**
     * @ODM\ReferenceOne(targetDocument="User")
     * @Type("string")
     */
    protected $author;

    /**
     * @ODM\ReferenceMany(targetDocument="Status", cascade={"persist"})
     */
    protected $statuses = [];

    /**
     * @ODM\Field(type="string")
     * @Type("string")
     */
    protected $currentStatus;

//    /**
//     * @ODM\ManyToMany(targetEntity="Application\Sonata\MediaBundle\Entity\Media")
//     */
//    protected $mediaPictures;

//    /**
//     * @ODM\ReferenceMany(targetDocument="Application\Sonata\MediaBundle\Entity\Media")
//     */
////    protected $mediaCompletedPictures;
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

    protected $dreamPictures;
    protected $dreamPoster;
    protected $dreamFiles;
    protected $dreamVideos;

    /**
     * @ODM\ReferenceMany(targetDocument="FinancialResource", cascade={"persist"})
     * @Type("array<string, FinancialResource>")
     */
    protected $dreamFinancialResources;

    /**
     * @ODM\ReferenceMany(targetDocument="EquipmentResource", cascade={"persist"})
     * @Type("array<string, EquipmentResource>")
     */
    protected $dreamEquipmentResources;

    /**
     * @ODM\ReferenceMany(targetDocument="WorkResource", cascade={"persist"})
     * @Type("array<string, WorkResource>")
     */
    protected $dreamWorkResources;

    /**
     * @ODM\ReferenceMany(targetDocument="FinancialContribute")
     * @Type("array<string, FinancialContribute>")
     */
    protected $dreamFinancialContributions;

    /**
     * @ODM\ReferenceMany(targetDocument="EquipmentContribute")
     * @Type("array<string, EquipmentContribute>")
     */
    protected $dreamEquipmentContributions;

    /**
     * @ODM\ReferenceMany(targetDocument="WorkContribute")
     * @Type("array<string, WorkContribute>")
     */
    protected $dreamWorkContributions;

    /**
     * @ODM\ReferenceMany(targetDocument="OtherContribute")
     * @Type("array<string, OtherContribute>")
     */
    protected $dreamOtherContributions;

    public function __construct()
    {
        $this->usersWhoFavorites = new \Doctrine\Common\Collections\ArrayCollection();
        $this->statuses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dreamFinancialResources = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dreamEquipmentResources = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dreamWorkResources = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dreamFinancialContributions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dreamEquipmentContributions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dreamWorkContributions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dreamOtherContributions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * add UsersWhoFavorite
     *
     * @param  User  $usersWhoFavorite
     * @return $this
     */
    public function addUsersWhoFavorite(\AppBundle\Document\User $usersWhoFavorite)
    {
        $this->usersWhoFavorites[] = $usersWhoFavorite;

        return $this;
    }

    /**
     * Remove usersWhoFavorite
     *
     * @param  User  $usersWhoFavorite
     * @return $this
     */
    public function removeUsersWhoFavorite(\AppBundle\Document\User $usersWhoFavorite)
    {
        $this->usersWhoFavorites->removeElement($usersWhoFavorite);

        return $this;
    }

    /**
     * Get usersWhoFavorites
     *
     * @return array|\Doctrine\Common\Collections\ArrayCollection
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
     * @param  User  $author
     * @return $this
     */
    public function setAuthor(\AppBundle\Document\User $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Add status
     *
     * @param  Status $status
     * @return $this
     */
    public function addStatus(\AppBundle\Document\Status $status)
    {
        $this->statuses[] = $status;

        return $this;
    }

    /**
     * Remove status
     *
     * @param  Status $status
     * @return $this
     */
    public function removeStatus(\AppBundle\Document\Status $status)
    {
        $this->statuses->removeElement($status);

        return $this;
    }

    /**
     * Get statuses
     *
     * @return array|\Doctrine\Common\Collections\ArrayCollection
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
     * Add dreamFinancialResource
     *
     * @param  FinancialResource $dreamFinancialResource
     * @return $this
     */
    public function addDreamFinancialResource(\AppBundle\Document\FinancialResource $dreamFinancialResource)
    {
        $this->dreamFinancialResources[] = $dreamFinancialResource;

        return $this;
    }

    /**
     * Remove dreamFinancialResource
     *
     * @param  FinancialResource $dreamFinancialResource
     * @return $this
     */
    public function removeDreamFinancialResource(\AppBundle\Document\FinancialResource $dreamFinancialResource)
    {
        $this->dreamFinancialResources->removeElement($dreamFinancialResource);

        return $this;
    }

    /**
     * Get dreamFinancialResources
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getDreamFinancialResources()
    {
        return $this->dreamFinancialResources;
    }

    /**
     * Add dreamEquipmentResource
     *
     * @param  EquipmentResource $dreamEquipmentResource
     * @return $this
     */
    public function addDreamEquipmentResource(\AppBundle\Document\EquipmentResource $dreamEquipmentResource)
    {
        $this->dreamEquipmentResources[] = $dreamEquipmentResource;

        return $this;
    }

    /**
     * Remove dreamEquipmentResource
     *
     * @param  EquipmentResource $dreamEquipmentResource
     * @return $this
     */
    public function removeDreamEquipmentResource(\AppBundle\Document\EquipmentResource $dreamEquipmentResource)
    {
        $this->dreamEquipmentResources->removeElement($dreamEquipmentResource);

        return $this;
    }

    /**
     * Get dreamEquipmentResources
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getDreamEquipmentResources()
    {
        return $this->dreamEquipmentResources;
    }

    /**
     * Add dreamWorkResource
     *
     * @param  WorkResource $dreamWorkResource
     * @return $this
     */
    public function addDreamWorkResource(\AppBundle\Document\WorkResource $dreamWorkResource)
    {
        $this->dreamWorkResources[] = $dreamWorkResource;

        return $this;
    }

    /**
     * Remove dreamWorkResource
     *
     * @param  WorkResource $dreamWorkResource
     * @return $this
     */
    public function removeDreamWorkResource(\AppBundle\Document\WorkResource $dreamWorkResource)
    {
        $this->dreamWorkResources->removeElement($dreamWorkResource);

        return $this;
    }

    /**
     * Get dreamWorkResources
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getDreamWorkResources()
    {
        return $this->dreamWorkResources;
    }

    /**
     * Add dreamFinancialContribution
     *
     * @param  FinancialContribute $dreamFinancialContribution
     * @return $this
     */
    public function addDreamFinancialContribution(\AppBundle\Document\FinancialContribute $dreamFinancialContribution)
    {
        $this->dreamFinancialContributions[] = $dreamFinancialContribution;

        return $this;
    }

    /**
     * Remove dreamFinancialContribution
     *
     * @param  FinancialContribute $dreamFinancialContribution
     * @return $this
     */
    public function removeDreamFinancialContribution(\AppBundle\Document\FinancialContribute $dreamFinancialContribution)
    {
        $this->dreamFinancialContributions->removeElement($dreamFinancialContribution);

        return $this;
    }

    /**
     * Get dreamFinancialContributions
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getDreamFinancialContributions()
    {
        return $this->dreamFinancialContributions;
    }

    /**
     * Add dreamEquipmentContribution
     *
     * @param  EquipmentContribute $dreamEquipmentContribution
     * @return $this
     */
    public function addDreamEquipmentContribution(\AppBundle\Document\EquipmentContribute $dreamEquipmentContribution)
    {
        $this->dreamEquipmentContributions[] = $dreamEquipmentContribution;

        return $this;
    }

    /**
     * Remove dreamEquipmentContribution
     *
     * @param  EquipmentContribute $dreamEquipmentContribution
     * @return $this
     */
    public function removeDreamEquipmentContribution(\AppBundle\Document\EquipmentContribute $dreamEquipmentContribution)
    {
        $this->dreamEquipmentContributions->removeElement($dreamEquipmentContribution);

        return $this;
    }

    /**
     * Get dreamEquipmentContributions
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getDreamEquipmentContributions()
    {
        return $this->dreamEquipmentContributions;
    }

    /**
     * Add dreamWorkContribution
     *
     * @param  WorkContribute $dreamWorkContribution
     * @return $this
     */
    public function addDreamWorkContribution(\AppBundle\Document\WorkContribute $dreamWorkContribution)
    {
        $this->dreamWorkContributions[] = $dreamWorkContribution;

        return $this;
    }

    /**
     * Remove dreamWorkContribution
     *
     * @param  WorkContribute $dreamWorkContribution
     * @return $this
     */
    public function removeDreamWorkContribution(\AppBundle\Document\WorkContribute $dreamWorkContribution)
    {
        $this->dreamWorkContributions->removeElement($dreamWorkContribution);

        return $this;
    }

    /**
     * Get dreamWorkContributions
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getDreamWorkContributions()
    {
        return $this->dreamWorkContributions;
    }

    /**
     * Add dreamOtherContribution
     *
     * @param  OtherContribute $dreamOtherContribution
     * @return $this
     */
    public function addDreamOtherContribution(\AppBundle\Document\OtherContribute $dreamOtherContribution)
    {
        $this->dreamOtherContributions[] = $dreamOtherContribution;

        return $this;
    }

    /**
     * Remove dreamOtherContribution
     *
     * @param  OtherContribute $dreamOtherContribution
     * @return $this
     */
    public function removeDreamOtherContribution(\AppBundle\Document\OtherContribute $dreamOtherContribution)
    {
        $this->dreamOtherContributions->removeElement($dreamOtherContribution);

        return $this;
    }

    /**
     * Get dreamOtherContributions
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getDreamOtherContributions()
    {
        return $this->dreamOtherContributions;
    }
}
