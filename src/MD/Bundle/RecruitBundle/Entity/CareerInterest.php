<?php

namespace MD\Bundle\RecruitBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * CareerInterest
 * @ORM\Table("career_interest")
 * @ORM\Entity
 */
class CareerInterest {

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
     * @ORM\Column(name="deleted", type="boolean")
     */
    private $deleted = false;

    /**
     * @ORM\OneToMany(targetEntity="CareerApplicationInterest", mappedBy="careerInterest")
     */
    protected $careerApplicationInterests;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->careerApplicationInterests = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return CareerInterest
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return CareerInterest
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    
        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean 
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Add careerApplicationInterests
     *
     * @param \MD\Bundle\RecruitBundle\Entity\CareerApplicationInterest $careerApplicationInterests
     * @return CareerInterest
     */
    public function addCareerApplicationInterest(\MD\Bundle\RecruitBundle\Entity\CareerApplicationInterest $careerApplicationInterests)
    {
        $this->careerApplicationInterests[] = $careerApplicationInterests;
    
        return $this;
    }

    /**
     * Remove careerApplicationInterests
     *
     * @param \MD\Bundle\RecruitBundle\Entity\CareerApplicationInterest $careerApplicationInterests
     */
    public function removeCareerApplicationInterest(\MD\Bundle\RecruitBundle\Entity\CareerApplicationInterest $careerApplicationInterests)
    {
        $this->careerApplicationInterests->removeElement($careerApplicationInterests);
    }

    /**
     * Get careerApplicationInterests
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCareerApplicationInterests()
    {
        return $this->careerApplicationInterests;
    }
}