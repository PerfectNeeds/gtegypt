<?php

namespace MD\Bundle\RecruitBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CurrentVacancyType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name')
                ->add('htmlSlug', 'text', array(
                    'attr' => array('class' => 'slug'),
                    "label" => 'Html Slug'
                ))
                ->add('positionCode')
                ->add('location')
                ->add('industry')
                ->add('serviceLine')
                ->add('typeOfPosition')
                ->add('levelOfExperience')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'MD\Bundle\RecruitBundle\Entity\CurrentVacancy'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'md_bundle_recruitbundle_currentvacancy';
    }

}
