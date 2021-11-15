<?php

namespace MD\Bundle\CMSBundle\Controller\FrontEnd;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MD\Utils\Validate;
/**
 * contactus controller.
 *
 * @Route("contactus")
 */
class ContactusController extends Controller {

    /**
     * Contactus form.
     *
     * @Route("/", name="fe_contact")
     * @Method("GET")
     * @Template()
     */
    public function contactAction() {
        return array(
        );
    }

    /**
     * Lists all Package entities.
     *
     * @Route("/thanks", name="fe_contact_submit")
     * @Method("POST")
     * @Template()
     */
    public function thankAction() {
        $name = $this->getRequest()->get('name');
        $email = $this->getRequest()->get('email');
        $mobile = $this->getRequest()->get('mobile');
        $subject = $this->getRequest()->get('subject');
        $msg = $this->getRequest()->get('message');
        $reCaptcha = new \MD\Utils\ReCaptcha();
        $reCaptchaValidate = $reCaptcha->verifyResponse();
        
        if ($reCaptchaValidate->success == False) {
             $this->getRequest()->getSession()->getFlashBag()->add('error', 'Invalid Captcha');
             return $this->redirect($this->generateUrl('fe_contact'));
        }
        $error= array();
        if (!Validate::not_null($name)) {
            array_push($error, 'name');
        }
        if (!Validate::not_null($email)) {
            array_push($error, 'email');
        }
        if (!Validate::not_null($mobile)) {
            array_push($error, 'mobile');
        }
        if (!Validate::not_null($subject)) {
            array_push($error, 'subject');
        }
        if (!Validate::not_null($msg)) {
            array_push($error, 'message');
        }
        if (count($error) > 0) {
            $return = 'You must enter ';
            for ($i = 0; $i < count($error); $i++) {
                if (count($error) == $i + 1) {
                    $return .= $error[$i];
                } else {
                    if (count($error) == $i + 2) {
                        $return .= $error[$i] . ' and ';
                    } else {
                        $return .= $error[$i] . ', ';
                    }
                }
            }
            $session = new Session();
            $session->getFlashBag()->add('error', $return);

            return $this->redirect($this->generateUrl('fe_contact'));
        }
        $messageHTML = $this->renderView(
                'CMSBundle:FrontEnd/Contactus:thankEmail.html.twig', array(
            'name' => $name
                )
        );
        \MD\Utils\Mailer::utf8mail($email, 'GT-Egypt Contact us Thanks', $messageHTML);

        $messageHTMLAdmin = $this->renderView(
                'CMSBundle:FrontEnd/Contactus:adminEmail.html.twig', array(
            'name' => $name,
            'email' => $email,
            'mobile' => $mobile,
            'subject' => $subject,
            'message' => $msg,
                )
        );
        \MD\Utils\Mailer::utf8mail('info@eg.gt.com', 'GT-Egypt Contact us from ' . $name, $messageHTMLAdmin);

//        $message = array(
//            'subject' => 'GT-Egypt Contact us Thanks',
//            'from' => array('hkaramany@gtegypt.org'),
//            'to' => array($email),
//            'cc' => array('peter.nassef@gmail.com'),
//            'body' => $this->renderView(
//                    'CMSBundle:FrontEnd/Contactus:thankEmail.html.twig', array(
//                'name' => $name
//                    )
//            )
//        );
//        \MD\Utils\Mailer::sendEmail($message);
//
//        $message = \Swift_Message::newInstance()
//                ->setSubject('GT-Egypt Contact us Thanks')
//                ->setFrom('no-reply@gtegypt.org')
//                ->setTo($email)
//                ->setBody(
//                $this->renderView(
//                        'CMSBundle:FrontEnd/Contactus:thankEmail.html.twig', array(
//                    'name' => $name
//                        )
//                )
//                , 'text/html');
//        $this->get('mailer')->send($message);
//        
        // send to Admin
//        $messageAdmin = array(
//            'subject' => 'GT-Egypt Contact us from ' . $name,
//            'from' => array('hkaramany@gtegypt.org'),
//            'to' => array('info@gtegypt.org'),
//            'body' => $this->renderView(
//                    'CMSBundle:FrontEnd/Contactus:adminEmail.html.twig', array(
//                'name' => $name,
//                'email' => $email,
//                'mobile' => $mobile,
//                'subject' => $subject,
//                'message' => $msg,
//                    )
//            )
//        );
//        \MD\Utils\Mailer::sendEmail($messageAdmin);
//        $messageAdmin = \Swift_Message::newInstance()
//                ->setSubject('GT-Egypt Contact us from ' . $name)
//                ->setFrom($email)
//                ->setTo('info@gtegypt.org')
//                ->setBody(
//                $this->renderView(
//                        'CMSBundle:FrontEnd/Contactus:adminEmail.html.twig', array(
//                    'name' => $name,
//                    'email' => $email,
//                    'mobile' => $mobile,
//                    'subject' => $subject,
//                    'message' => $msg,
//                        )
//                )
//                , 'text/html');
//        $this->get('mailer')->send($messageAdmin);

        return array(
            'name' => $name,
            'email' => $email
        );
    }

}
