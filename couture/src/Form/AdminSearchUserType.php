<?php


namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class AdminSearchUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [new Length(['min' => 3]), new NotBlank([])]
            ])
            ->add('role', ChoiceType::class, [
                'label' => false,
                'required' => false,
                'multiple' => true,
                'choices' => ['ADMIN' => 'ROLE_ADMIN', 'MARQUE' => 'ROLE_MARQUE', 'USER' => 'ROLE_USER']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null
        ]);
    }
}
