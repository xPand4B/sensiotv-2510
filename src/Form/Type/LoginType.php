<?php

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints as Assert;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => 'Email address',
                'constraints' => [
                    new Assert\Email(),
                    new Assert\Length(200),
                ],
            ])
            ->add('password', PasswordType::class, [
                'required' => true,
                'label' => 'Password',
                'constraints' => [
                    new Assert\NotBlank(),
                    new UserPassword(),
                ],
            ])
            ->add('remember_me', CheckboxType::class, [
                'label' => 'Remember me',
                'constraints' => [
                    new UserPassword(),
                    new Assert\IsTrue(),
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Sign in',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}