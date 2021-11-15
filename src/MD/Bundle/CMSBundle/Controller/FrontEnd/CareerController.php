<?php

namespace MD\Bundle\CMSBundle\Controller\FrontEnd;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MD\Bundle\CMSBundle\Entity\DynamicPage;

/**
 * DynamicPage controller.
 *
 * @Route("/career")
 */
class CareerController extends Controller {

    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/careers", name="fe_career")
     * @Method("GET")
     * @Template()
     */
    public function careerAction() {

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/why-grant-thornton", name="fe_why-grant-thornton")
     * @Method("GET")
     * @Template()
     */
    public function whyGrantThorntonAction() {

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/for-students", name="fe_for-students")
     * @Method("GET")
     * @Template()
     */
    public function forStudentsAction() {

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/for-professionals", name="fe_for-professionals")
     * @Method("GET")
     * @Template()
     */
    public function forProfessionalsAction() {

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/our-stories", name="fe_our-stories")
     * @Method("GET")
     * @Template()
     */
    public function ourStoriesAction() {

        return array(
        );
    }
    
}
