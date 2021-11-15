<?php

namespace MD\Bundle\RecruitBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Country
 * @ORM\Table("current_vacancy")
 * @ORM\Entity
 */
class CurrentVacancy {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=200)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="position_code", type="string", length=200)
     */
    private $positionCode;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=200, nullable = true)
     */
    private $location;

    /**
     * @var string
     *
     * @ORM\Column(name="industry", type="string", length=200, nullable = true)
     */
    private $industry;

    /**
     * @var string
     *
     * @ORM\Column(name="service_line", type="string", length=200, nullable = true)
     */
    private $serviceLine;

    /**
     * @var string
     *
     * @ORM\Column(name="type_of_position", type="string", length=200, nullable = true)
     */
    private $typeOfPosition;

    /**
     * @var string
     *
     * @ORM\Column(name="level_of_experience", type="string", length=200, nullable = true)
     */
    private $levelOfExperience;

    /**
     * @var string
     * @ORM\Column(name="htmlSlug", type="string", length=255, unique=true)
     */
    protected $htmlSlug;

    /**
     * @var object
     *
     * @ORM\Column(name="content", type="object")
     */
    private $content;

    public function __toString() {
        return $this->getName();
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
     * Set name
     *
     * @param string $name
     * @return CurrentVacancy
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set positionCode
     *
     * @param string $positionCode
     * @return CurrentVacancy
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
     * Set location
     *
     * @param string $location
     * @return CurrentVacancy
     */
    public function setLocation($location) {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation() {
        return $this->location;
    }

    /**
     * Set industry
     *
     * @param string $industry
     * @return CurrentVacancy
     */
    public function setIndustry($industry) {
        $this->industry = $industry;

        return $this;
    }

    /**
     * Get industry
     *
     * @return string 
     */
    public function getIndustry() {
        return $this->industry;
    }

    /**
     * Set serviceLine
     *
     * @param string $serviceLine
     * @return CurrentVacancy
     */
    public function setServiceLine($serviceLine) {
        $this->serviceLine = $serviceLine;

        return $this;
    }

    /**
     * Get serviceLine
     *
     * @return string 
     */
    public function getServiceLine() {
        return $this->serviceLine;
    }

    /**
     * Set typeOfPosition
     *
     * @param string $typeOfPosition
     * @return CurrentVacancy
     */
    public function setTypeOfPosition($typeOfPosition) {
        $this->typeOfPosition = $typeOfPosition;

        return $this;
    }

    /**
     * Get typeOfPosition
     *
     * @return string 
     */
    public function getTypeOfPosition() {
        return $this->typeOfPosition;
    }

    /**
     * Set levelOfExperience
     *
     * @param string $levelOfExperience
     * @return CurrentVacancy
     */
    public function setLevelOfExperience($levelOfExperience) {
        $this->levelOfExperience = $levelOfExperience;

        return $this;
    }

    /**
     * Get levelOfExperience
     *
     * @return string 
     */
    public function getLevelOfExperience() {
        return $this->levelOfExperience;
    }

    /**
     * Set htmlSlug
     *
     * @param string $htmlSlug
     * @return Blog
     */
    public function setHtmlSlug($htmlSlug) {
        $this->htmlSlug = $htmlSlug;

        return $this;
    }

    /**
     * Get htmlSlug
     *
     * @return string
     */
    public function getHtmlSlug() {
        return $this->htmlSlug;
    }

    /**
     * Set content
     *
     * @param \stdClass $content
     * @return CurrentVacancy
     */
    public function setContent($content) {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return \stdClass 
     */
    public function getContent() {
        return $this->content;
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

}
