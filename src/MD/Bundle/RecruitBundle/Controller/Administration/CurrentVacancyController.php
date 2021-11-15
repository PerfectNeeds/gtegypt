<?php

namespace MD\Bundle\RecruitBundle\Controller\Administration;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MD\Bundle\RecruitBundle\Entity\CurrentVacancy;
use MD\Bundle\RecruitBundle\Form\CurrentVacancyType;

/**
 * CurrentVacancy controller.
 *
 * @Route("/current-vacancy")
 */
class CurrentVacancyController extends Controller {

    /**
     * Lists all CurrentVacancy entities.
     *
     * @Route("/", name="currentvacancy")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('RecruitBundle:CurrentVacancy')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new CurrentVacancy entity.
     *
     * @Route("/", name="currentvacancy_create")
     * @Method("POST")
     * @Template("RecruitBundle:CurrentVacancy:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new CurrentVacancy();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        $description = $this->getRequest()->request->get('description');
        $contentArray = array("description" => $description);
        $entity->setContent($contentArray);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('currentvacancy'));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a CurrentVacancy entity.
     *
     * @param CurrentVacancy $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CurrentVacancy $entity) {
        $form = $this->createForm(new CurrentVacancyType(), $entity, array(
            'action' => $this->generateUrl('currentvacancy_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new CurrentVacancy entity.
     *
     * @Route("/new", name="currentvacancy_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new CurrentVacancy();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a CurrentVacancy entity.
     *
     * @Route("/{id}", name="currentvacancy_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RecruitBundle:CurrentVacancy')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CurrentVacancy entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing CurrentVacancy entity.
     *
     * @Route("/{id}/edit", name="currentvacancy_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RecruitBundle:CurrentVacancy')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CurrentVacancy entity.');
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
     * Creates a form to edit a CurrentVacancy entity.
     *
     * @param CurrentVacancy $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(CurrentVacancy $entity) {
        $form = $this->createForm(new CurrentVacancyType(), $entity, array(
            'action' => $this->generateUrl('currentvacancy_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));


        return $form;
    }

    /**
     * Edits an existing CurrentVacancy entity.
     *
     * @Route("/{id}", name="currentvacancy_update")
     * @Method("PUT")
     * @Template("RecruitBundle:CurrentVacancy:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RecruitBundle:CurrentVacancy')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CurrentVacancy entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        $description = $this->getRequest()->request->get('description');
        $contentArray = array("description" => $description);
        $entity->setContent($contentArray);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('currentvacancy_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a CurrentVacancy entity.
     *
     * @Route("/delete", name="currentvacancy_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request) {
        $id = $this->getRequest()->request->get('id');
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('RecruitBundle:CurrentVacancy')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CurrentVacancy entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('currentvacancy'));
    }

    /**
     * Creates a form to delete a CurrentVacancy entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('currentvacancy_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
