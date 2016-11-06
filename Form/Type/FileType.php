<?php

namespace ThinkBig\Bundle\ResourceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class FileType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        
        $resolver->setDefaults(array(
            'type'      => 'entity_hidden', 
            'allow_add' => true,
            'allow_delete' => true,
            'prototype' => true,
            'mapped'    => false,
            'label' => false,
            'options' => array('label' => false, 'class' => 'ThinkBig\Bundle\ResourceBundle\Entity\File', 'field' => 'uid'),
            'attr' => array('data-form-type' => 'file_resource')
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
