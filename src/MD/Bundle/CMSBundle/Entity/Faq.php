<?php

namespace MD\Bundle\CMSBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Faq
 * @ORM\Table("faq")
 * @ORM\Entity
 */
class Faq {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="FaqCategory", inversedBy="faqs")
     */
    protected $faqCategory;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="question", type="text")
     */
    private $question;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="answer", type="text")
     */
    private $answer;

    /**
     *
     * @ORM\Column(name="deleted", type="boolean")
     */
    private $deleted = false;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set question
     *
     * @param string $question
     * @return Faq
     */
    public function setQuestion($question) {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return string
     */
    public function getQuestion() {
        return $this->question;
    }

    /**
     * Set answer
     *
     * @param string $answer
     * @return Faq
     */
    public function setAnswer($answer) {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return string
     */
    public function getAnswer() {
        return $this->answer;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return Faq
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
     * Set faqCategory
     *
     * @param \MD\Bundle\CMSBundle\Entity\FaqCategory $faqCategory
     * @return Faq
     */
    public function setFaqCategory(\MD\Bundle\CMSBundle\Entity\FaqCategory $faqCategory = null) {
        $this->faqCategory = $faqCategory;

        return $this;
    }

    /**
     * Get faqCategory
     *
     * @return \MD\Bundle\CMSBundle\Entity\FaqCategory
     */
    public function getFaqCategory() {
        return $this->faqCategory;
    }

}
