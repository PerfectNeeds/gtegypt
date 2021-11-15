<?php

namespace MD\Bundle\CMSBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Menu
 * @ORM\Table("blog_category")
 * @ORM\Entity
 */
class BlogCategory {

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
     * @ORM\OneToMany(targetEntity="Blog", mappedBy="blogCategory")
     */
    protected $blogs;

    public function __toString() {
        return $this->getName();
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->blogs = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return BlogCategory
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
     * @return BlogCategory
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
     * Add blogs
     *
     * @param \MD\Bundle\CMSBundle\Entity\Blog $blogs
     * @return BlogCategory
     */
    public function addBlog(\MD\Bundle\CMSBundle\Entity\Blog $blogs) {
        $this->blogs[] = $blogs;

        return $this;
    }

    /**
     * Remove blogs
     *
     * @param \MD\Bundle\CMSBundle\Entity\Blog $blogs
     */
    public function removeBlog(\MD\Bundle\CMSBundle\Entity\Blog $blogs) {
        $this->blogs->removeElement($blogs);
    }

    /**
     * Get blogs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBlogs() {
        return $this->blogs;
    }

}
