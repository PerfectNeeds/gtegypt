<?php

namespace MD\Bundle\CMSBundle\Controller\Administration;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MD\Bundle\CMSBundle\Entity\FaqCategory;
use MD\Bundle\CMSBundle\Form\FaqCategoryType;

/**
 * FaqCategory controller.
 *
 * @Route("/faq-category")
 */
class FaqCategoryController extends Controller {

    /**
     * Lists all FaqCategory entities.
     *
     * @Route("/", name="faqcategory")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CMSBundle:FaqCategory')->findBy(array('deleted' => FALSE));

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new FaqCategory entity.
     *
     * @Route("/", name="faqcategory_create")
     * @Method("POST")
     * @Template("CMSBundle:FaqCategory:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new FaqCategory();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('faqcategory'));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a FaqCategory entity.
     *
     * @param FaqCategory $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(FaqCategory $entity) {
        $form = $this->createForm(new FaqCategoryType(), $entity, array(
            'action' => $this->generateUrl('faqcategory_create'),
            'method' => 'POST',
        ));


        return $form;
    }

    /**
     * Displays a form to create a new FaqCategory entity.
     *
     * @Route("/new", name="faqcategory_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new FaqCategory();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing FaqCategory entity.
     *
     * @Route("/{id}/edit", name="faqcategory_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CMSBundle:FaqCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FaqCategory entity.');
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
     * Creates a form to edit a FaqCategory entity.
     *
     * @param FaqCategory $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(FaqCategory $entity) {
        $form = $this->createForm(new FaqCategoryType(), $entity, array(
            'action' => $this->generateUrl('faqcategory_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Edits an existing FaqCategory entity.
     *
     * @Route("/{id}", name="faqcategory_update")
     * @Method("PUT")
     * @Template("CMSBundle:FaqCategory:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CMSBundle:FaqCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FaqCategory entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('faqcategory_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a FaqCategory entity.
     *
     * @Route("/delete", name="faqcategory_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request) {
        $id = $this->getRequest()->request->get('id');
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:FaqCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FaqCategory entity.');
        }

        $entity->setDeleted(TRUE);
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('faqcategory'));
    }

    /**
     * Creates a form to delete a FaqCategory entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('faqcategory_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
