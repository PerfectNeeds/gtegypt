<?php

namespace MD\Bundle\CMSBundle\Controller\Administration;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MD\Bundle\CMSBundle\Entity\OurPartner;
use MD\Bundle\CMSBundle\Form\OurPartnerType;
use Symfony\Component\HttpFoundation\Response;
use MD\Bundle\MediaBundle\Entity\Image as Image;

/**
 * OurPartner controller.
 *
 * @Route("/our-partner")
 */
class OurPartnerController extends Controller {

    /**
     * Lists all OurPartner entities.
     *
     * @Route("/", name="ourpartner")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CMSBundle:OurPartner')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new OurPartner entity.
     *
     * @Route("/", name="ourpartner_create")
     * @Method("POST")
     * @Template("CMSBundle:Administration/OurPartner:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new OurPartner();
        $form = $this->createForm(new OurPartnerType(), $entity);
        $form->bind($request);
        if ($form->isValid()) {
            $description = $this->getRequest()->request->get('description');
            $content = array("description" => $description);
            $entity->setContent($content);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('ourpartner_edit', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new OurPartner entity.
     *
     * @Route("/new", name="ourpartner_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new OurPartner();
        $form = $this->createForm(new OurPartnerType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing OurPartner entity.
     *
     * @Route("/{id}/edit", name="ourpartner_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CMSBundle:OurPartner')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OurPartner entity.');
        }
//        $content = array("description" => $entity->getContent());
//        $entity->setContent(stripslashes(json_encode($content)));
        $entity->setHtmlMeta(stripslashes($entity->getHtmlMeta()));
        $image = $entity->getMainImage();
        $uploadForm = $this->createForm(new \MD\Bundle\MediaBundle\Form\ImageType());
        $formView = $uploadForm->createView();
        //     $formView->getChild('files')->set('full_name', 'files[]');
        $editForm = $this->createForm(new OurPartnerType(), $entity);
        $deleteForm = $this->createDeleteForm($id);
        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'image' => $image,
            'mainType' => \MD\Bundle\MediaBundle\Entity\Image::TYPE_MAIN,
            'upload_form' => $formView,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing OurPartner entity.
     *
     * @Route("/{id}", name="ourpartner_update")
     * @Method("PUT")
     * @Template("CMSBundle:Administration/OurPartner:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CMSBundle:OurPartner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OurPartner entity.');
        }

        $uploadForm = $this->createForm(new \MD\Bundle\MediaBundle\Form\ImageType());
        $formView = $uploadForm->createView();
        $uploadForm->bind($request);
        $data_upload = $uploadForm->getData();
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new OurPartnerType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $description = $this->getRequest()->request->get('description');
            $content = array("description" => $description);
            $entity->setContent($content);
            $em->persist($entity);
            $em->flush();
            //}

            return $this->redirect($this->generateUrl('ourpartner'));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'upload_form' => $formView,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a OurPartner entity.
     *
     * @Route("/delete", name="ourpartner_delete")
     * @Method("POST")
     */
    public function deleteAction() {
        $cantDelete = array(1, 2, 3, 4);

        $id = $this->getRequest()->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:OurPartner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OurPartner entity.');
        }

        if (in_array($entity->getId(), $cantDelete)) {
            $entities = $em->getRepository('CMSBundle:OurPartner')->findAll();

            return $this->render('CMSBundle:Administration/OurPartner:index.html.twig', array(
                        'errors' => 'Can\'t delete this page',
                        'entities' => $entities,
            ));
        }
        $em->remove($entity);
        $em->flush();
        return $this->redirect($this->generateUrl('ourpartner'));
    }

    /**
     * Creates a form to delete a OurPartner entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm()
        ;
    }

    /**
     * Set Images to Property.
     *
     * @Route("/gallery/{id}" , name="ourpartner_create_images")
     * @Method("POST")
     */
    public function SetImageAction(Request $request, $id) {
        $form = $this->createForm(new \MD\Bundle\MediaBundle\Form\ImageType());
        $formView = $form->createView();
        $form->bind($request);

        $data = $form->getData();
        $files = $data["files"];

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:OurPartner')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Landmark entity.');
        }

        $imageType = $request->get("type");
        foreach ($files as $file) {
            if ($file != NULL) {
                $image = new \MD\Bundle\MediaBundle\Entity\Image();
                $em->persist($image);
                $em->flush();
                $image->setFile($file);
                $mainImages = $entity->getImages(array(\MD\Bundle\MediaBundle\Entity\Image::TYPE_MAIN));
                if ($imageType == Image::TYPE_MAIN && count($mainImages) > 0) {
                    foreach ($mainImages As $mainImage) {
                        $entity->removeImage($mainImage);
                        $em->persist($entity);
                        $em->flush();
                        $image->storeFilenameForRemove("ourpartners/" . $entity->getId());
                        $image->removeUpload();
//                        $image->storeFilenameForResizeRemove("suppliers/" . $entity->getId());
//                        $image->removeResizeUpload();
                        $em->persist($mainImage);
                        $em->flush();
                        $em->remove($mainImage);
                        $em->flush();
                        $image->setImageType(Image::TYPE_MAIN);
                    }
                } else if ($imageType == \MD\Bundle\MediaBundle\Entity\Image::TYPE_MAIN && count($mainImages) == 0) {
                    $image->setImageType(Image::TYPE_MAIN);
                } else {
                    $image->setImageType(Image::TYPE_GALLERY);
                }


                $image->preUpload();
                $image->upload("ourpartners/" . $id);
                $image->setImageType(\MD\Bundle\MediaBundle\Entity\Image::TYPE_MCE);
                $entity->addImage($image);
                $imageUrl = \AppKernel::projectRoot . "web/uploads/ourpartners/" . $id . "/" . $image->getId();
                $imageId = $image->getId();
            }
            $em->persist($entity);
            $em->flush();
            $files = '{"files":[{"url":"' . $imageUrl . '","thumbnailUrl":"http://lh6.ggpht.com/0GmazPJ8DqFO09TGp-OVK_LUKtQh0BQnTFXNdqN-5bCeVSULfEkCAifm6p9V_FXyYHgmQvkJoeONZmuxkTBqZANbc94xp-Av=s80","name":"test","id":"' . $imageId . '","type":"image/jpeg","size":620888,"deleteUrl":"http://localhost/packagat/web/uploads/packages/1/th71?delete=true","deleteType":"DELETE"}]}';
            $response = new Response();
            $response->setContent($files);
            $response->setStatusCode(200);
            return $response;
        }

        return array(
            'form' => $formView,
            'id' => $id,
        );
    }

    /**
     * Deletes a PropertyGallery entity.
     *
     * @Route("/deleteimage/{h_id}/{redirect_id}", name="ourpartnerimages_delete")
     * @Method("POST")
     */
    public function deleteImageAction($h_id, $redirect_id) {
        $image_id = $this->getRequest()->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:OurPartner')->find($h_id);
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
        $image->storeFilenameForRemove("ourpartners/" . $h_id);
        $image->removeUpload();
//        $image->storeFilenameForResizeRemove("ourpartners/" . $h_id);
//        $image->removeResizeUpload();
        $em->persist($image);
        $em->flush();
        $em->remove($image);
        $em->flush();

        if ($redirect_id == 1) {
            return $this->redirect($this->generateUrl('ourpartner_edit', array('id' => $h_id)));
        } else if ($redirect_id == 2) {
            return $this->redirect($this->generateUrl('ourpartner_edit', array('id' => $h_id)));
        }
    }

    /**
     * Displays a form to create a new PropertyGallery entity.
     *
     * @Route("/document/{id}", name="ourpartner_set_documents")
     * @Method("GET")
     * @Template()
     */
    public function GetDocumentsAction($id, $documentTypes = NULL) {
        $form = $this->createForm(new \MD\Bundle\MediaBundle\Form\DocumentType());
        $formView = $form->createView();
//        $formView->getChild('files')->set('full_name', 'files[]');
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CMSBundle:OurPartner')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OurPartner entity...');
        }
        $ourPartner = $em->getRepository('CMSBundle:OurPartner')->find($id);
        $documents = $ourPartner->getDocuments();
        return array(
            'entity' => $entity,
            'form' => $formView,
            'documents' => $documents
        );
    }

    /**
     * Deletes a PropertyGallery entity.
     *
     * @Route("/deletedocument/{h_id}/{redirect_id}", name="ourpartnerdocuments_delete")
     * @Method("POST")
     */
    public function deleteDocumentAction($h_id, $redirect_id) {
        $document_id = $this->getRequest()->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:OurPartner')->find($h_id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OurPartner entity.');
        }
        $document = $em->getRepository('MediaBundle:Document')->find($document_id);
        if (!$document) {
            throw $this->createNotFoundException('Unable to find OurPartner entity.');
        }
        $entity->removeDocument($document);
        $em->persist($entity);
        $em->flush();
        $document->storeFilenameForRemove("ourpartners/document/" . $h_id);
        $document->removeUpload();
//        $document->storeFilenameForResizeRemove("ourpartners/document/" . $h_id);
        $em->persist($document);
        $em->flush();
        $em->remove($document);
        $em->flush();

        if ($redirect_id == 1) {
            return $this->redirect($this->generateUrl('ourpartner_set_documents', array('id' => $h_id)));
        } else if ($redirect_id == 2) {
            return $this->redirect($this->generateUrl('ourpartner_edit', array('id' => $h_id)));
        }
    }

    /**
     * Set Documents to Property.
     *
     * @Route("/document/{id}" , name="ourpartner_create_documents")
     * @Method("POST")
     */
    public function SetDocumentAction(Request $request, $id) {
        $form = $this->createForm(new \MD\Bundle\MediaBundle\Form\DocumentType());
        $formView = $form->createView();
        $form->bind($request);

        $data = $form->getData();
        $files = $data["files"];
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:OurPartner')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OurPartner entity.');
        }
        foreach ($files as $file) {
            if ($file != NULL) {
                $document = new \MD\Bundle\MediaBundle\Entity\Document($file);
                $em->persist($document);
                $em->flush();
//                $document->setFile($file);
                $document->preUpload();
                $document->upload("ourpartners/document/" . $id);
                $entity->addDocument($document);
                $documentUrl = \AppKernel::projectRoot . "web/uploads/ourpartners/document/" . $id . "/" . $document->getId();
                $documentId = $document->getId();
                $documentName = $document->getName();
            }
            $em->persist($entity);
            $em->flush();
            $files = '{"files":[{"url":"' . $documentUrl . '","thumbnailUrl":"' . $documentUrl . '","name":"' . $documentName . '","id":"' . $documentId . '","type":"document/jpeg","size":620888,"deleteUrl":"http://localhost/packagat/web/uploads/packages/1/th71?delete=true","deleteType":"DELETE"}]}';
            $response = new Response();
            $response->setContent($files);
            $response->setStatusCode(200);
            return $response;
        }

        return array(
            'form' => $formView,
            'id' => $id,
        );
    }

}
