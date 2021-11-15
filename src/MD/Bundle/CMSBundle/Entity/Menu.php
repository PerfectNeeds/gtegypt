<?php

namespace MD\Bundle\CMSBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Menu
 * @ORM\Table("menu")
 * @ORM\Entity(repositoryClass="MD\Bundle\CMSBundle\Repository\MenuRepository")
 */
class Menu {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Tab", inversedBy="menus")
     */
    private $tab;

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
     * @ORM\OneToMany(targetEntity="MenuItem", mappedBy="menu")
     */
    protected $menuItems;

    /**
     * @ORM\OneToMany(targetEntity="MenuParent", mappedBy="parent")
     */
    protected $menuParents;

    /**
     * @ORM\OneToMany(targetEntity="MenuParent", mappedBy="child")
     */
    protected $menuChilds;

    /**
     * Constructor
     */
    public function __construct() {
        $this->menuItems = new \Doctrine\Common\Collections\ArrayCollection();
        $this->menuParents = new \Doctrine\Common\Collections\ArrayCollection();
        $this->menuChilds = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Menu
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
     * @return Menu
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
     * Add menuItems
     *
     * @param \MD\Bundle\CMSBundle\Entity\MenuItem $menuItems
     * @return Menu
     */
    public function addMenuItem(\MD\Bundle\CMSBundle\Entity\MenuItem $menuItems) {
        $this->menuItems[] = $menuItems;

        return $this;
    }

    /**
     * Remove menuItems
     *
     * @param \MD\Bundle\CMSBundle\Entity\MenuItem $menuItems
     */
    public function removeMenuItem(\MD\Bundle\CMSBundle\Entity\MenuItem $menuItems) {
        $this->menuItems->removeElement($menuItems);
    }

    /**
     * Get menuItems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMenuItems() {
        return $this->menuItems;
    }

    /**
     * Get menuItems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFirstMenuItems() {
        return $this->menuItems[0];
    }

    /**
     * Add menuParents
     *
     * @param \MD\Bundle\CMSBundle\Entity\MenuParent $menuParents
     * @return Menu
     */
    public function addMenuParent(\MD\Bundle\CMSBundle\Entity\MenuParent $menuParents) {
        $this->menuParents[] = $menuParents;

        return $this;
    }

    /**
     * Remove menuParents
     *
     * @param \MD\Bundle\CMSBundle\Entity\MenuParent $menuParents
     */
    public function removeMenuParent(\MD\Bundle\CMSBundle\Entity\MenuParent $menuParents) {
        $this->menuParents->removeElement($menuParents);
    }

    /**
     * Get menuParents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMenuParents() {
        return $this->menuParents;
    }

    /**
     * Get firstMenuParents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFirstMenuParents() {
        return $this->menuParents[0];
    }

    /**
     * Add menuChilds
     *
     * @param \MD\Bundle\CMSBundle\Entity\MenuParent $menuChilds
     * @return Menu
     */
    public function addMenuChild(\MD\Bundle\CMSBundle\Entity\MenuParent $menuChilds) {
        $this->menuChilds[] = $menuChilds;

        return $this;
    }

    /**
     * Remove menuChilds
     *
     * @param \MD\Bundle\CMSBundle\Entity\MenuParent $menuChilds
     */
    public function removeMenuChild(\MD\Bundle\CMSBundle\Entity\MenuParent $menuChilds) {
        $this->menuChilds->removeElement($menuChilds);
    }

    /**
     * Get menuChilds
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMenuChilds() {
        return $this->menuChilds;
    }

    /**
     * Get firstMenuChilds
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFirstMenuChilds() {
        return $this->menuChilds[0];
    }

    /**
     * Set tab
     *
     * @param \MD\Bundle\CMSBundle\Entity\Tab $tab
     * @return Menu
     */
    public function setTab(\MD\Bundle\CMSBundle\Entity\Tab $tab = null) {
        $this->tab = $tab;

        return $this;
    }

    /**
     * Get tab
     *
     * @return \MD\Bundle\CMSBundle\Entity\Tab
     */
    public function getTab() {
        return $this->tab;
    }

}
