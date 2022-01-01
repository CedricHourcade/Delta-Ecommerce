<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', TextType::class, [
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
            ->add('nom', TextType::class, [
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
            ->add('content', TextareaType::class, [
                'label' => 'Votre message',
                'attr' => [
                    'placeholder' => 'En quoi pouvons-nous vous aider ?'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Envoyer",
                'attr' => [
                    'class' => 'btn-block btn-success'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
