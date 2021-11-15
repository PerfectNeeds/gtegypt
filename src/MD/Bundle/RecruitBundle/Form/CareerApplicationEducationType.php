<?php

namespace MD\Bundle\RecruitBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CareerApplicationEducationType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type')
            ->add('name')
            ->add('gradYear')
            ->add('institution')
            ->add('careerApplication')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MD\Bundle\RecruitBundle\Entity\CareerApplicationEducation'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'md_bundle_recruitbundle_careerapplicationeducation';
    }
}
