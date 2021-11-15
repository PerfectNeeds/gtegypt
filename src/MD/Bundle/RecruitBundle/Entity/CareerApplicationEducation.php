<?php

namespace MD\Bundle\RecruitBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * CareerApplicationEducation
 * @ORM\Table("career_application_education")
 * @ORM\Entity
 */
class CareerApplicationEducation {

    const Professional = 1;
    const PhDMaster = 2;
    const Bachelor = 3;
    const HighSchool = 4;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="CareerApplication", inversedBy="careerApplicationEducations")
     */
    protected $careerApplication;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="smallint", nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="grad_year", type="date", nullable=false)
     */
    private $gradYear;

    /**
     * @var string
     *
     * @ORM\Column(name="institution", type="string", length=255, nullable=true)
     */
    private $institution;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return CareerApplicationEducation
     */
    public function setType($type) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType() {
        switch ($this->type) {
            case self::Professional:
                $type = 'Professional';
                break;
            case self::PhDMaster:
                $type = 'PhD/Master';
                break;
            case self::Bachelor:
                $type = 'Bachelor';
                break;
            case self::HighSchool:
                $type = 'High School';
                break;
        }
        return $type;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return CareerApplicationEducation
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
     * Set gradYear
     *
     * @param \DateTime $gradYear
     * @return CareerApplicationEducation
     */
    public function setGradYear($gradYear) {
        $this->gradYear = $gradYear;

        return $this;
    }

    /**
     * Get gradYear
     *
     * @return \DateTime
     */
    public function getGradYear() {
        return $this->gradYear;
    }

    /**
     * Set institution
     *
     * @param string $institution
     * @return CareerApplicationEducation
     */
    public function setInstitution($institution) {
        $this->institution = $institution;

        return $this;
    }

    /**
     * Get institution
     *
     * @return string
     */
    public function getInstitution() {
        return $this->institution;
    }

    /**
     * Set careerApplication
     *
     * @param \MD\Bundle\RecruitBundle\Entity\CareerApplication $careerApplication
     * @return CareerApplicationEducation
     */
    public function setCareerApplication(\MD\Bundle\RecruitBundle\Entity\CareerApplication $careerApplication = null) {
        $this->careerApplication = $careerApplication;

        return $this;
    }

    /**
     * Get careerApplication
     *
     * @return \MD\Bundle\RecruitBundle\Entity\CareerApplication
     */
    public function getCareerApplication() {
        return $this->careerApplication;
    }

}
