<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre Nom',
                "attr"=>[
                    "desabled"=>true
                ]
            ])
            ->add('lastename',TextType::class,[
                'label' => 'Votre Prenom',
                "attr"=>[
                    "desabled"=>true
                ]
            ])

            ->add('email',EmailType::class,[
                'label' => 'Votre Email',
                "attr"=>[
                    "desabled"=>true
                ]
            ])


            ->add('old_password',PasswordType::class,[
                'label' => 'old_password',
                "mapped" =>false,
                "attr" =>[
                    "desabled"=>true,
                ]
            ])

            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                "mapped" =>false,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
            ])
            ->add('save', SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
