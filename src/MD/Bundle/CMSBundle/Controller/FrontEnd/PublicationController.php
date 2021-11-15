<?php

namespace MD\Bundle\CMSBundle\Controller\FrontEnd;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MD\Bundle\RecruitBundle\Entity\CareerApplication;
use MD\Bundle\RecruitBundle\Entity\CareerApplicationEducation;
use MD\Bundle\RecruitBundle\Entity\CareerApplicationInterest;
use MD\Bundle\RecruitBundle\Entity\CareerApplicationLanguage;
use Symfony\Component\HttpFoundation\RedirectResponse;
use MD\Utils\Validate;
use MD\Utils;

/**
 * HomePage controller.
 *
 * @Route("/recruit")
 */
class PublicationController extends Controller {

    /**
     * Lists all Home entities.
     *
     * @Route("/publications", name="fe_publication")
     * @Method("GET")
     * @Template()
     */
    public function publicationAction() {
        $em = $this->getDoctrine()->getManager();
        return array(
        );
    }
    
    /**
     * Lists all Home entities.
     *
     * @Route("/", name="fe_show_publication")
     * @Method("GET")
     * @Template()
     */
//    public function showPublicationAction() {
//        $em = $this->getDoctrine()->getManager();
//        return array(
//        );
//    }

}
