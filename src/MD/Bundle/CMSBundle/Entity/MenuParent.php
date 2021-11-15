<?php

namespace MD\Bundle\CMSBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * MenuParent
 * @ORM\Table("menu_has_parent")
 * @ORM\Entity
 */
class MenuParent {

    /**
     * @Assert\NotBlank()
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="menuParents")
     */
    private $parent;

    /**
     * @Assert\NotBlank()
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="menuChilds")
     */
    private $child;

    /**
     * Set parent
     *
     * @param \MD\Bundle\CMSBundle\Entity\Menu $parent
     * @return MenuParent
     */
    public function setParent(\MD\Bundle\CMSBundle\Entity\Menu $parent) {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \MD\Bundle\CMSBundle\Entity\Menu
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * Set child
     *
     * @param \MD\Bundle\CMSBundle\Entity\Menu $child
     * @return MenuParent
     */
    public function setChild(\MD\Bundle\CMSBundle\Entity\Menu $child) {
        $this->child = $child;

        return $this;
    }

    /**
     * Get child
     *
     * @return \MD\Bundle\CMSBundle\Entity\Menu
     */
    public function getChild() {
        return $this->child;
    }

}
