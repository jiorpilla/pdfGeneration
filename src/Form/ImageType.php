<?php

namespace App\Form;

use App\Entity\Images;
use App\Form\Type\ImageUploadType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageFile', ImageUploadType::class, [
                // Add any other options specific to ImageUploadType
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Images::class,
            "allow_extra_fields" => true,
        ]);
    }
}