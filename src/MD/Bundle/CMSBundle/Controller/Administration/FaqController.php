<?php

namespace MD\Bundle\CMSBundle\Controller\Administration;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MD\Bundle\CMSBundle\Entity\Faq;
use MD\Bundle\CMSBundle\Form\FaqType;

/**
 * Faq controller.
 *
 * @Route("/faq")
 */
class FaqController extends Controller {

    /**
     * Lists all Faq entities.
     *
     * @Route("/{cId}", name="faq")
     * @Method("GET")
     * @Template()
     */
    public function indexAction($cId) {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CMSBundle:Faq')->findBy(array('faqCategory' => $cId, 'deleted' => FALSE));
        $faqCategory = $em->getRepository('CMSBundle:FaqCategory')->find($cId);

        return array(
            'entities' => $entities,
            'faqCategory' => $faqCategory,
        );
    }

    /**
     * Creates a new Faq entity.
     *
     * @Route("/{cId}", name="faq_create")
     * @Method("POST")
     * @Template("CMSBundle:Administration/Faq:new.html.twig")
     */
    public function createAction(Request $request, $cId) {
        $entity = new Faq();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $faqCategory = $em->getRepository('CMSBundle:FaqCategory')->find($cId);

        $entity->setFaqCategory($faqCategory);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('faq', array('cId' => $faqCategory->getId())));
        }

        return array(
            'entity' => $entity,
            'faqCategory' => $faqCategory,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Faq entity.
     *
     * @param Faq $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Faq $entity) {
        $form = $this->createForm(new FaqType(), $entity, array(
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Faq entity.
     *
     * @Route("/new/{cId}", name="faq_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($cId) {
        $entity = new Faq();
        $form = $this->createCreateForm($entity);

        $em = $this->getDoctrine()->getManager();
        $faqCategory = $em->getRepository('CMSBundle:FaqCategory')->find($cId);
        return array(
            'entity' => $entity,
            'faqCategory' => $faqCategory,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Faq entity.
     *
     * @Route("/{id}/edit", name="faq_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CMSBundle:Faq')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Faq entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Faq entity.
     *
     * @param Faq $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Faq $entity) {
        $form = $this->createForm(new FaqType(), $entity, array(
            'action' => $this->generateUrl('faq_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));


        return $form;
    }

    /**
     * Edits an existing Faq entity.
     *
     * @Route("/{id}", name="faq_update")
     * @Method("PUT")
     * @Template("CMSBundle:Faq:Administration/edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CMSBundle:Faq')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Faq entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('faq_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Faq entity.
     *
     * @Route("/delete/{cId}", name="faq_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $cId) {
        $id = $this->getRequest()->request->get('id');
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:Faq')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Faq entity.');
        }

        $entity->setDeleted(TRUE);
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('faq', array('cId' => $entity->getFaqCategory()->getId())));
    }

    /**
     * Creates a form to delete a Faq entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
