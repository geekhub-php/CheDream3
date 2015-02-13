<?php

namespace AppBundle\Document;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;

/**
 * Class Users
 * @package AppBundle\Document
 *
 * @ODM\Document(collection="users")
 * @ExclusionPolicy("all")
 */
class User extends BaseUser //implements DreamUserInterface
{
    const FAKE_EMAIL_PART = "@example.com";

    /**
     * @var integer
     *
     * @ODM\Id
     * @Expose()
     * @JMS\Type("integer")
     */
    protected $id;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ODM\Field(type="string")
     * @Expose()
     * @JMS\Type("string")
     */
    protected $firstName;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @Expose()
     * @JMS\Type("string")
     */
    protected $middleName;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @Expose()
     * @JMS\Type("string")
     */
    protected $lastName;

    /**
     * @var \DateTime
     *
     * @ODM\Field(type="date")
     * @Expose()
     * @JMS\Type("DateTime")
     */
    protected $birthday;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @Expose()
     * @JMS\Type("string")
     */
    protected $about;

    /**
     * @var string
     *
     * @ODM\Field(name="vkontakte_id", type="string")
     * @Expose()
     * @JMS\Type("string")
     */
    protected $vkontakteId;

    /**
     * @var string
     *
     * @ODM\Field(name="facebook_id", type="string")
     * @Expose()
     * @JMS\Type("string")
     */
    protected $facebookId;

    /**
     * @var string
     *
     * @ODM\Field(name="odnoklassniki_id", type="string")
     * @Expose()
     * @JMS\Type("string")
     */
    protected $odnoklassnikiId;

    /**
     * @ODM\ReferenceMany(targetDocument="Dream")
     */
    protected $favoriteDreams;

    /**
     * @ODM\ReferenceMany(targetDocument="FinancialContribute")
     * @Expose()
     */
    protected $financialContributions;

    /**
     * @ODM\ReferenceMany(targetDocument="EquipmentContribute")
     * @Expose()
     */
    protected $equipmentContributions;

    /**
     * @ODM\ReferenceMany(targetDocument="WorkContribute")
     * @Expose()
     */
    protected $workContributions;

    /**
     * @ODM\ReferenceMany(targetDocument="OtherContribute")
     * @Expose()
     */
    protected $otherContributions;

    /**
     * @ODM\ReferenceMany(targetDocument="Dream")
     * @Expose()
     */
    protected $dreams;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @Expose()
     * @JMS\Type("string")
     */
    protected $phone;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @Expose()
     * @JMS\Type("string")
     */
    protected $skype;

    public function __construct()
    {
        $this->favoriteDreams = new \Doctrine\Common\Collections\ArrayCollection();
        $this->financialContributions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->equipmentContributions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->workContributions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->otherContributions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dreams = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set firstName
     *
     * @param  string $firstName
     * @return self
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string $firstName
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set middleName
     *
     * @param  string $middleName
     * @return self
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;

        return $this;
    }

    /**
     * Get middleName
     *
     * @return string $middleName
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * Set lastName
     *
     * @param  string $lastName
     * @return self
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string $lastName
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set birthday
     *
     * @param  date $birthday
     * @return self
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return date $birthday
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set about
     *
     * @param  string $about
     * @return self
     */
    public function setAbout($about)
    {
        $this->about = $about;

        return $this;
    }

    /**
     * Get about
     *
     * @return string $about
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * Set vkontakteId
     *
     * @param  string $vkontakteId
     * @return self
     */
    public function setVkontakteId($vkontakteId)
    {
        $this->vkontakteId = $vkontakteId;

        return $this;
    }

    /**
     * Get vkontakteId
     *
     * @return string $vkontakteId
     */
    public function getVkontakteId()
    {
        return $this->vkontakteId;
    }

    /**
     * Set facebookId
     *
     * @param  string $facebookId
     * @return self
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;

        return $this;
    }

    /**
     * Get facebookId
     *
     * @return string $facebookId
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * Set odnoklassnikiId
     *
     * @param  string $odnoklassnikiId
     * @return self
     */
    public function setOdnoklassnikiId($odnoklassnikiId)
    {
        $this->odnoklassnikiId = $odnoklassnikiId;

        return $this;
    }

    /**
     * Get odnoklassnikiId
     *
     * @return string $odnoklassnikiId
     */
    public function getOdnoklassnikiId()
    {
        return $this->odnoklassnikiId;
    }

    /**
     * Add favoriteDream
     *
     * @param  Dream $favoriteDream
     * @return $this
     */
    public function addFavoriteDream(\AppBundle\Document\Dream $favoriteDream)
    {
        $this->favoriteDreams[] = $favoriteDream;

        return $this;
    }

    /**
     * Remove favoriteDream
     *
     * @param  Dream $favoriteDream
     * @return $this
     */
    public function removeFavoriteDream(\AppBundle\Document\Dream $favoriteDream)
    {
        $this->favoriteDreams->removeElement($favoriteDream);

        return $this;
    }

    /**
     * Get favoriteDreams
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getFavoriteDreams()
    {
        return $this->favoriteDreams;
    }

    /**
     * Add financialContribution
     *
     * @param  FinancialContribute $financialContribution
     * @return $this
     */
    public function addFinancialContribution(\AppBundle\Document\FinancialContribute $financialContribution)
    {
        $this->financialContributions[] = $financialContribution;

        return $this;
    }

    /**
     * Remove financialContribution
     *
     * @param  FinancialContribute $financialContribution
     * @return $this
     */
    public function removeFinancialContribution(\AppBundle\Document\FinancialContribute $financialContribution)
    {
        $this->financialContributions->removeElement($financialContribution);

        return $this;
    }

    /**
     * Get financialContributions
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getFinancialContributions()
    {
        return $this->financialContributions;
    }

    /**
     * Add equipmentContribution
     *
     * @param  EquipmentContribute $equipmentContribution
     * @return $this
     */
    public function addEquipmentContribution(\AppBundle\Document\EquipmentContribute $equipmentContribution)
    {
        $this->equipmentContributions[] = $equipmentContribution;

        return $this;
    }

    /**
     * Remove equipmentContribution
     *
     * @param  EquipmentContribute $equipmentContribution
     * @return $this
     */
    public function removeEquipmentContribution(\AppBundle\Document\EquipmentContribute $equipmentContribution)
    {
        $this->equipmentContributions->removeElement($equipmentContribution);

        return $this;
    }

    /**
     * Get equipmentContributions
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getEquipmentContributions()
    {
        return $this->equipmentContributions;
    }

    /**
     * Add workContribution
     *
     * @param  WorkContribute $workContribution
     * @return $this
     */
    public function addWorkContribution(\AppBundle\Document\WorkContribute $workContribution)
    {
        $this->workContributions[] = $workContribution;

        return $this;
    }

    /**
     * Remove workContribution
     *
     * @param  WorkContribute $workContribution
     * @return $this
     */
    public function removeWorkContribution(\AppBundle\Document\WorkContribute $workContribution)
    {
        $this->workContributions->removeElement($workContribution);

        return $this;
    }

    /**
     * Get workContributions
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getWorkContributions()
    {
        return $this->workContributions;
    }

    /**
     * Add otherContribution
     *
     * @param  OtherContribute $otherContribution
     * @return $this
     */
    public function addOtherContribution(\AppBundle\Document\OtherContribute $otherContribution)
    {
        $this->otherContributions[] = $otherContribution;

        return $this;
    }

    /**
     * Remove otherContribution
     *
     * @param  OtherContribute $otherContribution
     * @return $this
     */
    public function removeOtherContribution(\AppBundle\Document\OtherContribute $otherContribution)
    {
        $this->otherContributions->removeElement($otherContribution);

        return $this;
    }

    /**
     * Get otherContributions
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getOtherContributions()
    {
        return $this->otherContributions;
    }

    /**
     * Add dream
     *
     * @param  Dream $dream
     * @return $this
     */
    public function addDream(\AppBundle\Document\Dream $dream)
    {
        $this->dreams[] = $dream;

        return $this;
    }

    /**
     * Remove dream
     *
     * @param  Dream $dream
     * @return $this
     */
    public function removeDream(\AppBundle\Document\Dream $dream)
    {
        $this->dreams->removeElement($dream);

        return $this;
    }

    /**
     * Get dreams
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getDreams()
    {
        return $this->dreams;
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
     * Set skype
     *
     * @param  string $skype
     * @return self
     */
    public function setSkype($skype)
    {
        $this->skype = $skype;

        return $this;
    }

    /**
     * Get skype
     *
     * @return string $skype
     */
    public function getSkype()
    {
        return $this->skype;
    }
}
