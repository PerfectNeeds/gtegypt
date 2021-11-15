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
 * @Route("/issues")
 */
class IssuesController extends Controller {

    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/driving-growth", name="fe_drivingGrowth")
     * @Method("GET")
     * @Template()
     */
    public function drivingGrowthAction() {

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/international-growth", name="fe_internationalgrowth")
     * @Method("GET")
     * @Template()
     */
    public function internationalGrowthAction() {

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/mergers-and-acquisitions", name="fe_mergersandacquisitions")
     * @Method("GET")
     * @Template()
     */
    public function mergersAndAcquisitionsAction() {

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/managing-risk", name="fe_managingrisk")
     * @Method("GET")
     * @Template()
     */
    public function managingRiskAction() {

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/cybersecurity", name="fe_cybersecurityy")
     * @Method("GET")
     * @Template()
     */
    public function cybersecurityAction() {

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/third-party-risk", name="fe_thirdpartyrisk")
     * @Method("GET")
     * @Template()
     */
    public function thirdPartyRiskAction() {

        return array(
        );
    }

}
