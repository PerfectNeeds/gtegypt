<?php

namespace MD\Bundle\CMSBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * MenuItem
 * @ORM\Table("menu_item")
 * @ORM\Entity
 */
class MenuItem {

    const INTERNAL = 1;
    const EXTERNAL = 2;

    /**
     * @Assert\NotBlank()
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="menuItems")
     */
    private $menu;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="text", length=45)
     */
    private $url;

    /**
     *
     * @ORM\Column(name="target", type="smallint", nullable=false)
     */
    private $target = false;


    /**
     * Set url
     *
     * @param string $url
     * @return MenuItem
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set target
     *
     * @param integer $target
     * @return MenuItem
     */
    public function setTarget($target)
    {
        $this->target = $target;
    
        return $this;
    }

    /**
     * Get target
     *
     * @return integer 
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Set menu
     *
     * @param \MD\Bundle\CMSBundle\Entity\Menu $menu
     * @return MenuItem
     */
    public function setMenu(\MD\Bundle\CMSBundle\Entity\Menu $menu)
    {
        $this->menu = $menu;
    
        return $this;
    }

    /**
     * Get menu
     *
     * @return \MD\Bundle\CMSBundle\Entity\Menu 
     */
    public function getMenu()
    {
        return $this->menu;
    }
}