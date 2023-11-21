<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ImageUploadType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'required' => false,
            'allow_delete' => false,
            'download_uri' => false,
            // Add any other common options you want to set
//            'delete_label' => 'delete',
//            'download_label' => 'download',
//            'image_uri' => true,
//            'imagine_pattern' => '...',
//            'asset_helper' => true,
        ]);
    }

    public function getParent()
    {
        return VichImageType::class;
    }
}