<?php

namespace MD\Bundle\CMSBundle\Controller\Administration;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MD\Bundle\CMSBundle\Entity\Tab;
use MD\Bundle\CMSBundle\Form\TabType;

/**
 * Tab controller.
 *
 * @Route("/tab")
 */
class TabController extends Controller {

    /**
     * Lists all Tab entities.
     *
     * @Route("/", name="tab")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CMSBundle:Tab')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Tab entity.
     *
     * @Route("/", name="tab_create")
     * @Method("POST")
     * @Template("CMSBundle:Tab:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new Tab();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tab_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Tab entity.
     *
     * @param Tab $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Tab $entity) {
        $form = $this->createForm(new TabType(), $entity, array(
            'action' => $this->generateUrl('tab_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Tab entity.
     *
     * @Route("/new", name="tab_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new Tab();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Tab entity.
     *
     * @Route("/{id}", name="tab_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CMSBundle:Tab')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tab entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Tab entity.
     *
     * @Route("/{id}/edit", name="tab_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CMSBundle:Tab')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tab entity.');
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
     * Creates a form to edit a Tab entity.
     *
     * @param Tab $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Tab $entity) {
        $form = $this->createForm(new TabType(), $entity, array(
            'action' => $this->generateUrl('tab_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Tab entity.
     *
     * @Route("/{id}", name="tab_update")
     * @Method("PUT")
     * @Template("CMSBundle:Tab:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CMSBundle:Tab')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tab entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('tab_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Tab entity.
     *
     * @Route("/{id}", name="tab_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CMSBundle:Tab')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Tab entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tab'));
    }

    /**
     * Creates a form to delete a Tab entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('tab_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
