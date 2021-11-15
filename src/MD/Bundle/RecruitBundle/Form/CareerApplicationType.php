<?php

namespace MD\Bundle\RecruitBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CareerApplicationType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('positionCode')
                ->add('country')
                ->add('fullName')
                ->add('email')
                ->add('birthDate')
                ->add('landLine')
                ->add('cellular')
                ->add('address')
                ->add('city')
                ->add('currentPosition')
                ->add('reportingTo')
                ->add('company')
                ->add('jobDescription')
                ->add('documents')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'MD\Bundle\RecruitBundle\Entity\CareerApplication'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'md_bundle_recruitbundle_careerapplication';
    }

}
