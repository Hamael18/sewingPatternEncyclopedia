<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class SearchUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('roles', ChoiceType::class, [
                'label' => false,
                'required' => false,
                'multiple' => true,
                'choices' => ['Admin' => 'ROLE_ADMIN', 'Marque' => 'ROLE_MARQUE', 'User' => 'ROLE_USER'],
            ])
            ->add('email', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Email'],
                'constraints' => [new Length(['min' => 3])],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
