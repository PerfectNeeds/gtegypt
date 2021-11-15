<?php

namespace MD\Bundle\CMSBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * OurPartner
 * @ORM\Table("our_partner")
 * @ORM\Entity
 */
class OurPartner {

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
     * @var string
     *
     * @ORM\Column(name="position", type="string", length=45)
     */
    private $position;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=45)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=200)
     */
    private $email;

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
     * @ORM\Column(name="htmlTitle", type="string", length=45)
     */
    protected $htmlTitle;

    /**
     *
     * @ORM\Column(name="flag", type="boolean", options={"default" = 0}))
     */
    private $flag = false;

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
     * @ORM\ManyToMany(targetEntity="\MD\Bundle\MediaBundle\Entity\Document")
     */
    protected $documents;

    /**
     * Constructor
     */
    public function __construct() {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->documents = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return OurPartner
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
     * Set position
     *
     * @param string $position
     * @return Team
     */
    public function setPosition($position) {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string 
     */
    public function getPosition() {
        return $this->position;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     * @return OurPartner
     */
    public function setTelephone($telephone) {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone() {
        return $this->telephone;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return OurPartner
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set content
     *
     * @param array $content
     * @return OurPartner
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
     * @return OurPartner
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
     * Set htmlTitle
     *
     * @param string $htmlTitle
     * @return OurPartner
     */
    public function setHtmlTitle($htmlTitle) {
        $this->htmlTitle = $htmlTitle;

        return $this;
    }

    /**
     * Get htmlTitle
     *
     * @return string
     */
    public function getHtmlTitle() {
        return $this->htmlTitle;
    }

    /**
     * Set flag
     *
     * @param boolean $flag
     * @return OurPartner
     */
    public function setFlag($flag) {
        $this->flag = $flag;

        return $this;
    }

    /**
     * Get flag
     *
     * @return boolean
     */
    public function getFlag() {
        return $this->flag;
    }

    /**
     * Set htmlMeta
     *
     * @param string $htmlMeta
     * @return OurPartner
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
     * Add documents
     *
     * @param \MD\Bundle\MediaBundle\Entity\Document $documents
     * @return OurPartner
     */
    public function addDocument(\MD\Bundle\MediaBundle\Entity\Document $documents) {
        $this->documents[] = $documents;

        return $this;
    }

    /**
     * Remove documents
     *
     * @param \MD\Bundle\MediaBundle\Entity\Document $documents
     */
    public function removeDocument(\MD\Bundle\MediaBundle\Entity\Document $documents) {
        $this->documents->removeElement($documents);
    }

    /**
     * Get documents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocuments() {
        return $this->documents;
    }

}
