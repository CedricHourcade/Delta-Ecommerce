<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom',
                'constraints' => new Length([
                    'min' => 1,
                    'max' => 30,
                    'minMessage' => 'Votre prénom doit contenir minimum 1 caractères',
                    'maxMessage' => 'Votre prénom doit contenir maximum 30 caractères'
                ]),
                'attr' => [
                    'placeholder' => 'Entrer votre prénom'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom',
                'constraints' => new Length([
                    'min' => 1,
                    'max' => 30,
                    'minMessage' => 'Votre nom doit contenir minimum 1 caractères',
                    'maxMessage' => 'Votre nom doit contenir maximum 30 caractères'
                ]),
                'attr' => [
                    'placeholder' => 'Entrer votre nom'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'constraints' => new Length([
                    'min' => 1,
                    'max' => 30,
                    'minMessage' => 'Votre email doit contenir minimum 1 caractères',
                    'maxMessage' => 'Votre email doit contenir maximum 30 caractères'
                ]),
                'attr' => [
                    'placeholder' => 'Entrer votre adresse email'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identique',
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 30,
                    'minMessage' => 'Votre mot de passe doit contenir minimum 1 caractères',
                    'maxMessage' => 'Votre mot de passe doit contenir maximum 30 caractères'
                ]),
                'label' => 'Mot de passe',
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'placeholder' => "Entrer votre mot de passe"
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmez votre mot de passe',
                    'attr' => [
                        'placeholder' => 'Confirmez votre mot de passe'
                    ]
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "S'inscrire"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
