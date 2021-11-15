<?php

namespace MD\Bundle\MediaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SingleImageType extends AbstractType {

    public $name = 'file';

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->
                add($this->name, 'file', array(
                    "required" => FALSE,
                    "attr" => array(
                        "accept" => "image/*",
                    )
                ))
                ->getForm();
    }

    public function getName() {
        return '';
    }

}
