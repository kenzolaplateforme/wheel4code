<?php

namespace App\Form;

use App\Entity\Draw;
use App\Entity\User;
use Doctrine\DBAL\Types\StringType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
              'required' => false,
              'attr' => [
                'class' => "form-control mb-3"
              ]
            ])
            ->add('avatar', FileType::class, [
              'mapped' => false,
              'required' => false,
              'attr' => [
                'class' => "form-control mb-3"
              ]
            ])
            ->add('plainPassword', RepeatedType::class, [
              'attr' => [
                'class' => "form-control mb-3"
              ],
              'type' => PasswordType::class,
              'mapped' => false,
              'required' => false,
              'invalid_message' => 'Les mots de passe ne correspondent pas.',
              'options' => ['attr' => ['autocomplete' => 'new-password', 'class' => "form-control mb-3"]],
              'first_options'  => ['label' => 'Mot de passe'],
              'second_options' => ['label' => 'Confirmer le mot de passe'],
              'constraints' => [
                  new Length([
                      'min' => 6,
                      'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                      'max' => 4096,
                  ]),
              ],
          ])
            ->add('save', SubmitType::class, [
              'label' => "Enregistrer",
              'attr' => [
                'class' => "btn btn-primary"
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
