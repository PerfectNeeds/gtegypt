<?php

namespace MD\Bundle\RecruitBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * CareerApplicationInterest
 * @ORM\Table("career_application_has_interest")
 * @ORM\Entity
 */
class CareerApplicationInterest {

    const Junior = 1;
    const Senior = 2;
    const Management = 3;
    const Leadership = 4;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="CareerApplication", inversedBy="careerApplicationInterests")
     */
    protected $careerApplication;

    /**
     * @ORM\ManyToOne(targetEntity="CareerInterest", inversedBy="careerApplicationInterests")
     */
    protected $careerInterest;

    /**
     * @var string
     *
     * @ORM\Column(name="level", type="smallint", nullable=false)
     */
    private $level;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set level
     *
     * @param integer $level
     * @return CareerApplicationInterest
     */
    public function setLevel($level) {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel() {
        switch ($this->level) {
            case self::Junior:
                $level = 'Junior';
                break;
            case self::Senior:
                $level = 'Senior';
                break;
            case self::Management:
                $level = 'Management';
                break;
            case self::Leadership:
                $level = 'Leadership';
                break;
        }

        return $level;
    }

    /**
     * Set careerApplication
     *
     * @param \MD\Bundle\RecruitBundle\Entity\CareerApplication $careerApplication
     * @return CareerApplicationInterest
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

    /**
     * Set careerInterest
     *
     * @param \MD\Bundle\RecruitBundle\Entity\CareerInterest $careerInterest
     * @return CareerApplicationInterest
     */
    public function setCareerInterest(\MD\Bundle\RecruitBundle\Entity\CareerInterest $careerInterest = null) {
        $this->careerInterest = $careerInterest;

        return $this;
    }

    /**
     * Get careerInterest
     *
     * @return \MD\Bundle\RecruitBundle\Entity\CareerInterest
     */
    public function getCareerInterest() {
        return $this->careerInterest;
    }

}
