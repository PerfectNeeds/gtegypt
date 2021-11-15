<?php

namespace MD\Bundle\CMSBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Blog
 * @ORM\Table("blog")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity
 */
class Blog {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="BlogCategory", inversedBy="blogs")
     */
    protected $blogCategory;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=45)
     */
    private $title;

    /**
     * @var object
     *
     * @ORM\Column(name="content", type="object")
     */
    private $content;

    /**
     * @var string
     * @ORM\Column(name="htmlSlug", type="string", length=255, unique=true)
     */
    protected $htmlSlug;

    /**
     * @var string
     *
     * @ORM\Column(name="htmlMeta", type="string", length=255)
     */
    protected $htmlMeta;

    /**
     *
     * @ORM\Column(name="deleted", type="boolean")
     */
    private $deleted = false;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\ManyToMany(targetEntity="\MD\Bundle\MediaBundle\Entity\Image")
     */
    protected $images;

    /**
     * Now we tell doctrine that before we persist or update we call the updatedTimestamps() function.
     *
     * @ORM\PrePersist
     */
    public function updatedTimestamps() {
        $this->setCreated(new \DateTime(date('Y-m-d H:i:s')));

        if ($this->getCreated() == null) {
            $this->setCreated(new \DateTime(date('Y-m-d H:i:s')));
        }
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
     * Set title
     *
     * @param string $title
     * @return Blog
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param array $content
     * @return Blog
     */
    public function setContent($content) {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return array
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * Set htmlSlug
     *
     * @param string $htmlSlug
     * @return Blog
     */
    public function setHtmlSlug($htmlSlug) {
        $this->htmlSlug = $htmlSlug;

        return $this;
    }

    /**
     * Get htmlSlug
     *
     * @return string
     */
    public function getHtmlSlug() {
        return $this->htmlSlug;
    }

    /**
     * Set htmlMeta
     *
     * @param string $htmlMeta
     * @return Blog
     */
    public function setHtmlMeta($htmlMeta) {
        $this->htmlMeta = $htmlMeta;

        return $this;
    }

    /**
     * Get htmlMeta
     *
     * @return string
     */
    public function getHtmlMeta() {
        return $this->htmlMeta;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return Blog
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
     * Set created
     *
     * @param \DateTime $created
     * @return CareerApplication
     */
    public function setCreated($created) {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * Set image
     *
     * @param \MD\Bundle\MediaBundle\Entity\Image $image
     * @return DynamicPage
     */
    public function setImage(\MD\Bundle\MediaBundle\Entity\Image $image = null) {
        $this->images[0] = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \MD\Bundle\MediaBundle\Entity\Image
     */
    public function getImage() {
        return $this->images[0];
    }

    /**
     * Get Main Image
     *
     * @return MD\Bundle\MediaBundle\Entity\Image
     */
    public function getMainImage() {
        return $this->getImages(array(\MD\Bundle\MediaBundle\Entity\Image::TYPE_MAIN))->first();
    }

    /**
     * Add images
     *
     * @param \MD\Bundle\MediaBundle\Entity\Image $images
     * @return DynamicPage
     */
    public function addImage(\MD\Bundle\MediaBundle\Entity\Image $images) {
        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \MD\Bundle\MediaBundle\Entity\Image $images
     */
    public function removeImage(\MD\Bundle\MediaBundle\Entity\Image $images) {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages() {
        return $this->images;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set blogCategory
     *
     * @param \MD\Bundle\CMSBundle\Entity\BlogCategory $blogCategory
     * @return Blog
     */
    public function setBlogCategory(\MD\Bundle\CMSBundle\Entity\BlogCategory $blogCategory = null) {
        $this->blogCategory = $blogCategory;

        return $this;
    }

    /**
     * Get blogCategory
     *
     * @return \MD\Bundle\CMSBundle\Entity\BlogCategory
     */
    public function getBlogCategory() {
        return $this->blogCategory;
    }

}
