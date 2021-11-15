<?php

namespace MD\Bundle\CMSBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use \Twig_Extension;

class VarsExtension extends Twig_Extension {

    private $container;
    private $em;
    private $conn;

    public function __construct(\Doctrine\ORM\EntityManager $em, ContainerInterface $container) {
        $this->em = $em;
        $this->conn = $em->getConnection();
        $this->container = $container;
    }

    public function getName() {
        return 'some.extension';
    }

    public function getFilters() {
        return array(
            'twigMenu' => new \Twig_Filter_Method($this, 'twigMenu'),
            'json_decode' => new \Twig_Filter_Method($this, 'jsonDecode'),
            'array_pop' => new \Twig_Filter_Method($this, 'arrayPop'),
            'arabic_date_format' => new \Twig_Filter_Method($this, 'arabicDateFormat'),
            new \Twig_SimpleFilter('localizeddate', array($this, 'twigLocalizedDateFilter'), array('needs_environment' => true)),
        );
    }

    public function twigMenu($tabId) {
        $em = $this->em;

        $menu = new \MD\Bundle\CMSBundle\Controller\FrontEnd\MenuController($em);
        return $menu->recursiveMenu(FALSE, $tabId);
    }

}
