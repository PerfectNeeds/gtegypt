<?php

namespace MD\Bundle\CMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClientType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', null, array('label' => 'Page Title'))
                ->add('htmlSlug', null, array('label' => 'Html Slug', 'attr' => array('class' => 'slug')))
                ->add('htmlMeta', 'textarea', array('label' => ' Meta Tags Data'))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'MD\Bundle\CMSBundle\Entity\Client'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'md_bundle_cmsbundle_client';
    }

}
