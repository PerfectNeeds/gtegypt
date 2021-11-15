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
class HomePageController extends Controller {

    /**
     * Lists all Home entities.
     *
     * @Route("/", name="fe_home")
     * @Method("GET")
     * @Template()
     */
    public function homeAction() {
        $em = $this->getDoctrine()->getManager();
        $aboutUs = $em->getRepository('CMSBundle:DynamicPage')->find(4);
//        $ourPartners = $em->getRepository('CMSBundle:OurPartner')->findAll();
        $publications = $em->getRepository('CMSBundle:Publication')->findBy(array(), array('id' => 'DESC'), 3);
        $chairman = $em->getRepository('CMSBundle:OurPartner')->find(1);
        $blogs = $em->getRepository('CMSBundle:Blog')->findBy(array("deleted" => FALSE), array('created' => 'ASC'), 3);
        return array(
            'aboutUs' => $aboutUs,
//            'ourPartners' => $ourPartners,
            'publications' => $publications,
            'chairman' => $chairman,
            'blogs' => $blogs,
        );
    }

    /**
     * Lists all Home entities.
     *
     * @Route("/publications", name="fe_publications")
     * @Method("GET")
     * @Template("CMSBundle:FrontEnd\Publications:publications.html.twig")
     */
    public function publicationsAction() {
        $em = $this->getDoctrine()->getManager();
        $publications = $em->getRepository('CMSBundle:Publication')->findAll();
        return array(
            'publications' => $publications,
            'tabId' => 3,
        );
    }

    /**
     * Lists all Home entities.
     *
     * @Route("/about", name="fe_about_us")
     * @Method("GET")
     * @Template("CMSBundle:FrontEnd\OurPartner:about.html.twig")
     */
    public function aboutAction() {
        $em = $this->getDoctrine()->getManager();
        $ourPartners = $em->getRepository('CMSBundle:OurPartner')->findAll();
        $entity = $em->getRepository('CMSBundle:DynamicPage')->find(28);
        return array(
            'page' => $entity,
            'ourPartners' => $ourPartners,
        );
    }

    /**
     * Lists all Home entities.
     *
     * @Route("/fast-fact", name="fe_fast_fact")
     * @Method("GET")
     * @Template("CMSBundle:FrontEnd\OurPartner:fastFact.html.twig")
     */
    public function fastFactAction() {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:DynamicPage')->findOneBy(array('htmlSlug' => 'fast-fact'));
        return array(
            'page' => $entity,
        );
    }

    /**
     * Lists all Home entities.
     *
     * @Route("/brief", name="fe_brief")
     * @Method("GET")
     * @Template("CMSBundle:FrontEnd\OurPartner:brief.html.twig")
     */
    public function briefAction() {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:DynamicPage')->findOneBy(array('htmlSlug' => 'brief'));
        return array(
            'page' => $entity,
        );
    }

    /**
     * Lists all Home entities.
     *
     * @Route("/partner", name="fe_partner")
     * @Method("GET")
     * @Template("CMSBundle:FrontEnd\OurPartner:OurPartner.html.twig")
     */
    public function ourPartnerAction() {
        $em = $this->getDoctrine()->getManager();
        $ourPartners = $em->getRepository('CMSBundle:OurPartner')->findAll();
        return array(
            'ourPartners' => $ourPartners,
        );
    }

    /**
     * Lists all Home entities.
     *
     * @Route("/submit-rfp", name="fe_submit-rfp")
     * @Method("GET")
     * @Template("CMSBundle:FrontEnd\OurPartner:submitRFP.html.twig")
     */
    public function submitRFPAction() {
        return array(
        );
    }

    /**
     * Lists all Home entities.
     *
     * @Route("/submit-rfp", name="fe_submit_rfp_send")
     * @Method("POST")
     * @Template("CMSBundle:FrontEnd\OurPartner:submitRFP.html.twig")
     */
    public function submitRFPSendAction() {

        $reCaptcha = new \MD\Utils\ReCaptcha();
        $reCaptchaValidate = $reCaptcha->verifyResponse();
        if ($reCaptchaValidate->success == False) {
            $this->getRequest()->getSession()->getFlashBag()->add('error', 'Invalid Captcha');
            return $this->redirect($this->generateUrl('fe_submit-rfp'));
        }


        $attachment = FALSE;
        if (isset($_FILES['file']['tmp_name']) and ! empty($_FILES['file']['tmp_name'])) {
            $attachment = TRUE;
            $file = $_FILES['file']['tmp_name'];
            $fileMimeType = mime_content_type($file);
        }

        $first_name = $this->getRequest()->get('first_name');
        $last_name = $this->getRequest()->get('last_name');
        $company = $this->getRequest()->get('company');
        $address = $this->getRequest()->get('address');
        $city = $this->getRequest()->get('city');
        $zip = $this->getRequest()->get('zip');
        $email = $this->getRequest()->get('email');
        $phone = $this->getRequest()->get('phone');
        $comments = $this->getRequest()->get('comments');

        $message = \Swift_Message::newInstance()
                ->setSubject('GT-Egypt Received RFP')
                ->setFrom('info@eg.gt.com')
                ->setTo('info@eg.gt.com')
                ->setBody(
                $this->renderView(
                        'CMSBundle:FrontEnd/OurPartner:thankEmail.html.twig', array(
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'company' => $company,
                    'address' => $address,
                    'city' => $city,
                    'zip' => $zip,
                    'email' => $email,
                    'phone' => $phone,
                    'comments' => $comments,
                        )
                )
                , 'text/html');
        if ($attachment) {
            $message->attach(\Swift_Attachment::fromPath($file, $fileMimeType));
        }

        $this->get('mailer')->send($message);
        $session = new \Symfony\Component\HttpFoundation\Session\Session();
        $session->getFlashBag()->add('success', 'Send Successfully');
        return $this->redirect($this->generateUrl('fe_submit-rfp'));
    }

    /**
     * Lists all Home entities.
     *
     * @Route("/partner/{htmlSlug}", name="fe_show_partner")
     * @Method("GET")
     * @Template("CMSBundle:FrontEnd\OurPartner:showPartner.html.twig")
     */
    public function showPartnerAction($htmlSlug) {
        $em = $this->getDoctrine()->getManager();
        $ourPartners = $em->getRepository('CMSBundle:OurPartner')->findAll();
        $entity = $em->getRepository('CMSBundle:OurPartner')->findOneBy(array('htmlSlug' => $htmlSlug));
        return array(
            'entity' => $entity,
            'ourPartners' => $ourPartners,
        );
    }

    /**
     * aboutUs entity.
     *
     * @Route("/about-us", name="fe_about_us_widget")
     * @Method("GET")
     * @Template("CMSBundle:FrontEnd\HomePage:aboutUs.html.twig")
     */
    public function AboutUsWidgetAction() {
        $em = $this->getDoctrine()->getManager();
        $aboutUs = $em->getRepository('CMSBundle:DynamicPage')->find(4);
        return array(
            'aboutUs' => $aboutUs,
        );
    }

    /**
     * aboutUs entity.
     *
     * @Route("/partners-widget", name="fe_partners_widget")
     * @Method("GET")
     * @Template("CMSBundle:FrontEnd\HomePage:partnerWidget.html.twig")
     */
    public function partnerWidgetAction() {
        $em = $this->getDoctrine()->getManager();
        $ourPartners = $em->getRepository('CMSBundle:OurPartner')->findAll();
        return array(
            'ourPartners' => $ourPartners,
        );
    }

    /**
     * servic entity.
     *
     * @Route("/servic-widget", name="fe_servic_widget")
     * @Method("GET")
     * @Template("CMSBundle:FrontEnd\HomePage:serviceWidget.html.twig")
     */
    public function serviceWidgetAction() {
        $em = $this->getDoctrine()->getManager();
        $services = $em->getRepository('CMSBundle:Menu')->getParentsByTabId(2);
        return array(
            'services' => $services,
        );
    }

    /**
     * @Route("/test")
     * @Method("POST|GET")
     * @Template()
     */
    public function testAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

//        $transport = \Swift_SmtpTransport::newInstance('alex-app.com', 25)
        $transport = \Swift_SmtpTransport::newInstance('41.187.100.24', 25)
                ->setUsername('no-reply@gtegypt.org')
                ->setPassword('Pj8stsBFt5')
//                ->setEncryption('tls')
//                ->setTimeout('10')
        ;
        $mailer = \Swift_Mailer::newInstance($transport);

        $message = \Swift_Message::newInstance()
                ->setSubject('Test')
                ->setFrom("no-reply@gtegypt.org")
                ->setTo("peter.nassef@gmail.com")
                ->setBody(
                "<h1>hello</h1>", 'text/html'
        );
        $tt = $mailer->send($message);
        var_dump($tt);
//        $this->get("mailer")->send($message);
        return new Response("");
    }

}
