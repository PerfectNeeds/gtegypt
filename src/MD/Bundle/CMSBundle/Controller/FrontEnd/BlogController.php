<?php

namespace MD\Bundle\CMSBundle\Controller\FrontEnd;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MD\Bundle\CMSBundle\Entity\Blog;

/**
 * Blog controller.
 *
 * @Route("/news")
 */
class BlogController extends Controller {

    /**
     * Lists all Blog entities.
     *
     * @Route("/", name="fe_blog")
     * @Method("GET")
     * @Template()
     */
    public function BlogAction() {
        $em = $this->getDoctrine()->getManager();
        $blogs = $em->getRepository('CMSBundle:Blog')->findBy(array("deleted" => FALSE), array('created' => 'ASC'));

        return array(
            'blogs' => $blogs,
        );
    }

    /**
     * Lists all Blog entities.
     *
     * @Route("/{htmlSlug}", name="fe_show_blog")
     * @Method("GET")
     * @Template()
     */
    public function showBlogAction($htmlSlug) {
        $em = $this->getDoctrine()->getManager();
        $blog = $em->getRepository('CMSBundle:Blog')->findOneBy(array('htmlSlug' => $htmlSlug));

        return array(
            'blog' => $blog,
        );
    }

}
