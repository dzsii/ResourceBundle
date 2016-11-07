<?php

namespace ThinkBig\Bundle\ResourceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use ThinkBig\Bundle\EntityTransformBundle\Form\Type\EntityHiddenType;

class FileType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        
        $resolver->setDefaults(array(
            'entry_type'        => EntityHiddenType::class, 
            'entry_options'     => array('label' => false, 'class' => 'ThinkBig\Bundle\ResourceBundle\Entity\File', 'field' => 'uid'),
            'allow_add'         => true,
            'allow_delete'      => true,
            'prototype'         => true,
            'mapped'            => false,
            'label'             => false,
            'attr'              => array('data-form-type' => 'file_resource')
        ));

    }

    public function getParent()
    {
        return CollectionType::class;
    }

    public function getName()
    {
        return 'file_resource';
    }
}
