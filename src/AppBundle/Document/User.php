<?php
namespace AppBundle\Entity;

use AppBundle\Document\ContactInfo;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Users
 *
 * @ODM\Document(collection="users", repositoryClass="AppBundle\Repository\UsersRepository")
 */
class User extends BaseUser //implements DreamUserInterface
{
    use ContactInfo;

    const FAKE_EMAIL_PART = "@example.com";

    /**
     * @var integer
     *
     * @ODM\Id
     */
    protected $id;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ODM\Field(type="string")
     */
    protected $firstName;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $middleName;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $lastName;

//    /**
//     * @ODM\ReferenceOne(targetDocument="Application\Sonata\MediaBundle\Entity\Media", cascade="all")
//     */
//    protected $avatar;

    /**
     * @var \DateTime
     *
     * @ODM\Field(type="date")
     */
    protected $birthday;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $about;

    /**
     * @var string
     *
     * @ODM\Field(name="vkontakte_id", type="string")
     */
    protected $vkontakteId;

    /**
     * @var string
     *
     * @ODM\Field(name="facebook_id", type="string")
     */
    protected $facebookId;

    /**
     * @var string
     *
     * @ODM\Field(name="odnoklassniki_id", type="string")
     */
    protected $odnoklassnikiId;

    /**
     * @ODM\ReferenceMany(targetDocument="Dream", mappedBy="usersWhoFavorites" )
     */
    protected $favoriteDreams;

    /**
     * @ODM\ReferenceMany(targetDocument="FinancialContribute", mappedBy="user")
     */
    protected $financialContributions;

    /**
     * @ODM\ReferenceMany(targetDocument="EquipmentContribute", mappedBy="user")
     */
    protected $equipmentContributions;

    /**
     * @ODM\ReferenceMany(targetDocument="WorkContribute", mappedBy="user")
     */
    protected $workContributions;

    /**
     * @ODM\ReferenceMany(targetDocument="OtherContribute", mappedBy="user")
     */
    protected $otherContributions;

    /**
     * @ODM\ReferenceMany(targetDocument="Dream", mappedBy="author")
     */
    protected $dreams;

    /**
     * @return array
     */
    public function getNotNullSocialIds()
    {
        return array_filter([
            'facebook' => $this->facebookId,
            'vkontakte' => $this->vkontakteId,
            'odnoklassniki' => $this->odnoklassnikiId,
        ], 'strlen')
            ;
    }

    /**
     * @return bool
     */
    public function isFakeEmail()
    {
        return false === strpos($this->email, self::FAKE_EMAIL_PART) && $this->email ? false : true;
    }
}
