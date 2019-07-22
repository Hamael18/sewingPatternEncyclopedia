<?php

namespace App\Form;

use App\Entity\Collar;
use App\Entity\Fabric;
use App\Entity\Handle;
use App\Entity\Length;
use App\Entity\Level;
use App\Entity\Size;
use App\Entity\Style;
use App\Entity\Version;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EmbedVersionType extends AbstractType
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
            ->add('collars', EntityType::class, [
                'label' => 'Type de col',
                'multiple'=> true,
                'class' => Collar::class,
                'required' => false
            ])
            ->add('lengths', EntityType::class, [
                'label' => 'Longueur',
                'multiple'=> true,
                'class' => Length::class,
                'required' => false
            ])
            ->add('handles', EntityType::class, [
                'label' => 'Type de manches',
                'multiple'=> true,
                'class' => Handle::class,
                'required' => false
            ])
            ->add('sizes', EntityType::class, [
                'label' => 'Taille(s)',
                'class' => Size::class,
                'multiple' => true,
                'expanded' => true
            ])
            ->add('level', EntityType::class, [
                'label' => 'Difficulté',
                'class' => Level::class
            ])
            ->add('fabrics', EntityType::class, [
                'label' => 'Tissu',
                'multiple'=> true,
                'class' => Fabric::class,
                'required' => false
            ])
            ->add('styles', EntityType::class, [
                'label' => 'Style',
                'multiple'=> true,
                'class' => Style::class,
                'required' => false
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
