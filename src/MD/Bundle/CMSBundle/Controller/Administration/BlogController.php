<?php

namespace MD\Bundle\CMSBundle\Controller\Administration;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MD\Bundle\CMSBundle\Entity\Blog;
use MD\Bundle\CMSBundle\Form\BlogType;
use MD\Bundle\MediaBundle\Entity As MediaEntity;
use MD\Bundle\MediaBundle\Form As MediaForm;

/**
 * Blog controller.
 *
 * @Route("/blog")
 */
class BlogController extends Controller {

    /**
     * Lists all Blog entities.
     *
     * @Route("/{cId}", name="blog")
     * @Method("GET")
     * @Template()
     */
    public function indexAction($cId) {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CMSBundle:Blog')->findBy(array('blogCategory' => $cId, 'deleted' => FALSE));
        $blogCategory = $em->getRepository('CMSBundle:BlogCategory')->find($cId);

        return array(
            'entities' => $entities,
            'blogCategory' => $blogCategory,
        );
    }

    /**
     * Creates a new Blog entity.
     *
     * @Route("/{cId}", name="blog_create")
     * @Method("POST")
     * @Template("CMSBundle:Administration/Blog:new.html.twig")
     */
    public function createAction(Request $request, $cId) {
        $entity = new Blog();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $blogCategory = $em->getRepository('CMSBundle:BlogCategory')->find($cId);

        $uploadForm = $this->createForm(new MediaForm\SingleImageType());
        $formView = $uploadForm->createView();
        $uploadForm->bind($request);
        $data_upload = $uploadForm->getData();
        $file = $data_upload["file"];
//        $form->bind($request);

        $description = $this->getRequest()->request->get('description');
        $brief = $this->getRequest()->request->get('brief');
        $contentArray = array("description" => $description, "brief" => $brief);
        $entity->setBlogCategory($blogCategory);
        $entity->setContent($contentArray);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $blogId = $entity->getId();
            $image = new MediaEntity\Image();
            $em->persist($image);
            $em->flush();
            $image->setFile($file);
            $image->setImageType(MediaEntity\Image::TYPE_GALLERY);
            $image->preUpload();
            $image->upload("blog/" . $blogId);
            $entity->setImage($image);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('blog', array('cId' => $blogCategory->getId())));
        }

        return array(
            'entity' => $entity,
            'blogCategory' => $blogCategory,
            'form' => $form->createView(),
            'upload_form' => $formView,
        );
    }

    /**
     * Creates a form to create a Blog entity.
     *
     * @param Blog $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Blog $entity) {
        $form = $this->createForm(new BlogType(), $entity, array(
            'method' => 'POST',
        ));


        return $form;
    }

    /**
     * Displays a form to create a new Blog entity.
     *
     * @Route("/new/{cId}", name="blog_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($cId) {
        $entity = new Blog();
        $form = $this->createCreateForm($entity);
        $uploadForm = $this->createForm(new \MD\Bundle\MediaBundle\Form\SingleImageType());
        $formView = $uploadForm->createView();

        $em = $this->getDoctrine()->getManager();
        $blogCategory = $em->getRepository('CMSBundle:BlogCategory')->find($cId);

        return array(
            'entity' => $entity,
            'blogCategory' => $blogCategory,
            'form' => $form->createView(),
            'upload_form' => $formView,
        );
    }

    /**
     * Displays a form to edit an existing Blog entity.
     *
     * @Route("/{id}/edit", name="blog_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CMSBundle:Blog')->find($id);
        $image = $entity->getImage();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Blog entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        $uploadForm = $this->createForm(new MediaForm\SingleImageType());
        $formView = $uploadForm->createView();

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'upload_form' => $formView,
            'image' => $image
        );
    }

    /**
     * Creates a form to edit a Blog entity.
     *
     * @param Blog $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Blog $entity) {
        $form = $this->createForm(new BlogType(), $entity, array(
            'action' => $this->generateUrl('blog_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));


        return $form;
    }

    /**
     * Edits an existing Blog entity.
     *
     * @Route("/{id}", name="blog_update")
     * @Method("PUT")
     * @Template("CMSBundle:Blog:Administration/edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CMSBundle:Blog')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Blog entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        $uploadForm = $this->createForm(new \MD\Bundle\MediaBundle\Form\SingleImageType());
        $formView = $uploadForm->createView();
        $uploadForm->bind($request);
        $data_upload = $uploadForm->getData();
        $file = $data_upload["file"];
//        $editForm = $this->createForm(new BannerType(), $entity);
//        $editForm->bind($request);

        $description = $this->getRequest()->request->get('description');
        $brief = $this->getRequest()->request->get('brief');
        $contentArray = array("description" => $description, "brief" => $brief);
        $entity->setContent($contentArray);

        if ($editForm->isValid()) {
            if ($file != null) {
                $oldImage = $entity->getImage();
                if ($oldImage) {
                    $oldImage->storeFilenameForRemove("blog/" . $id);
                    $oldImage->removeUpload();
                    $em->persist($oldImage);
                    $em->persist($entity);
                }
                $image = new MediaEntity\Image();
                $em->persist($image);
                $em->flush();
                $image->setFile($file);
                $image->setImageType(MediaEntity\Image::TYPE_GALLERY);
                $image->preUpload();
                $image->upload("blog/" . $id);
                $entity->setImage($image);
            }
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('blog_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'upload_form' => $formView,
        );
    }

    /**
     * Deletes a Blog entity.
     *
     * @Route("/delete/{cId}", name="blog_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $cId) {
        $id = $this->getRequest()->request->get('id');
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:Blog')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Blog entity.');
        }

        $entity->setDeleted(TRUE);
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('blog', array('cId' => $entity->getBlogCategory()->getId())));
    }

    /**
     * Creates a form to delete a Blog entity by id.
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

    /**
     * Deletes a PropertyGallery entity.
     *
     * @Route("/deleteimage/{h_id}/{redirect_id}", name="blogimages_delete")
     * @Method("POST")
     */
    public function deleteImageAction($h_id, $redirect_id) {
        $image_id = $this->getRequest()->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:Blog')->find($h_id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TourGallery entity.');
        }
        $image = $em->getRepository('MediaBundle:Image')->find($image_id);
        if (!$image) {
            throw $this->createNotFoundException('Unable to find TourGallery entity.');
        }
        $entity->removeImage($image);
        $em->persist($entity);
        $em->flush();
        $image->storeFilenameForRemove("blogs/" . $h_id);
        $image->removeUpload();
//        $image->storeFilenameForResizeRemove("blogs/" . $h_id);
//        $image->removeResizeUpload();
        $em->persist($image);
        $em->flush();
        $em->remove($image);
        $em->flush();

        if ($redirect_id == 1) {
            return $this->redirect($this->generateUrl('blog_edit', array('id' => $h_id)));
        } else if ($redirect_id == 2) {
            return $this->redirect($this->generateUrl('blog_edit', array('id' => $h_id)));
        }
    }

}
