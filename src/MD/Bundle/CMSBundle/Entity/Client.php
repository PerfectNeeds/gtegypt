<?php

namespace MD\Bundle\CMSBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 * @ORM\Table("client")
 * @ORM\Entity
 */
class Client {

    const Flaged = 1;
    const NotFlaged = 0;

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
     * @ORM\Column(name="title", type="string", length=45)
     */
    private $title;

    /**
     * @var object
     *
     * @ORM\Column(name="content", type="json_array")
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
     * @ORM\Column(name="htmlMeta", type="string" , nullable=true)
     */
    protected $htmlMeta;

    /**
     * @ORM\ManyToMany(targetEntity="\MD\Bundle\MediaBundle\Entity\Image")
     */
    protected $images;

    /**
     * Set image
     *
     * @param \MD\Bundle\MediaBundle\Entity\Image $image
     * @return OurPartner
     */
    public function setImage(\MD\Bundle\MediaBundle\Entity\Image $image = null) {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \MD\Bundle\MediaBundle\Entity\Image
     */
    public function getImage() {
        return $this->image;
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
     * @return OurPartner
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
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Client
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param array $content
     * @return Client
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return array 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set htmlSlug
     *
     * @param string $htmlSlug
     * @return Client
     */
    public function setHtmlSlug($htmlSlug)
    {
        $this->htmlSlug = $htmlSlug;
    
        return $this;
    }

    /**
     * Get htmlSlug
     *
     * @return string 
     */
    public function getHtmlSlug()
    {
        return $this->htmlSlug;
    }

    /**
     * Set htmlMeta
     *
     * @param string $htmlMeta
     * @return Client
     */
    public function setHtmlMeta($htmlMeta)
    {
        $this->htmlMeta = $htmlMeta;
    
        return $this;
    }

    /**
     * Get htmlMeta
     *
     * @return string 
     */
    public function getHtmlMeta()
    {
        return $this->htmlMeta;
    }
}