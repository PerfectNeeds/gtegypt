<?php

namespace MD\Bundle\RecruitBundle\Controller\Administration;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MD\Bundle\RecruitBundle\Entity\CareerApplication;
use MD\Bundle\RecruitBundle\Form\CareerApplicationType;

/**
 * CareerApplication controller.
 *
 * @Route("/career-application")
 */
class CareerApplicationController extends Controller {

    /**
     * Lists all CareerApplication entities.
     *
     * @Route("/", name="careerapplication")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('RecruitBundle:CareerApplication')->findBy(array('deleted' => FALSE));

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new CareerApplication entity.
     *
     * @Route("/", name="careerapplication_create")
     * @Method("POST")
     * @Template("RecruitBundle:CareerApplication:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new CareerApplication();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('careerapplication_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a CareerApplication entity.
     *
     * @param CareerApplication $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CareerApplication $entity) {
        $form = $this->createForm(new CareerApplicationType(), $entity, array(
            'action' => $this->generateUrl('careerapplication_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new CareerApplication entity.
     *
     * @Route("/new", name="careerapplication_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new CareerApplication();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a CareerApplication entity.
     *
     * @Route("/{id}", name="careerapplication_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RecruitBundle:CareerApplication')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CareerApplication entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing CareerApplication entity.
     *
     * @Route("/{id}/edit", name="careerapplication_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RecruitBundle:CareerApplication')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CareerApplication entity.');
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
     * Creates a form to edit a CareerApplication entity.
     *
     * @param CareerApplication $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(CareerApplication $entity) {
        $form = $this->createForm(new CareerApplicationType(), $entity, array(
            'action' => $this->generateUrl('careerapplication_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Edits an existing CareerApplication entity.
     *
     * @Route("/{id}", name="careerapplication_update")
     * @Method("PUT")
     * @Template("RecruitBundle:CareerApplication:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RecruitBundle:CareerApplication')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CareerApplication entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('careerapplication_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a CareerApplication entity.
     *
     * @Route("/delete", name="careerapplication_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request) {
        $id = $this->getRequest()->request->get('id');
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('RecruitBundle:CareerApplication')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CareerApplication entity.');
        }
        if ($entity->getFirstDocuments()) {
            $document = new \MD\Bundle\MediaBundle\Entity\Document();
            $document->storeFilenameForRemove("curriculum-vitae/" . $entity->getId() . '/' . $entity->getFirstDocuments()->getId());
            $document->removeUpload();
            $document->storeDirectoryForRemove("curriculum-vitae/" . $entity->getId());
            $document->removeDirectory();
        }
        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('careerapplication'));
    }

    /**
     * Creates a form to delete a CareerApplication entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('careerapplication_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
