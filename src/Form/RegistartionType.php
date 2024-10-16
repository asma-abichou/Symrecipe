<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class RegistartionType extends AbstractType
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
                    'maxLength' => '50'
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
            ->add('email', EmailType::class, [
                'attr' =>[
                    'class' =>'form-control',
                    'minLength' =>'2',
                    'maxLength' => '180'
                ],
                'label' => 'Email ',
                'label_attr'=> [
                    'class' =>'form-label mt-4'
                ],
                 'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(['min' => 2, 'max' => 180]),
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Mot de passe',
                ],
                'second_options' => [
                    'label' => 'Confirmation mot de passe',
                ],
                'invalid_message' => 'Mot de passe ne correspondent pas ',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 180]),

                ]
            ])
            ->add('submit', SubmitType::class,[
                    'attr'=> [
                        'class' => 'btn btn-primary mt-4'
                    ],
                    'label' => 'Mdifier ma recette'
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
