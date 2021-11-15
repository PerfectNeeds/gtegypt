<?php

namespace MD\Bundle\ServiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Download controller.
 *
 * @Route("/download")
 */
class DownloadController extends Controller {

    private $file;
    private $documentId; // document id from document Entity
    private $elementId; // this var is elemnet id like (blog, dynamic page)
    private $type; // this var is download file type like (CONST BANNER, CONST DYNAMIC_PAGES, etc...)
    private $path = array(
        '11' => 'uploads/curriculum-vitae/%s/%s', //curriculum-vitae
        '12' => 'uploads/dynamicpages/document/%s/%s', //dynamicpages
        '13' => 'uploads/publications/document/%s/%s', //dynamicpages
    );

    public function __construct() {
        $request = Request::createFromGlobals();
        $getParameter = $request->query->get('d'); // ex: {{ path('download', {'d': '{"document":'~document.id~',"element":'~entity.id~',"type":12}'}) }}
        $parameter = json_decode($getParameter, true);
        $this->documentId = $parameter['document'];
        $this->elementId = $parameter['element'];
        $this->type = $parameter['type'];
        $this->file = sprintf($this->path[$this->type], $this->elementId, $this->documentId);
    }

    private function getMimeType() {
        return mime_content_type($this->file);
    }

    function guessFileExtension() {

        $mimeTypes = array(
            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',
            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',
            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',
            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',
            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',
            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',
            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        if (in_array($this->getMimeType(), $mimeTypes)) {
            return array_search($this->getMimeType(), $mimeTypes);
        } else {
            return FALSE;
        }
    }

    public function getDownloadName() {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MediaBundle:Document')->find($this->documentId);
        if ($entity->getExtension() == NULL) {
            $extension = $this->guessFileExtension();
        } else {
            $extension = $entity->getExtension();
        }

        return $entity->getName() . '.' . $extension;
    }

    /**
     * test page.
     *
     * @Route("/", name="download")
     * @Method("GET")
     * @Template()
     */
    public function DownloadAction() {

        // Generate response
        $response = new Response();

        // Set headers
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', $this->getMimeType());
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $this->getDownloadName() . '"');
        $response->headers->set('Content-length', filesize($this->file));
        $response->headers->set('Content-Transfer-Encoding', 'binary');

        // Send headers before outputting anything
        $response->sendHeaders();

        $response->setContent(readfile($this->file));

        return $response;
    }

}
