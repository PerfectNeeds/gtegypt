<?php

namespace MD\Bundle\CMSBundle\Controller\FrontEnd;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MD\Bundle\CMSBundle\Entity\DynamicPage;
use MD\Utils\Url;

/**
 * DynamicPage controller.
 *
 * @Route("/page")
 */
class MenuController extends Controller {

    private $em;

    function __construct($entityManager = NULL) {
        if ($entityManager == NULL) {
            $this->em = $this->getDoctrine()->getManager();
        } else {
            $this->em = $entityManager;
        }
    }

    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/menu", name="fe_dynamicpage_menu")
     * @Method("GET")
     * @Template()
     */
    public function menuAction() {

        return array(
        );
    }

    /**
     *
     * @param object $menu
     * @param bool $parent
     * @return string
     */
    public function menuItem($menu, $parent = FALSE, $tabId = FALSE) {
        if ($parent == FALSE) {
            if (count($menu->getMenuItems()) > 0) {
                switch ($menu->getFirstMenuItems()->getTarget()) {
                    case \MD\Bundle\CMSBundle\Entity\MenuItem::INTERNAL:
                        $target = '';

                        $lastParmCurrentUrl = Url::addGetLastParamInUrl();
                        $url = $menu->getFirstMenuItems()->getUrl();
                        $lastParmUrl = Url::addGetLastParamInUrl($url);
                        $html = ($lastParmCurrentUrl == $lastParmUrl) ? '<li class="active">' : '<li>';
                        $html .= '<a href="' . Url::addGetParamToUrl($url, 't', $tabId) . '" ' . $target . '>' . $menu->getName() . '</a>';
                        break;
                    case \MD\Bundle\CMSBundle\Entity\MenuItem::EXTERNAL:
                        $html = '<li>';
                        $target = 'target="_blank"';
                        $html .= '<a href="' . $menu->getFirstMenuItems()->getUrl() . '" ' . $target . '>' . $menu->getName() . '</a>';
                        break;
                }
            } else {
                $html = '<li>';
                $html .= '<a href="#">' . $menu->getName() . '</a>';
            }
            $html .='</li>';
        } else {
            $html = '<a href="#">' . $menu->getName() . '</a>';
        }
        return $html;
    }

    public function recursiveMenu($parents = FALSE, $tabId = FALSE) {
        $html = '';

        if ($parents == FALSE) {
            $html = '<ul class="real-estate-cats-widget effect-slide-left in" data-effect="slide-left" style="transition: all 0.7s ease-in-out 0s;">';
            if ($tabId == FALSE) {
                echo 'enter tabId';
                exit;
            }
            $nods = $this->em->getRepository('CMSBundle:Menu')->getParentsByTabId($tabId);
        } else {
            for ($i = 0; $i < count($parents->getMenuParents()); $i++) {
                $parent = $parents->getMenuParents();
                if ($parent[$i]->getChild()->getDeleted() == FALSE) {
                    $nods[$i] = $parent[$i]->getChild();
                }
            }

            if (!isset($nods)) {
                $nods = array();
            }
        }

        if (count($nods) > 0 AND $nods != FALSE) {
            foreach ($nods as $nod) {
                if (count($nod->getMenuParents()) > 0) {
                    $html .='<li>' . $this->menuItem($nod, TRUE);
                    $html .= '<ul>';
                    $html .= $this->recursiveMenu($nod, $tabId);
                    $html .= '</ul></li>';
                } else {

                    $html .= $this->menuItem($nod, FALSE, $tabId);
                }
            }
        } else {
            return FALSE;
        }

        $html . '</ul>';
        return $html;
    }

}
