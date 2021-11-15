<?php

namespace MD\Bundle\CMSBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Menu
 * @ORM\Table("faq_category")
 * @ORM\Entity
 */
class FaqCategory {

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
     *
     * @ORM\Column(name="deleted", type="boolean")
     */
    private $deleted = false;

    /**
     * @ORM\OneToMany(targetEntity="Faq", mappedBy="faqCategory")
     */
    protected $faqs;

    public function __toString() {
        return $this->getName();
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->faqs = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return FaqCategory
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
     * Set deleted
     *
     * @param boolean $deleted
     * @return FaqCategory
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
     * Add faqs
     *
     * @param \MD\Bundle\CMSBundle\Entity\Faq $faqs
     * @return FaqCategory
     */
    public function addFaq(\MD\Bundle\CMSBundle\Entity\Faq $faqs) {
        $this->faqs[] = $faqs;

        return $this;
    }

    /**
     * Remove faqs
     *
     * @param \MD\Bundle\CMSBundle\Entity\Faq $faqs
     */
    public function removeFaq(\MD\Bundle\CMSBundle\Entity\Faq $faqs) {
        $this->faqs->removeElement($faqs);
    }

    /**
     * Get faqs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFaqs() {
        return $this->faqs;
    }

}
