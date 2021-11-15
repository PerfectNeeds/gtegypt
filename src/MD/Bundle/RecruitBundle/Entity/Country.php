<?php

namespace MD\Bundle\RecruitBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Country
 * @ORM\Table("country")
 * @ORM\Entity
 */
class Country {

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
     * @ORM\Column(name="name", type="string", length=45)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="CareerApplication", mappedBy="country")
     */
    protected $careerApplications;

    public function __toString() {
        return $this->getName();
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->careerApplications = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Country
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
     * Add careerApplications
     *
     * @param \MD\Bundle\RecruitBundle\Entity\CareerApplication $careerApplications
     * @return Country
     */
    public function addCareerApplication(\MD\Bundle\RecruitBundle\Entity\CareerApplication $careerApplications) {
        $this->careerApplications[] = $careerApplications;

        return $this;
    }

    /**
     * Remove careerApplications
     *
     * @param \MD\Bundle\RecruitBundle\Entity\CareerApplication $careerApplications
     */
    public function removeCareerApplication(\MD\Bundle\RecruitBundle\Entity\CareerApplication $careerApplications) {
        $this->careerApplications->removeElement($careerApplications);
    }

    /**
     * Get careerApplications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCareerApplications() {
        return $this->careerApplications;
    }

}
