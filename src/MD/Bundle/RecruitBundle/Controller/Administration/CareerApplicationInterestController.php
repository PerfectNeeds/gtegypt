<?php

namespace MD\Bundle\RecruitBundle\Controller\Administration;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MD\Bundle\RecruitBundle\Entity\CareerApplicationInterest;
use MD\Bundle\RecruitBundle\Form\CareerApplicationInterestType;

/**
 * CareerApplicationInterest controller.
 *
 * @Route("/careerapplicationinterest")
 */
class CareerApplicationInterestController extends Controller {

    /**
     * Lists all CareerApplicationInterest entities.
     *
     * @Route("/", name="careerapplicationinterest")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('RecruitBundle:CareerApplicationInterest')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new CareerApplicationInterest entity.
     *
     * @Route("/", name="careerapplicationinterest_create")
     * @Method("POST")
     * @Template("RecruitBundle:CareerApplicationInterest:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new CareerApplicationInterest();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('careerapplicationinterest_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a CareerApplicationInterest entity.
     *
     * @param CareerApplicationInterest $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CareerApplicationInterest $entity) {
        $form = $this->createForm(new CareerApplicationInterestType(), $entity, array(
            'action' => $this->generateUrl('careerapplicationinterest_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new CareerApplicationInterest entity.
     *
     * @Route("/new", name="careerapplicationinterest_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new CareerApplicationInterest();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a CareerApplicationInterest entity.
     *
     * @Route("/{id}", name="careerapplicationinterest_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RecruitBundle:CareerApplicationInterest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CareerApplicationInterest entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing CareerApplicationInterest entity.
     *
     * @Route("/{id}/edit", name="careerapplicationinterest_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RecruitBundle:CareerApplicationInterest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CareerApplicationInterest entity.');
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
     * Creates a form to edit a CareerApplicationInterest entity.
     *
     * @param CareerApplicationInterest $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(CareerApplicationInterest $entity) {
        $form = $this->createForm(new CareerApplicationInterestType(), $entity, array(
            'action' => $this->generateUrl('careerapplicationinterest_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing CareerApplicationInterest entity.
     *
     * @Route("/{id}", name="careerapplicationinterest_update")
     * @Method("PUT")
     * @Template("RecruitBundle:CareerApplicationInterest:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RecruitBundle:CareerApplicationInterest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CareerApplicationInterest entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('careerapplicationinterest_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a CareerApplicationInterest entity.
     *
     * @Route("/{id}", name="careerapplicationinterest_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('RecruitBundle:CareerApplicationInterest')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CareerApplicationInterest entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('careerapplicationinterest'));
    }

    /**
     * Creates a form to delete a CareerApplicationInterest entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('careerapplicationinterest_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
