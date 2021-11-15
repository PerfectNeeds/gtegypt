<?php

namespace MD\Bundle\RecruitBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * CareerApplicationLanguage
 * @ORM\Table("career_application_has_language")
 * @ORM\Entity
 */
class CareerApplicationLanguage {

    const NATIVE = 1;
    const EXCELLENT = 2;
    const GOOD = 3;
    const BASIC = 4;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="CareerApplication", inversedBy="careerApplicationLanguages")
     */
    protected $careerApplication;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

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
     * Set name
     *
     * @param string $name
     * @return CareerApplicationLanguage
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
     * Set level
     *
     * @param integer $level
     * @return CareerApplicationLanguage
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
            case self::NATIVE:
                $level = 'Native';
                break;
            case self::EXCELLENT:
                $level = 'Excellent';
                break;
            case self::GOOD:
                $level = 'Good';
                break;
            case self::BASIC:
                $level = 'basic';
                break;
        }
        return $level;
    }

    /**
     * Set careerApplication
     *
     * @param \MD\Bundle\RecruitBundle\Entity\CareerApplication $careerApplication
     * @return CareerApplicationLanguage
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
