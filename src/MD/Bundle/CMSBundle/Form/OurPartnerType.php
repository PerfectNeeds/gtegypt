<?php

namespace MD\Bundle\CMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OurPartnerType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', null, array('label' => 'Page Title'))
                ->add('position', null, array('label' => 'Position'))
                ->add('telephone', null, array('label' => 'Telephone'))
                ->add('email', null, array('label' => 'Email'))
                ->add('htmlSlug', null, array('label' => 'Html Slug', 'attr' => array('class' => 'slug')))
//                ->add('content', 'textarea', array('label' => 'Page Content', 'attr' => array('class' => 'tinymce', 'data-theme' => 'simple')))
                ->add('htmlTitle', null, array('label' => 'Html Title'))
                ->add('htmlMeta', 'textarea', array('label' => ' Meta Tags Data'))
//                ->add('flag', NULL, array('required' => false))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'MD\Bundle\CMSBundle\Entity\OurPartner'
        ));
    }

    public function getName() {
        return 'ourpartnertype';
    }

}
