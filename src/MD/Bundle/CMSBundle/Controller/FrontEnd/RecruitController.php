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
class RecruitController extends Controller {

    /**
     * Lists all Home entities.
     *
     * @Route("/", name="fe_recruit")
     * @Method("GET")
     * @Template()
     */
    public function homeAction() {
        $em = $this->getDoctrine()->getManager();
        $careerInterests = $em->getRepository('RecruitBundle:CareerInterest')->findBy(array('deleted' => FALSE));
        $countries = $em->getRepository('RecruitBundle:Country')->findAll();

        $uploadForm = $this->createForm(new \MD\Bundle\MediaBundle\Form\SingleDocumentType());
        $formView = $uploadForm->createView();

        if ($this->getRequest()->query->get('pc')) {
            $positionCode = $this->getRequest()->query->get('pc');
        } else {
            $positionCode = '';
        }

        return array(
            'careerInterests' => $careerInterests,
            'countries' => $countries,
            'positionCode' => $positionCode,
            'entity' => NULL,
            'upload_form' => $formView,
        );
    }

    private function collectPost() {
        $data = $this->getRequest()->request->get('data');
        $recruit = new \stdClass();
        $recruit->positionName = $data['positionName'];
        $recruit->positionCode = $data['positionCode'];
        $recruit->fullName = $data['fullName'];
        $recruit->gender = $data['gender'];
        $recruit->email = $data['email'];
        $recruit->lastPosition = $data['lastPosition'];
        $recruit->education = $data['education'];
        $recruit->certificate = $data['certificate'];
        $recruit->city = $data['city'];
        $recruit->country = $data['country'];
        $recruit->lastSalary = $data['lastSalary'];
        $recruit->expectedSalary = $data['expectedSalary'];
        $recruit->yearsEx = $data['yearsEx'];
        $recruit->sector = $data['sector'];
        $recruit->address = $data['address'];
        $recruit->company = $data['company'];
        $recruit->file = $this->getRequest()->files->get('file');

        return $recruit;
    }

    private function validation($recruit) {
        $return = TRUE;
        $error = array();
        $reCaptcha = new \MD\Utils\ReCaptcha();
        $reCaptchaValidate = $reCaptcha->verifyResponse();
        if ($reCaptchaValidate->success == False) {
            $message = $this->get('translator')->trans("Invalid Captcha");
            array_push($error, $message);
        }
        if (!Validate::not_null($recruit->file)) {
            array_push($error, 'CV');
        }
        if (!Validate::not_null($recruit->positionName)) {
            array_push($error, 'position Name');
        }
        if (!Validate::not_null($recruit->fullName)) {
            array_push($error, 'full Name');
        }
        if (!Validate::not_null($recruit->country)) {
            array_push($error, 'country');
        }
        if (!Validate::not_null($recruit->email) OR ! Validate::email($recruit->email)) {
            array_push($error, 'valid email');
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
        }

        return $return;
    }

    /**
     * Lists all Home entities.
     *
     * @Route("/", name="fe_recruit_create")
     * @Method("POST")
     * @Template("CMSBundle:FrontEnd\Recruit:thanks.html.twig")
     */
    public function homeCreateAction() {
        $recruit = $this->collectPost();
        $validation = $this->validation($recruit);

        $em = $this->getDoctrine()->getManager();

        if ($validation !== TRUE) {
            $careerInterests = $em->getRepository('RecruitBundle:CareerInterest')->findBy(array('deleted' => FALSE));
            $countries = $em->getRepository('RecruitBundle:Country')->findAll();
            $uploadForm = $this->createForm(new \MD\Bundle\MediaBundle\Form\SingleDocumentType());
            $formView = $uploadForm->createView();

            return $this->render('CMSBundle:FrontEnd\Recruit:home.html.twig', array(
                        'errors' => $validation,
                        'recruit' => $recruit,
                        'careerInterests' => $careerInterests,
                        'countries' => $countries,
                        'upload_form' => $formView,
            ));
        }

        $careerApplication = new CareerApplication();

        $careerApplication->setPositionName($recruit->positionName);
        $careerApplication->setAddress($recruit->address);
        $careerApplication->setPositionCode($recruit->positionCode);
        $careerApplication->setFullName($recruit->fullName);
        $careerApplication->setEmail($recruit->email);
        $careerApplication->setGender($recruit->gender);
        $careerApplication->setLastPosition($recruit->lastPosition);
        $careerApplication->setEducation($recruit->education);
        $careerApplication->setCity($recruit->city);
        $careerApplication->setCertificate($recruit->certificate);
        $careerApplication->setLastSalary($recruit->lastSalary);
        $careerApplication->setExpectedSalary($recruit->expectedSalary);
        $careerApplication->setYearsEx($recruit->yearsEx);
        $careerApplication->setSector($recruit->sector);
        $country = $em->getRepository('RecruitBundle:Country')->find($recruit->country);
        $careerApplication->setCountry($country);
        $careerApplication->setCompany($recruit->company);
        $careerApplication->setState(1);
        $em->persist($careerApplication);
        $em->flush();


        $file = $recruit->file;
        $document = new \MD\Bundle\MediaBundle\Entity\Document($file);
        $em->persist($document);
        $em->flush();
        $document->preUpload();
        $document->upload("curriculum-vitae/" . $careerApplication->getId());
        $careerApplication->addDocument($document);
        $em->persist($careerApplication);

//        for ($i = 0; $i < count($recruit->careerInterest); $i++) {
//            if (Validate::not_null($recruit->careerInterest[$i])) {
//                $careerApplicationInterest = new CareerApplicationInterest();
//                $careerApplicationInterest->setCareerApplication($careerApplication);
//                $careerInterest = $em->getRepository('RecruitBundle:CareerInterest')->find($recruit->careerInterest[$i]);
//                $careerApplicationInterest->setCareerInterest($careerInterest);
//                $careerApplicationInterest->setLevel($recruit->careerInterestLevel[$i]);
//                $em->persist($careerApplicationInterest);
//            }
//        }
//        foreach ($recruit->careerEducation as $key => $value) {
//            if (Validate::not_null($value)) {
//                $careerApplicationEducation = new CareerApplicationEducation();
//                $careerApplicationEducation->setCareerApplication($careerApplication);
//                $careerEducationYear = Utils\Date::convertDateFormat('01/01/' . $recruit->careerEducationYear[$key], Utils\Date::DATE_FORMAT3, Utils\Date::DATE_FORMAT2);
//                $careerEducationYear = new \DateTime($careerEducationYear);
//                $careerApplicationEducation->setGradYear($careerEducationYear);
//                if ($key != CareerApplicationEducation::HighSchool) {
//                    if (Validate::not_null($recruit->careerEducationInstitution[$key])) {
//                        $careerApplicationEducation->setInstitution($recruit->careerEducationInstitution[$key]);
//                    }
//                }
//                $careerApplicationEducation->setName($value);
//                $careerApplicationEducation->setType($key);
//                $em->persist($careerApplicationEducation);
//            }
//        }
//
//        for ($i = 0; $i < count($recruit->careerLanguage); $i++) {
//            if (Validate::not_null($recruit->careerLanguage[$i])) {
//                $careerApplicationLanguage = new CareerApplicationLanguage();
//                $careerApplicationLanguage->setCareerApplication($careerApplication);
//                $careerApplicationLanguage->setName($recruit->careerLanguage[$i]);
//                $careerApplicationLanguage->setLevel($recruit->careerLanguageLevel[$i]);
//                $em->persist($careerApplicationLanguage);
//            }
//        }
        $em->flush();

        $name = $recruit->fullName;
        $email = $recruit->email;
        $subject = "New CV from " . $recruit->fullName;
        $cvLink = 'http://' . $this->getRequest()->server->get('HTTP_HOST') . $this->container->get('templating.helper.assets')->getUrl("") . 'download?d={"document":' . $document->getId() . ',"element":' . $careerApplication->getId() . ',"type":11}';

        // send to Admin

        $message = array(
            'subject' => 'GT-Egypt new CV',
            'from' => array('no-reply@gtegypt.org'),
            'to' => array('gtegyptcv@gmail.com'),
            //                'to' => array('remoonrafaat@gmail.com'),
            'body' => $this->renderView(
                    'CMSBundle:FrontEnd/Recruit:email.html.twig', array(
                'name' => $name,
                'email' => $email,
                'subject' => $subject,
                'cvLink' => $cvLink,
                    )
            )
        );
        \MD\Utils\Mailer::sendEmail($message);

//        $messageAdmin = \Swift_Message::newInstance()
//                ->setSubject('GT-Egypt new CV')
//                ->setFrom('info@gtegypt.org')
//                //->setTo('recruitment@gtegypt.org')
//                ->setTo('remoonrafaat@gmail.com')
//                ->setBody(
//                $this->renderView(
//                        'CMSBundle:FrontEnd/Recruit:email.html.twig', array(
//                    'name' => $name,
//                    'email' => $email,
//                    'subject' => $subject,
//                    'cvLink' => $cvLink,
//                        )
//                )
//                , 'text/html');
//        $this->get('mailer')->send($messageAdmin);


        return array();
//        return new RedirectResponse($this->generateUrl('fe_recruit_thanks'));
//        return new Response($this->renderView('CMSBundle:FrontEnd\Recruit:thanks.html.twig'));
//        return $this->redirect($this->generateUrl('fe_recruit_thanks'));
    }

    /**
     * Lists all Home entities.
     *
     * @Route("/thanks", name="fe_recruit_thanks")
     * @Method("GET")
     * @Template("CMSBundle:FrontEnd\Recruit:thanks.html.twig")
     */
    public function thanksAction() {

        return array(
        );
    }

    /**
     * Lists all Home entities.
     *
     * @Route("/employmet-at-gt-egypt", name="fe_employmet_at_gt")
     * @Method("GET")
     * @Template("CMSBundle:FrontEnd\Recruit:employmetAtGt.html.twig")
     */
    public function employmetAtGtAction() {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:DynamicPage')->findOneBy(array('htmlSlug' => 'employmet-at-gt-egypt'));
        return array(
            'page' => $entity,
        );
    }

    /**
     * Lists all Home entities.
     *
     * @Route("/work-ethics-and-values", name="fe_work_values")
     * @Method("GET")
     * @Template("CMSBundle:FrontEnd\Recruit:workValues.html.twig")
     */
    public function workValuesAction() {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:DynamicPage')->findOneBy(array('htmlSlug' => 'work-ethics-and-values'));
        return array(
            'page' => $entity,
        );
    }

    /**
     * Lists all Home entities.
     *
     * @Route("/current-vacancies", name="fe_current_vacancies")
     * @Method("GET")
     * @Template("CMSBundle:FrontEnd\Recruit:currentVacancies.html.twig")
     */
    public function currentVacanciesAction() {
        $em = $this->getDoctrine()->getManager();
        $currentVacancies = $em->getRepository('RecruitBundle:CurrentVacancy')->findBy(array(), array('id' => 'DESC'));
        return array(
            'currentVacancies' => $currentVacancies,
        );
    }

    /**
     * Lists all Home entities.
     *
     * @Route("/current-vacancies/{htmlSlug}", name="fe_current_vacancies_show")
     * @Method("GET")
     * @Template("CMSBundle:FrontEnd\Recruit:currentVacancyDetails.html.twig")
     */
    public function currentVacancyShowAction($htmlSlug) {
        $em = $this->getDoctrine()->getManager();
        $currentVacancy = $em->getRepository('RecruitBundle:CurrentVacancy')->findOneBy(array('htmlSlug' => $htmlSlug), array('id' => 'DESC'));
        return array(
            'currentVacancy' => $currentVacancy,
        );
    }

}
