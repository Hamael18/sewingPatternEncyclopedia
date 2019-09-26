<?php

namespace App\Form;

use App\Entity\Brand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class BrandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Libellé de la marque'],
            ])
            ->add('url', UrlType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Party-link de la marque'],
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Sélectionnez une image'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Brand::class,
        ]);
    }
}
