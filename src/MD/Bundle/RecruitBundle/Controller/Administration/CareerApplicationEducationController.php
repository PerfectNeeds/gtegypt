<?php

namespace MD\Bundle\RecruitBundle\Controller\Administration;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MD\Bundle\RecruitBundle\Entity\CareerApplicationEducation;
use MD\Bundle\RecruitBundle\Form\CareerApplicationEducationType;

/**
 * CareerApplicationEducation controller.
 *
 * @Route("/careerapplicationeducation")
 */
class CareerApplicationEducationController extends Controller {

    /**
     * Lists all CareerApplicationEducation entities.
     *
     * @Route("/", name="careerapplicationeducation")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('RecruitBundle:CareerApplicationEducation')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new CareerApplicationEducation entity.
     *
     * @Route("/", name="careerapplicationeducation_create")
     * @Method("POST")
     * @Template("RecruitBundle:CareerApplicationEducation:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new CareerApplicationEducation();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('careerapplicationeducation_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a CareerApplicationEducation entity.
     *
     * @param CareerApplicationEducation $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CareerApplicationEducation $entity) {
        $form = $this->createForm(new CareerApplicationEducationType(), $entity, array(
            'action' => $this->generateUrl('careerapplicationeducation_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new CareerApplicationEducation entity.
     *
     * @Route("/new", name="careerapplicationeducation_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new CareerApplicationEducation();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a CareerApplicationEducation entity.
     *
     * @Route("/{id}", name="careerapplicationeducation_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RecruitBundle:CareerApplicationEducation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CareerApplicationEducation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing CareerApplicationEducation entity.
     *
     * @Route("/{id}/edit", name="careerapplicationeducation_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RecruitBundle:CareerApplicationEducation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CareerApplicationEducation entity.');
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
     * Creates a form to edit a CareerApplicationEducation entity.
     *
     * @param CareerApplicationEducation $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(CareerApplicationEducation $entity) {
        $form = $this->createForm(new CareerApplicationEducationType(), $entity, array(
            'action' => $this->generateUrl('careerapplicationeducation_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing CareerApplicationEducation entity.
     *
     * @Route("/{id}", name="careerapplicationeducation_update")
     * @Method("PUT")
     * @Template("RecruitBundle:CareerApplicationEducation:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RecruitBundle:CareerApplicationEducation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CareerApplicationEducation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('careerapplicationeducation_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a CareerApplicationEducation entity.
     *
     * @Route("/{id}", name="careerapplicationeducation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('RecruitBundle:CareerApplicationEducation')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CareerApplicationEducation entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('careerapplicationeducation'));
    }

    /**
     * Creates a form to delete a CareerApplicationEducation entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('careerapplicationeducation_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
