<?php

namespace AppBundle\Document;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;

/**
 * Users
 *
 * @ODM\Document(collection="users", repositoryClass="AppBundle\Repository\UsersRepository")
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
     */
    protected $id;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ODM\Field(type="string")
     * @Expose()
     */
    protected $firstName;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @Expose()
     */
    protected $middleName;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @Expose()
     */
    protected $lastName;

    /**
     * @var \DateTime
     *
     * @ODM\Field(type="date")
     * @Expose()
     */
    protected $birthday;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @Expose()
     */
    protected $about;

    /**
     * @var string
     *
     * @ODM\Field(name="vkontakte_id", type="string")
     * @Expose()
     */
    protected $vkontakteId;

    /**
     * @var string
     *
     * @ODM\Field(name="facebook_id", type="string")
     * @Expose()
     */
    protected $facebookId;

    /**
     * @var string
     *
     * @ODM\Field(name="odnoklassniki_id", type="string")
     * @Expose()
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
     * @MaxDepth(1)
     * @Expose()
     */
    protected $dreams;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @Expose()
     */
    protected $phone;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @Expose()
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
     * @param \AppBundle\Document\Dream $favoriteDream
     */
    public function addFavoriteDream(\AppBundle\Document\Dream $favoriteDream)
    {
        $this->favoriteDreams[] = $favoriteDream;
    }

    /**
     * Remove favoriteDream
     *
     * @param \AppBundle\Document\Dream $favoriteDream
     */
    public function removeFavoriteDream(\AppBundle\Document\Dream $favoriteDream)
    {
        $this->favoriteDreams->removeElement($favoriteDream);
    }

    /**
     * Get favoriteDreams
     *
     * @return \Doctrine\Common\Collections\Collection $favoriteDreams
     */
    public function getFavoriteDreams()
    {
        return $this->favoriteDreams;
    }

    /**
     * Add financialContribution
     *
     * @param \AppBundle\Document\FinancialContribute $financialContribution
     */
    public function addFinancialContribution(\AppBundle\Document\FinancialContribute $financialContribution)
    {
        $this->financialContributions[] = $financialContribution;
    }

    /**
     * Remove financialContribution
     *
     * @param \AppBundle\Document\FinancialContribute $financialContribution
     */
    public function removeFinancialContribution(\AppBundle\Document\FinancialContribute $financialContribution)
    {
        $this->financialContributions->removeElement($financialContribution);
    }

    /**
     * Get financialContributions
     *
     * @return \Doctrine\Common\Collections\Collection $financialContributions
     */
    public function getFinancialContributions()
    {
        return $this->financialContributions;
    }

    /**
     * Add equipmentContribution
     *
     * @param \AppBundle\Document\EquipmentContribute $equipmentContribution
     */
    public function addEquipmentContribution(\AppBundle\Document\EquipmentContribute $equipmentContribution)
    {
        $this->equipmentContributions[] = $equipmentContribution;
    }

    /**
     * Remove equipmentContribution
     *
     * @param \AppBundle\Document\EquipmentContribute $equipmentContribution
     */
    public function removeEquipmentContribution(\AppBundle\Document\EquipmentContribute $equipmentContribution)
    {
        $this->equipmentContributions->removeElement($equipmentContribution);
    }

    /**
     * Get equipmentContributions
     *
     * @return \Doctrine\Common\Collections\Collection $equipmentContributions
     */
    public function getEquipmentContributions()
    {
        return $this->equipmentContributions;
    }

    /**
     * Add workContribution
     *
     * @param \AppBundle\Document\WorkContribute $workContribution
     */
    public function addWorkContribution(\AppBundle\Document\WorkContribute $workContribution)
    {
        $this->workContributions[] = $workContribution;
    }

    /**
     * Remove workContribution
     *
     * @param \AppBundle\Document\WorkContribute $workContribution
     */
    public function removeWorkContribution(\AppBundle\Document\WorkContribute $workContribution)
    {
        $this->workContributions->removeElement($workContribution);
    }

    /**
     * Get workContributions
     *
     * @return \Doctrine\Common\Collections\Collection $workContributions
     */
    public function getWorkContributions()
    {
        return $this->workContributions;
    }

    /**
     * Add otherContribution
     *
     * @param \AppBundle\Document\OtherContribute $otherContribution
     */
    public function addOtherContribution(\AppBundle\Document\OtherContribute $otherContribution)
    {
        $this->otherContributions[] = $otherContribution;
    }

    /**
     * Remove otherContribution
     *
     * @param \AppBundle\Document\OtherContribute $otherContribution
     */
    public function removeOtherContribution(\AppBundle\Document\OtherContribute $otherContribution)
    {
        $this->otherContributions->removeElement($otherContribution);
    }

    /**
     * Get otherContributions
     *
     * @return \Doctrine\Common\Collections\Collection $otherContributions
     */
    public function getOtherContributions()
    {
        return $this->otherContributions;
    }

    /**
     * Add dream
     *
     * @param \AppBundle\Document\Dream $dream
     */
    public function addDream(\AppBundle\Document\Dream $dream)
    {
        $this->dreams[] = $dream;
    }

    /**
     * Remove dream
     *
     * @param \AppBundle\Document\Dream $dream
     */
    public function removeDream(\AppBundle\Document\Dream $dream)
    {
        $this->dreams->removeElement($dream);
    }

    /**
     * Get dreams
     *
     * @return \Doctrine\Common\Collections\Collection $dreams
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
