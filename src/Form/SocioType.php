<?php

namespace App\Form;

use App\Entity\Socio;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class SocioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', Texttype::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 1, 'max' => 255]),
                    new Regex(['pattern' => '/^[a-zA-Z ]+$/', 'message' => 'El nombre solo puede contener letras'])
                ]
            ])
            ->add('apellidos', Texttype::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 1, 'max' => 255]),
                    new Regex(['pattern' => '/^[a-zA-Z ]+$/', 'message' => 'Los apellidos solo pueden contener letras'])
                ]
            ])
            ->add('correo', EmailType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 5, 'max' => 255]),
                    new Email(),
                    new Regex(['pattern' => '/^[a-zA-Z0-9@. ]+$/', 'message' => 'El correo solo puede contener letras, números y los símbolos @ y .']),
                ],
            ])
            ->add('telefono', TelType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 8, 'max' => 10]),
                    new Regex(['pattern' => '/^[0-9]+$/', 'message' => 'El teléfono solo puede contener números']),
                ],
            ])
            ->add('direccion', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 1, 'max' => 255]),
                    new Regex(['pattern' => '/^[a-zA-Z0-9 ]+$/', 'message' => 'La dirección solo puede contener letras y números'])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Socio::class,
        ]);
    }
}
