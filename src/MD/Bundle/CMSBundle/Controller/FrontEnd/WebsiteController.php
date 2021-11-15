<?php

namespace MD\Bundle\CMSBundle\Controller\FrontEnd;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MD\Bundle\CMSBundle\Entity\Website;

/**
 * Website controller.
 *
 * @Route("/banner")
 */
class WebsiteController extends Controller {

    /**
     * Lists all Website entities.
     *
     * @Route("/", name="fe_website")
     * @Method("GET")
     * @Template()
     */
    public function WebsiteAction() {
        $em = $this->getDoctrine()->getManager();
        $websites = $em->getRepository('CMSBundle:Website')->findAll();

        return array(
            'websites' => $websites,
        );
    }

}
