<?php

namespace MD\Bundle\CMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BlogType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title')
                ->add('htmlSlug', 'text', array(
                    'attr' => array('class' => 'slug'),
                    "label" => 'Html Slug'
                ))
                ->add('htmlMeta', 'textarea', array(
                    "label" => 'Html Meta'
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'MD\Bundle\CMSBundle\Entity\Blog'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'md_bundle_cmsbundle_blog';
    }

}
