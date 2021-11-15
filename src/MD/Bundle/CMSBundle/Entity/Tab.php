<?php

namespace MD\Bundle\CMSBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Menu
 * @ORM\Table("tab")
 * @ORM\Entity
 */
class Tab {

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
     * @ORM\Column(name="state", type="smallint", nullable=false)
     */
    private $state;

    /**
     * @ORM\OneToMany(targetEntity="Menu", mappedBy="tab")
     */
    protected $menus;

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
     * Set name
     *
     * @param string $name
     * @return Tab
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
     * Set state
     *
     * @param integer $state
     * @return Tab
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
     * Constructor
     */
    public function __construct() {
        $this->menus = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add menus
     *
     * @param \MD\Bundle\CMSBundle\Entity\Menu $menus
     * @return Tab
     */
    public function addMenu(\MD\Bundle\CMSBundle\Entity\Menu $menus) {
        $this->menus[] = $menus;

        return $this;
    }

    /**
     * Remove menus
     *
     * @param \MD\Bundle\CMSBundle\Entity\Menu $menus
     */
    public function removeMenu(\MD\Bundle\CMSBundle\Entity\Menu $menus) {
        $this->menus->removeElement($menus);
    }

    /**
     * Get menus
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMenus() {
        return $this->menus;
    }

}
