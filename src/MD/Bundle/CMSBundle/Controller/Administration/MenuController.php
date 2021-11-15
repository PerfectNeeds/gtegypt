<?php

namespace MD\Bundle\CMSBundle\Controller\Administration;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MD\Bundle\CMSBundle\Entity\MenuItem;
use MD\Bundle\CMSBundle\Entity\MenuParent;
use MD\Bundle\CMSBundle\Entity\Menu;
use MD\Bundle\CMSBundle\Form\MenuType;
use MD\Utils\Validate;

/**
 * Menu controller.
 *
 * @Route("/menu")
 */
class MenuController extends Controller {

    /**
     * Lists all Menu entities.
     *
     * @Route("/", name="menu")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CMSBundle:Menu')->getParents();
        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Menu entity.
     *
     * @Route("/", name="menu_create")
     * @Method("POST")
     * @Template("CMSBundle:Menu:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new Menu();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('menu'));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Menu entity.
     *
     * @param Menu $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Menu $entity) {
        $form = $this->createForm(new MenuType(), $entity, array(
            'action' => $this->generateUrl('menu_create'),
            'method' => 'POST',
        ));


        return $form;
    }

    /**
     * Displays a form to create a new Menu entity.
     *
     * @Route("/new", name="menu_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new Menu();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Menu entity.
     *
     * @Route("/{id}/edit", name="menu_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CMSBundle:Menu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
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
     * Creates a form to edit a Menu entity.
     *
     * @param Menu $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Menu $entity) {
        $form = $this->createForm(new MenuType(), $entity, array(
            'action' => $this->generateUrl('menu_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));


        return $form;
    }

    private function collectPost() {
        $data = $this->getRequest()->request->get('data');
        $menuChild = new \stdClass();
        $menuChild->url = $data['url'];
        if (Validate::not_null($menuChild->url)) {
            if (isset($data['target']) AND Validate::not_null($data['target'])) {
                $menuChild->target = $data['target'];
            } else {
                $menuChild->target = MenuItem::INTERNAL;
            }
        } else {
            $menuChild->url = NULL;
            $menuChild->target = NULL;
        }

        return $menuChild;
    }

    /**
     * Edits an existing Menu entity.
     *
     * @Route("/{id}", name="menu_update")
     * @Method("PUT")
     * @Template("CMSBundle:Menu:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $menuChild = $this->collectPost();
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CMSBundle:Menu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $menuItemEntity = $em->getRepository('CMSBundle:MenuItem')->find($entity->getId());
            if ($menuChild->url != NUll) {
                if (!$menuItemEntity) {
                    $menuItemEntity = new MenuItem();
                    $menuItemEntity->setMenu($entity);
                    $menuItemEntity->setUrl($menuChild->url);
                    $menuItemEntity->setTarget($menuChild->target);
                } else {
                    $menuItemEntity->setUrl($menuChild->url);
                    $menuItemEntity->setTarget($menuChild->target);
                }
                $em->persist($menuItemEntity);
            } else {
                if ($menuChild->url == NUll AND $entity->getFirstMenuItems()->getUrl() != NULL) {
                    $em->remove($menuItemEntity);
                }
            }
            $em->flush();

            return $this->redirect($this->generateUrl('menu_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Menu entity.
     *
     * @Route("/delete", name="menu_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request) {
        $id = $this->getRequest()->request->get('id');
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:Menu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
        }

        $entity->setDeleted(TRUE);
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('menu'));
    }

    /**
     * Creates a form to delete a Menu entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('menu_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

    /**
     * Lists all Menu entities.
     *
     * @Route("/{id}/child", name="menu_child")
     * @Method("GET")
     * @Template("CMSBundle:Administration/Menu:index.html.twig")
     */
    public function childListAction($id) {
        $em = $this->getDoctrine()->getManager();


        $menuParent = $em->getRepository('CMSBundle:Menu')->getParent($id);
        if ($menuParent != FALSE) {
            $menuParent = $menuParent->getFirstMenuParents()->getParent()->getId();
        }
        $entities = $em->getRepository('CMSBundle:Menu')->getChilds($id);
        return array(
            'entities' => $entities,
            'menuParent' => $menuParent,
            'pageId' => $id,
        );
    }

    private function collectChildPost() {
        $data = $this->getRequest()->request->get('data');
        $menuChild = new \stdClass();
        $menuChild->name = $data['name'];
        $menuChild->url = $data['url'];
        if (Validate::not_null($menuChild->url)) {
            if (isset($data['target']) AND Validate::not_null($data['target'])) {
                $menuChild->target = $data['target'];
            } else {
                $menuChild->target = MenuItem::INTERNAL;
            }
        } else {
            $menuChild->url = NULL;
            $menuChild->target = NULL;
        }

        return $menuChild;
    }

    /**
     * Creates a new Menu Child entity.
     *
     * @Route("/{id}/child", name="menu_create_child")
     * @Method("POST")
     * @Template("CMSBundle:Administration/Menu:newChild.html.twig")
     */
    public function createChildAction($id) {
        $entity = new Menu();
        $menuChild = $this->collectChildPost();

        $em = $this->getDoctrine()->getManager();
        $entity->setName($menuChild->name);
        $entity->setTab(NULL);
        $em->persist($entity);
        $em->flush();

        $menuParentEntity = new MenuParent();
        $menuParentEntity->setChild($entity);
        $parentEntity = $em->getRepository('CMSBundle:Menu')->find($id);
        $menuParentEntity->setParent($parentEntity);
        $em->persist($menuParentEntity);
        $em->flush();

        if ($menuChild->url != NUll) {
            $menuItemEntity = new MenuItem();
            $menuItemEntity->setMenu($entity);
            $menuItemEntity->setUrl($menuChild->url);
            $menuItemEntity->setTarget($menuChild->target);
            $em->persist($menuItemEntity);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('menu_child', array('id' => $id)));

        return array(
            'entity' => $entity,
            'pageId' => $id,
        );
    }

    /**
     * Displays a form to create child a new Menu entity.
     *
     * @Route("/{id}/new-child", name="menu_new_child")
     * @Method("GET")
     * @Template()
     */
    public function newChildAction($id) {
        $entity = new Menu();

        return array(
            'entity' => $entity,
            'pageId' => $id,
        );
    }

    /**
     * Edits an existing MenuChild entity.
     *
     * @Route("/{id}/update-child", name="menu_update_child")
     * @Method("PUT")
     * @Template("CMSBundle:Menu:edit.html.twig")
     */
    public function updateChildAction($id) {
        $menuChild = $this->collectChildPost();

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CMSBundle:Menu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
        }

        $entity->setName($menuChild->name);
        $em->persist($entity);


        if ($menuChild->url != NUll) {
            $menuItemEntity = $em->getRepository('CMSBundle:MenuItem')->find($entity->getId());

            if (!$menuItemEntity) {
                $menuItemEntity = new MenuItem();
                $menuItemEntity->setMenu($entity);
                $menuItemEntity->setUrl($menuChild->url);
                $menuItemEntity->setTarget($menuChild->target);
            } else {
                $menuItemEntity->setUrl($menuChild->url);
                $menuItemEntity->setTarget($menuChild->target);
            }
            $em->persist($menuItemEntity);
        }

        $em->flush();

        return $this->redirect($this->generateUrl('menu_edit_child', array('id' => $id)));

        return array(
            'entity' => $entity,
        );
    }

    /**
     * Displays a form to edit child an existing Menu entity.
     *
     * @Route("/{id}/edit-child", name="menu_edit_child")
     * @Method("GET")
     * @Template()
     */
    public function editChildAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CMSBundle:Menu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
        }

        $menuParent = $em->getRepository('CMSBundle:Menu')->getParent($id);
        $menuParent = $menuParent->getFirstMenuParents()->getParent()->getId();

        return array(
            'entity' => $entity,
            'menuParent' => $menuParent,
            'pageId' => $id,
        );
    }

}
