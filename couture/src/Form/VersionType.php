<?php

namespace App\Form;

use App\Entity\Collar;
use App\Entity\Fabric;
use App\Entity\Handle;
use App\Entity\Length;
use App\Entity\Level;
use App\Entity\Pattern;
use App\Entity\Size;
use App\Entity\Style;
use App\Entity\Version;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class VersionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => "Libellé de la version"]
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Sélectionnez une image']
            ])
            ->add('pattern', EntityType::class, [
                'label' => false,
                'class' => Pattern::class,
                'attr' => [
                    'class' => 'selectpicker',
                    'data-live-search' => true,
                    'data-none-selected-text' => 'Choisir un patron de couture'
                ]
            ])
            ->add('collar', EntityType::class, [
                'label' => false,
                'class' => Collar::class,
                'required' => false,
                'attr' => [
                    'class' => 'selectpicker',
                    'data-live-search' => true,
                    'data-none-selected-text' => 'Choisir un type de col'
                ]
            ])
            ->add('length', EntityType::class, [
                'label' => false,
                'class' => Length::class,
                'required' => false,
                'attr' => [
                    'class' => 'selectpicker',
                    'data-live-search' => true,
                    'data-none-selected-text' => 'Choisir une longueur'
                ]
            ])
            ->add('handle', EntityType::class, [
                'label' => false,
                'class' => Handle::class,
                'required' => false,
                'attr' => [
                    'class' => 'selectpicker',
                    'data-live-search' => true,
                    'data-none-selected-text' => 'Choisir un type de manches'
                ]
            ])
            ->add('sizeMin', EntityType::class, [
                'label' => false,
                'class' => Size::class,
                'required' => false,
                'attr' => [
                    'class' => 'selectpicker',
                    'data-live-search' => true,
                    'data-none-selected-text' => 'Choisir une taille minimale'
                ]
            ])
            ->add('sizeMax', EntityType::class, [
                'label' => false,
                'class' => Size::class,
                'required' => false,
                'attr' => [
                    'class' => 'selectpicker',
                    'data-live-search' => true,
                    'data-none-selected-text' => 'Choisir une taille maximale'
                ]
            ])
            ->add('level', EntityType::class, [
                'label' => false,
                'class' => Level::class,
                'attr' => [
                    'class' => 'selectpicker',
                    'data-live-search' => true,
                    'data-none-selected-text' => 'Choisir un niveau de difficulté'
                ]
            ])
            ->add('fabric', EntityType::class, [
                'label' => false,
                'class' => Fabric::class,
                'required' => false,
                'attr' => [
                    'class' => 'selectpicker',
                    'data-live-search' => true,
                    'data-none-selected-text' => 'Choisir un type de tissu'
                ]
            ])
            ->add('style', EntityType::class, [
                'label' => false,
                'class' => Style::class,
                'required' => false,
                'attr' => [
                    'class' => 'selectpicker',
                    'data-live-search' => true,
                    'data-none-selected-text' => 'Choisir un style'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Version::class,
        ]);
    }
}
