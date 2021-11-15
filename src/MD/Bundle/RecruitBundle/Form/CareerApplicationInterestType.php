<?php

namespace MD\Bundle\RecruitBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CareerApplicationInterestType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('level')
            ->add('careerApplication')
            ->add('careerInterest')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MD\Bundle\RecruitBundle\Entity\CareerApplicationInterest'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'md_bundle_recruitbundle_careerapplicationinterest';
    }
}
