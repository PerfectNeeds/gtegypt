<?php

namespace MD\Bundle\CMSBundle\Controller\Administration;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MD\Bundle\CMSBundle\Entity\BlogCategory;
use MD\Bundle\CMSBundle\Form\BlogCategoryType;

/**
 * BlogCategory controller.
 *
 * @Route("/blogcategory")
 */
class BlogCategoryController extends Controller {

    /**
     * Lists all BlogCategory entities.
     *
     * @Route("/", name="blogcategory")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CMSBundle:BlogCategory')->findBy(array('deleted' => FALSE));

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new BlogCategory entity.
     *
     * @Route("/", name="blogcategory_create")
     * @Method("POST")
     * @Template("CMSBundle:BlogCategory:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new BlogCategory();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('blogcategory'));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a BlogCategory entity.
     *
     * @param BlogCategory $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(BlogCategory $entity) {
        $form = $this->createForm(new BlogCategoryType(), $entity, array(
            'action' => $this->generateUrl('blogcategory_create'),
            'method' => 'POST',
        ));


        return $form;
    }

    /**
     * Displays a form to create a new BlogCategory entity.
     *
     * @Route("/new", name="blogcategory_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new BlogCategory();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing BlogCategory entity.
     *
     * @Route("/{id}/edit", name="blogcategory_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CMSBundle:BlogCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BlogCategory entity.');
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
     * Creates a form to edit a BlogCategory entity.
     *
     * @param BlogCategory $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(BlogCategory $entity) {
        $form = $this->createForm(new BlogCategoryType(), $entity, array(
            'action' => $this->generateUrl('blogcategory_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Edits an existing BlogCategory entity.
     *
     * @Route("/{id}", name="blogcategory_update")
     * @Method("PUT")
     * @Template("CMSBundle:BlogCategory:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CMSBundle:BlogCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BlogCategory entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('blogcategory_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a BlogCategory entity.
     *
     * @Route("/delete", name="blogcategory_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request) {
        $id = $this->getRequest()->request->get('id');
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:BlogCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BlogCategory entity.');
        }

        $entity->setDeleted(TRUE);
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('blogcategory'));
    }

    /**
     * Creates a form to delete a BlogCategory entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
