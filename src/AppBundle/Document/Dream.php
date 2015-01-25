<?php
namespace AppBundle\Document;

use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Class Dream
 * @package AppBundle\Document
 *
 * @ODM\Document(collection="dreams", repositoryClass="AppBundle\Repository\DreamRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Dream
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
     * @Assert\NotBlank(message = "dream.not_blank")
     * @Assert\Length(min = "5", minMessage = "dream.min_length")
     * @ODM\Field(type="string")
     */
    protected $title;

    /**
     * @var string
     *
     * @Assert\NotBlank(message = "dream.not_blank")
     * @ODM\Field(type="string")
     */
    protected $description;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $rejectedDescription;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $implementedDescription;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $completedDescription;

    /**
     * @var string
     *
     * @Assert\NotBlank(message = "dream.not_blank")
     * @Assert\Regex(pattern="/^[+0-9 ()-]+$/", message="dream.only_numbers")
     * @ODM\Field(type="string")
     */
    protected $phone;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"title"})
     * @ODM\Field(type="string")
     */
    protected $slug;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ODM\Field(type="date")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ODM\Field(type="date")
     */
    protected $updatedAt;

    /**
     * @var \DateTime
     *
     * @ODM\Field(type="date")
     */
    protected $deletedAt;

    /**
     * @var \DateTime
     *
     * @ODM\Field(type="date")
     */
    protected $expiredDate;

    /**
     * @var integer
     *
     * @ODM\Field(type="int")
     */
    protected $financialCompleted;

    /**
     * @var integer
     *
     * @ODM\Field(type="int")
     */
    protected $workCompleted;

    /**
     * @var integer
     *
     * @ODM\Field(type="int")
     */
    protected $equipmentCompleted;

    protected $tags;

    /**
     * @ODM\ReferenceMany(targetDocument="User", inversedBy="favoriteDreams")
     */
    protected $usersWhoFavorites = array();

    /**
     * @var integer
     *
     * @ODM\Field(type="int")
     */
    protected $favoritesCount;

    /**
     * @ODM\ReferenceOne(targetDocument="User", inversedBy="dreams")
     */
    protected $author;

    /**
     * @ODM\ReferenceMany(targetDocument="Status", mappedBy="dream", cascade={"persist"})
     */
    protected $statuses = array();

    /**
     * @ODM\Field(type="string")
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
     * @ODM\ReferenceMany(targetDocument="FinancialResource", mappedBy="dream", cascade={"persist"})
     */
    protected $dreamFinancialResources;

    /**
     * @ODM\ReferenceMany(targetDocument="EquipmentResource", mappedBy="dream", cascade={"persist"})
     */
    protected $dreamEquipmentResources;

    /**
     * @ODM\ReferenceMany(targetDocument="WorkResource", mappedBy="dream", cascade={"persist"})
     */
    protected $dreamWorkResources;

    /**
     * @ODM\ReferenceMany(targetDocument="FinancialContribute", mappedBy="dream")
     */
    protected $dreamFinancialContributions;

    /**
     * @ODM\ReferenceMany(targetDocument="EquipmentContribute", mappedBy="dream")
     */
    protected $dreamEquipmentContributions;

    /**
     * @ODM\ReferenceMany(targetDocument="WorkContribute", mappedBy="dream")
     */
    protected $dreamWorkContributions;

    /**
     * @ODM\ReferenceMany(targetDocument="OtherContribute", mappedBy="dream")
     */
    protected $dreamOtherContributions;
}