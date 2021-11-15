<?php

namespace MD\Bundle\RecruitBundle\Controller\Administration;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MD\Bundle\RecruitBundle\Entity\CareerInterest;
use MD\Bundle\RecruitBundle\Form\CareerInterestType;

/**
 * CareerInterest controller.
 *
 * @Route("/careerinterest")
 */
class CareerInterestController extends Controller {

    /**
     * Lists all CareerInterest entities.
     *
     * @Route("/", name="careerinterest")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('RecruitBundle:CareerInterest')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new CareerInterest entity.
     *
     * @Route("/", name="careerinterest_create")
     * @Method("POST")
     * @Template("RecruitBundle:CareerInterest:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new CareerInterest();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('careerinterest_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a CareerInterest entity.
     *
     * @param CareerInterest $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CareerInterest $entity) {
        $form = $this->createForm(new CareerInterestType(), $entity, array(
            'action' => $this->generateUrl('careerinterest_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new CareerInterest entity.
     *
     * @Route("/new", name="careerinterest_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new CareerInterest();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a CareerInterest entity.
     *
     * @Route("/{id}", name="careerinterest_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RecruitBundle:CareerInterest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CareerInterest entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing CareerInterest entity.
     *
     * @Route("/{id}/edit", name="careerinterest_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RecruitBundle:CareerInterest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CareerInterest entity.');
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
     * Creates a form to edit a CareerInterest entity.
     *
     * @param CareerInterest $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(CareerInterest $entity) {
        $form = $this->createForm(new CareerInterestType(), $entity, array(
            'action' => $this->generateUrl('careerinterest_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing CareerInterest entity.
     *
     * @Route("/{id}", name="careerinterest_update")
     * @Method("PUT")
     * @Template("RecruitBundle:CareerInterest:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RecruitBundle:CareerInterest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CareerInterest entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('careerinterest_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a CareerInterest entity.
     *
     * @Route("/{id}", name="careerinterest_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('RecruitBundle:CareerInterest')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CareerInterest entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('careerinterest'));
    }

    /**
     * Creates a form to delete a CareerInterest entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('careerinterest_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
