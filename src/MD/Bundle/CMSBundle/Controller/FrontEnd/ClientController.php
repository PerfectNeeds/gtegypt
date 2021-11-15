<?php

namespace MD\Bundle\CMSBundle\Controller\FrontEnd;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * HomePage controller.
 *
 * @Route("")
 */
class ClientController extends Controller {

    /**
     * Lists all Home entities.
     *
     * @Route("/client", name="fe_client")
     * @Method("GET")
     * @Template("CMSBundle:FrontEnd\Client:client.html.twig")
     */
    public function clientAction() {
        $em = $this->getDoctrine()->getManager();
        $clients = $em->getRepository('CMSBundle:Client')->findAll();
        return array(
            'clients' => $clients,
        );
    }

    /**
     * Lists all Home entities.
     *
     * @Route("/client/{htmlSlug}", name="fe_show_client")
     * @Method("GET")
     * @Template("CMSBundle:FrontEnd\Client:showClient.html.twig")
     */
    public function showPartnerAction($htmlSlug) {
        $em = $this->getDoctrine()->getManager();
        $clients = $em->getRepository('CMSBundle:Client')->findAll();
        $entity = $em->getRepository('CMSBundle:Client')->findOneBy(array('htmlSlug' => $htmlSlug));
        return array(
            'entity' => $entity,
            'clients' => $clients,
        );
    }

}
