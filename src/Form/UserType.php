<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

              ->add('fullName', TextType::class, [
                'attr' =>[
                    'class' =>'form-control',
                    'minLength' =>'2',
                    'maxLength' => '50'
                ],
                'label' => 'Nom/Prenom',
                'label_attr'=> [
                    'class' =>'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 50])
                ]
            ])
            ->add('pseudo', TextType::class , [
                'attr' =>[
                    'class' =>'form-control',
                    'minLength' =>'2',
                    'maxLength' => '50',
                    'require'=> false,
                ],

                'label' => 'Pseudo (Facultative)',
                'label_attr'=> [
                    'class' =>'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 50])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
