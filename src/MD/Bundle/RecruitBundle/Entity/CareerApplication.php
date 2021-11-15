<?php

namespace MD\Bundle\RecruitBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * CareerApplication
 * @ORM\Table("career_application")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity
 */
class CareerApplication {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="careerApplications")
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="position_name", type="string", length=45)
     */
    private $positionName;
    
    /**
     * @var string
     *
     * @ORM\Column(name="position_code", type="string", length=45, nullable=true)
     */
    private $positionCode;

    /**
     * @var string
     *
     * @ORM\Column(name="full_name", type="string", length=255)
     */
    private $fullName;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=255, nullable=true)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="last_position", type="string", length=45, nullable=true)
     */
    private $lastPosition;

    /**
     * @var string
     *
     * @ORM\Column(name="company", type="string", length=45, nullable=true)
     */
    private $company;

    /**
     * @var text
     *
     * @ORM\Column(name="education", type="string", length=45, nullable=true)
     */
    private $education;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=45, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="certificate", type="string", length=45, nullable=true)
     */
    private $certificate;

    /**
     * @var string
     *
     * @ORM\Column(name="years_ex", type="string", length=255, nullable=true)
     */
    private $yearsEx;

    /**
     * @var string
     *
     * @ORM\Column(name="sector", type="string", length=255, nullable=true)
     */
    private $sector;

    /**
     * @var string
     *
     * @ORM\Column(name="last_salary", type="string", length=255, nullable=true)
     */
    private $lastSalary;
    
    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="expected_salary", type="string", length=255, nullable=true)
     */
    private $expectedSalary;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\Column(name="state", type="smallint", nullable=false)
     */
    private $state;

    /**
     * @ORM\Column(name="deleted", type="boolean")
     */
    private $deleted = false;

    /**
     * @ORM\ManyToMany(targetEntity="\MD\Bundle\MediaBundle\Entity\Document", cascade={"all"})
     */
    protected $documents;

    /**
     * Now we tell doctrine that before we persist or update we call the updatedTimestamps() function.
     *
     * @ORM\PrePersist
     */
    public function updatedTimestamps() {
        $this->setCreated(new \DateTime(date('Y-m-d H:i:s')));

        if ($this->getCreated() == null) {
            $this->setCreated(new \DateTime(date('Y-m-d H:i:s')));
        }
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->documents = new \Doctrine\Common\Collections\ArrayCollection();
        $this->careerApplicationLanguages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->careerApplicationEducations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->careerApplicationInterests = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set positionCode
     *
     * @param string $positionCode
     * @return CareerApplication
     */
    public function setPositionName($positionName) {
        $this->positionName = $positionName;

        return $this;
    }
    
    /**
     * Get positionCode
     *
     * @return string
     */
    public function getPositionName() {
        return $this->positionName;
    }
    
    /**
     * Set positionCode
     *
     * @param string $positionCode
     * @return CareerApplication
     */
    public function setPositionCode($positionCode) {
        $this->positionCode = $positionCode;

        return $this;
    }

    /**
     * Get positionCode
     *
     * @return string
     */
    public function getPositionCode() {
        return $this->positionCode;
    }

    /**
     * Set fullName
     *
     * @param string $fullName
     * @return CareerApplication
     */
    public function setFullName($fullName) {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get fullName
     *
     * @return string
     */
    public function getFullName() {
        return $this->fullName;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return CareerApplication
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set gender
     *
     * @param \DateTime $birthDate
     * @return CareerApplication
     */
    public function setGender($gender) {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender() {
        return $this->gender;
    }

    /**
     * Set landLine
     *
     * @param string $lastPosition
     * @return CareerApplication
     */
    public function setLastPosition($lastPosition) {
        $this->lastPosition = $lastPosition;

        return $this;
    }

    /**
     * Get lastPosition
     *
     * @return string
     */
    public function getLastPosition() {
        return $this->lastPosition;
    }

    /**
     * Set cellular
     *
     * @param string $education
     * @return CareerApplication
     */
    public function setEducation($education) {
        $this->education = $education;

        return $this;
    }

    /**
     * Get education
     *
     * @return string
     */
    public function getEducation() {
        return $this->education;
    }

    /**
     * Set address
     *
     * @param string $certificate
     * @return CareerApplication
     */
    public function setCertificate($certificate) {
        $this->certificate = $certificate;

        return $this;
    }

    /**
     * Get certificate
     *
     * @return string
     */
    public function getCertificate() {
        return $this->certificate;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return CareerApplication
     */
    public function setCity($city) {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * Set currentPosition
     *
     * @param string $yearsEx
     * @return CareerApplication
     */
    public function setYearsEx($yearsEx) {
        $this->yearsEx = $yearsEx;

        return $this;
    }

    /**
     * Get yearsEx
     *
     * @return string
     */
    public function getYearsEx() {
        return $this->yearsEx;
    }

    /**
     * Set sector
     *
     * @param string $sector
     * @return CareerApplication
     */
    public function setSector($sector) {
        $this->sector = $sector;

        return $this;
    }

    /**
     * Get reportingTo
     *
     * @return string
     */
    public function getSector() {
        return $this->sector;
    }

    /**
     * Set company
     *
     * @param string $company
     * @return CareerApplication
     */
    public function setCompany($company) {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return string
     */
    public function getCompany() {
        return $this->company;
    }
    /**
     * Set address
     *
     * 
     * @param string $address
     * @return CareerApplication
     */
    public function setAddress($address) {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * Set jobDescription
     *
     * @param string $lastSalary
     * @return CareerApplication
     */
    public function setLastSalary($lastSalary) {
        $this->lastSalary = $lastSalary;

        return $this;
    }

    /**
     * Get jobDescription
     *
     * @return string
     */
    public function getLastSalary() {
        return $this->lastSalary;
    }

    /**
     * Set jobDescription
     *
     * @param string $expectedSalary
     * @return CareerApplication
     */
    public function setExpectedSalary($expectedSalary) {
        $this->expectedSalary = $expectedSalary;

        return $this;
    }

    /**
     * Get jobDescription
     *
     * @return string
     */
    public function getExpectedSalary() {
        return $this->expectedSalary;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return CareerApplication
     */
    public function setCreated($created) {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * Set state
     *
     * @param integer $state
     * @return CareerApplication
     */
    public function setState($state) {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return integer
     */
    public function getState() {
        return $this->state;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return CareerApplication
     */
    public function setDeleted($deleted) {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean
     */
    public function getDeleted() {
        return $this->deleted;
    }

    /**
     * Set country
     *
     * @param \MD\Bundle\RecruitBundle\Entity\Country $country
     * @return CareerApplication
     */
    public function setCountry(\MD\Bundle\RecruitBundle\Entity\Country $country = null) {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \MD\Bundle\RecruitBundle\Entity\Country
     */
    public function getCountry() {
        return $this->country;
    }

    /**
     * Add documents
     *
     * @param \MD\Bundle\MediaBundle\Entity\Document $documents
     * @return CareerApplication
     */
    public function addDocument(\MD\Bundle\MediaBundle\Entity\Document $documents) {
        $this->documents[] = $documents;

        return $this;
    }

    /**
     * Remove documents
     *
     * @param \MD\Bundle\MediaBundle\Entity\Document $documents
     */
    public function removeDocument(\MD\Bundle\MediaBundle\Entity\Document $documents) {
        $this->documents->removeElement($documents);
    }

    /**
     * Get documents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocuments() {
        return $this->documents;
    }

    /**
     * Get firstDocuments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFirstDocuments() {
        return $this->documents[0];
    }

    /**
     * Add careerApplicationLanguages
     *
     * @param \MD\Bundle\RecruitBundle\Entity\CareerApplicationLanguage $careerApplicationLanguages
     * @return CareerApplication
     */
    public function addCareerApplicationLanguage(\MD\Bundle\RecruitBundle\Entity\CareerApplicationLanguage $careerApplicationLanguages) {
        $this->careerApplicationLanguages[] = $careerApplicationLanguages;

        return $this;
    }

    /**
     * Remove careerApplicationLanguages
     *
     * @param \MD\Bundle\RecruitBundle\Entity\CareerApplicationLanguage $careerApplicationLanguages
     */
    public function removeCareerApplicationLanguage(\MD\Bundle\RecruitBundle\Entity\CareerApplicationLanguage $careerApplicationLanguages) {
        $this->careerApplicationLanguages->removeElement($careerApplicationLanguages);
    }

    /**
     * Get careerApplicationLanguages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCareerApplicationLanguages() {
        return $this->careerApplicationLanguages;
    }

    /**
     * Add careerApplicationEducations
     *
     * @param \MD\Bundle\RecruitBundle\Entity\CareerApplicationEducation $careerApplicationEducations
     * @return CareerApplication
     */
    public function addCareerApplicationEducation(\MD\Bundle\RecruitBundle\Entity\CareerApplicationEducation $careerApplicationEducations) {
        $this->careerApplicationEducations[] = $careerApplicationEducations;

        return $this;
    }

    /**
     * Remove careerApplicationEducations
     *
     * @param \MD\Bundle\RecruitBundle\Entity\CareerApplicationEducation $careerApplicationEducations
     */
    public function removeCareerApplicationEducation(\MD\Bundle\RecruitBundle\Entity\CareerApplicationEducation $careerApplicationEducations) {
        $this->careerApplicationEducations->removeElement($careerApplicationEducations);
    }

    /**
     * Get careerApplicationEducations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCareerApplicationEducations() {
        return $this->careerApplicationEducations;
    }

    /**
     * Add careerApplicationInterests
     *
     * @param \MD\Bundle\RecruitBundle\Entity\CareerApplicationInterest $careerApplicationInterests
     * @return CareerApplication
     */
    public function addCareerApplicationInterest(\MD\Bundle\RecruitBundle\Entity\CareerApplicationInterest $careerApplicationInterests) {
        $this->careerApplicationInterests[] = $careerApplicationInterests;

        return $this;
    }

    /**
     * Remove careerApplicationInterests
     *
     * @param \MD\Bundle\RecruitBundle\Entity\CareerApplicationInterest $careerApplicationInterests
     */
    public function removeCareerApplicationInterest(\MD\Bundle\RecruitBundle\Entity\CareerApplicationInterest $careerApplicationInterests) {
        $this->careerApplicationInterests->removeElement($careerApplicationInterests);
    }

    /**
     * Get careerApplicationInterests
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCareerApplicationInterests() {
        return $this->careerApplicationInterests;
    }

}
